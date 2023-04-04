<?php


namespace Themeco\Cornerstone\Tss;

use Themeco\Cornerstone\Parsy\Parser;
use Themeco\Cornerstone\Parsy\P;
use Themeco\Cornerstone\Parsy\ParseException;
use Themeco\Cornerstone\Parsy\ParserState;


function symbol( $str, $name = '' ) {
  // return P::regex("/{$str}\s*/")->name( $name ? $name : $str);
  return P::str($str)->name( $name ? $name : $str)->skip(P::whitespace());
}

function ws( $parser ) {
  return P::whitespace()->then($parser)->skip(P::whitespace());
}

function wsSymbol( $str, $name = '' ) {
  return ws(P::str($str)->name($name ? $name : $str));
}

function identifier( $parser ) {
  return (is_string( $parser ) ? P::str( $parser ) : $parser)->skip(P::whitespace());
}

function at($parser) {
  return P::str('@')->then(identifier($parser));
}

class StyleParser {

  const VALUE = 0;
  const OP = 1;

  // https://sass-lang.com/documentation/operators#order-of-operations
  protected $operator_precedence = [ '*' => 1, '/' => 1, '%' => 1, '+' => 2, '-' => 2, '>' => 3, '>=' => 3, '<' => 3, '<=' => 3, '==' => 4, '!=' => 4, 'and' => 5, 'or' => 6 ];

  protected $loader = null;
  protected $debug = false;

  public function orderOperations( $input, $mapper ) {

    $stack = [];
    $postfix = $this->shuntingYard( $input );

    while( count( $postfix ) ) {
      list( $type, $next ) = array_shift($postfix);
      if ($type === self::VALUE) {
        $stack[] = $next;
        continue;
      }
      if ($type === self::OP) {
        $b = array_pop($stack);
        $a = array_pop($stack);
        $stack[] = $mapper([$a, $next, $b]);
      }
    }

    return end($stack);
  }

  // Take an input of operators and return a postfix notation version with sorted operators
  public function shuntingYard( $input ) {

    $output = [[self::VALUE,array_shift($input)]];
    $ops = [];

    while ( count( $input ) > 0 ) {
      $op = array_shift($input);
      $precedence = $this->operator_precedence[$op];

      while (count($ops) > 0 && $this->operator_precedence[end($ops)] < $this->operator_precedence[$op]) {
        $output[] = [self::OP,array_pop($ops)];
      }

      $ops[] = $op;
      $output[] = [self::VALUE,array_shift($input)];

    }

    while (count($ops) > 0) {
      $output[] = [self::OP,array_pop($ops)];
    }

    return $output;
  }

  public function chainInterpolate($result, $l) {


    // if ($result->is('end')) {
    //   return P::noop();
    // }
    if ($result->is('input')) {

      switch ( $result->content() ) {
        case "(":
          return $l->parenInterpolation;
        case ")":
          return P::anyChar();
        case "'":
          return $l->singleQuotedString->then($l->parenInner);
        case '"':
          return $l->doubleQuotedString->then($l->parenInner);
        default:
          return P::anyChar()->then($l->parenInner);
      }
    }

    return $l->parenInner;
  }

  public function combineInterpolation( $results ) {

    $buffer = '';
    $combinedPlaceholders = [];

    foreach( $results as $next ) {

      $result = is_array( $next ) ? $this->combineInterpolation( $next ) : $next;

      if ( is_string( $result )) {
        $buffer .= str_replace('%', '\%', $result );
      } else {

        if ($result->is('interpolated')) {
          list ($content, $placeholders) = $result->content();

          $buffer .= $content;
          $combinedPlaceholders = array_merge( $combinedPlaceholders, $placeholders);
        } else {
          $content = $result->content();
          if (! is_string($content) && $content->is('interpolated') ) {
            $combinedPlaceholders[] = $result;
            $buffer .= '%s';
          } else {
            $formatted = $result->content();

            if ($result->is('doubleQuotedString')) {
              $formatted = '"' . $formatted . '"';
            } else if ($result->is('singleQuotedString')) {
              $formatted = "'" . $formatted . "'";
            }

            $buffer .= str_replace('%', '\%', $formatted );
          }

        }
      }

    }

    if (count($combinedPlaceholders) > 0) {
      return P::token('interpolated', [ $buffer, $combinedPlaceholders ]);
    }

    return str_replace('\%','%', $buffer);
  }

  public function interpolateAll( $l, $parser ) {
    return P::many1(P::any(
      $l->string,
      $this->interpolator($l, P::any($l->escape, $parser))
    ))->map(function($results) {
      return $this->combineInterpolation( $results );
    });
  }

  public function interpolator( $l, $charParser ) {

    return P::many1(P::any(
      P::str('\#')->result('#'),
      $l->stringInterpolation,
      $charParser
    ))->map(function($result) {
      $placeholders = [];
      $content = implode('', array_map(function($item) use (&$placeholders){
        if (!is_string($item)) {
          $placeholders[] = $item;
          return '%s';
        }
        return str_replace('%', '\%', $item);
      }, $result));

      if (count($placeholders) > 0) {
        return P::token('interpolated', [ $content, $placeholders ]);
      }

      return str_replace('\%','%', $content);

    });
  }

  public function setup( $args = [] ) {

    if (isset( $args['debug'] ) ) {
      $this->debug = boolval($args['debug']);
    }

    ini_set('xdebug.max_nesting_level', 500);

    $this->language = P::createLanguage([

      // Document
      // --------

      'document' => function($l) {
        return P::whitespace()
          ->then(P::many1(P::any($l->statement)))
          ->skip(P::whitespace())
          ->skip(P::end())
          ->token('document');
      },

      // @at-rules
      // ---------

      'atRule' => function($l) {
        return at($l->word)->chain(function($rule) use( $l ) {

          if (isset($this->language->{$rule})) {
            return $this->language->{$rule};
          }

          return $l->cssAtRule->map(function($result) use ($rule) {
            return array_merge( [ $rule ], is_array( $result ) ? $result : [ '', $result ] );
          })->token('cssAtRule');
        });

      },

      'error' => function($l) {
        return $l->terminatedExpressionList->token('error');
      },
      'warn' => function($l) {
        return $l->terminatedExpressionList->token('warn');
      },
      'debug' => function($l) {
        return $l->terminatedExpressionList->token('debug');
      },
      'return' => function($l) {
        return $l->terminatedExpressionList->token('return');
      },

      'import' => function($l) {
        return $l->string->skip(symbol(';')->abortOnError())->token('import');
      },

      'definition' => function($l) {
        return P::sequence(
          $l->word,
          $l->arguments->otherwise([]),
          $l->block->abortOnError()
        );
      },

      'function' => function($l) {
        return $l->definition->token('function');
      },

      'mixin' => function($l) {
        return $l->definition->token('mixin');
      },

      'module' => function($l) {
        return $l->definition->token('module');
      },

      'include' => function($l) {
        return $l->word
          ->next($l->arguments->otherwise([]))
          ->skip(P::regex('/^;\s*/'))
          ->abortOnError()
          ->token('include');
      },

      'if' => function($l) {
        return $l->expression
          ->next($l->block)
          ->next(P::many(
            at('else')->then(identifier('if'))
            ->then($l->expression)
            ->next($l->block)->token('elseIf')
          ))->flatten()
          ->maybeNext(
            at('else')
            ->then($l->block)
            ->token('else')
          )->flatten()->abortOnError()->token('if');
      },

      'each' => function($l) {
        return P::sequence(
          P::sep_by1(symbol(','))($l->variable)->skip(wsSymbol('in')),
          $l->expression,
          $l->block->abortOnError()
        )->token('each');
      },

      'cssAtRule' => function($l) {
        return P::any(
          P::followed_by('{')->then($l->block),
          $this->interpolateAll($l, P::regex('/^[^{};]/')) // prelude
            ->trim()
            ->next(P::any(symbol(';')->token('terminator'), $l->block ) )
        );
      },

      'parenInner' => function( $l) {
        return P::any(
          $l->string,
          $l->parenInterpolation,
          $this->interpolator($l, P::any(P::regex('/^[^#()"\']+/')))
        );
      },

      'parenInterpolation' => function($l) {
        return P::sequence(
          P::str('('),
          P::many($l->parenInner),
          P::str(')')
        )->map(function($r) {
          return $this->combineInterpolation($r);
        });
      },


      // Statements
      // ----------

      'statement' => function($l) {
        return P::any($l->atRule, $l->assignVariable, $l->styleRule, $l->assignProperty);
      },

      'assignVariable' => function($l, $key) {
        return $l->variable->skip(wsSymbol(':'))->next($l->terminatedExpressionList)->token($key);
      },

      'property' => function ($l) {
        return $l->interpolatedWord;
      },

      'assignProperty' => function($l, $key) {
        return $l->property->skip(wsSymbol(':'))
          ->next($l->propertyList->next(wsSymbol('!important')->result(true)->otherwise(false))->skip(symbol(';', 'terminatedPropertyList')->abortOnError()))
          ->flatten()
          ->token($key);
      },

      'block' => function($l) {
        return wsSymbol('{', 'block-open')
          ->then(P::many($l->statement))
          ->skip(wsSymbol('}', 'block-close')->abortOnError());
      },

      // Styles
      // ------

      'styleRule' => function($l) {
        return P::sep_by1(symbol(','))($l->selector)->next($l->block)->token('styleRule');
      },

      'selector' => function($l) {
        return $this->interpolateAll($l, P::regex('/^[^\'"{};,]/'))->trim();
      },

      // Variables / Arguments / Functions
      // ---------------------------------

      'variable' => function($l) {
        return P::str('$')->then($l->word);
      },

      'arguments' => function($l) {
        return symbol('(')
          ->then(P::sep_by(symbol(','))(P::any($l->keywordArgument, $l->expressionValues )))
          ->skip(wsSymbol(')'));
      },

      'keywordArgument' => function($l) {
        return $l->variable->skip(wsSymbol(':'))->next($l->expressionValues)->token('keywordArgument');
      },

      'interpolatedWord' => function($l) {
        return $this->interpolator($l, $l->word);
      },

      // Expressions
      // -----------

      'terminatedExpressionList' => function($l) {
        return $l->expressionList->skip(symbol(';', 'terminatedExpressionList')->abortOnError());
      },

      'expressionList' => function($l) {
        return P::sep_by(symbol(','))($l->expressionValues)->map(function($result) {
          return count( $result ) === 1 ? $result[0] : P::token('list', $result);
        });
      },

      'propertyList' => function($l) {
        return P::sep_by(symbol(','))($l->propertyListValues)
          ->map(function($result) {
            return count( $result ) === 1 ? $result[0] : P::token('list-comma', $result);
          });
      },

      'propertyListValues' => function($l) {
        return P::sep_by(symbol('/'))($l->propertyValues)
          ->map(function($result) {
            return count( $result ) === 1 ? $result[0] : P::token('split', $result);
          });
      },

      'expressionValues' => function($l) {
        return P::many1($l->expression->skip(P::whitespace()))->map(function($result) {
          return count( $result ) === 1 ? $result[0] : P::token('list', $result);
        });
      },

      'propertyValues' => function($l) {
        return P::many1($l->propertyComponent->skip(P::whitespace()))->map(function($result) {
          return count( $result ) === 1 ? $result[0] : P::token('list', $result);
        });
      },

      'operandWithUnaryOperation' => function( $l ) {
        return $l->unaryOperator->otherwise(null)->next($l->operand)->map(function($result) {
          list($unary, $operand) = $result;
          return is_null( $unary ) ? $operand : P::token('unary', $result);
        });
      },

      'propertyComponent' => function($l) {
        return $l->operandWithUnaryOperation; // dont allow binary operations
        // return
        //   $l->operandWithUnaryOperation
        //   ->next(
        //     P::many($l->binaryOperatorNoSlash->next($l->operandWithUnaryOperation))->flatten()
        //   )->flatten()
        //   ->map(function( $result ) {
        //     return count($result) <= 0 ? $result : $this->orderOperations( $result, function($ordered) {
        //       return P::token('operation',$ordered);
        //     });
        //   });
      },

      'expression' => function($l) {
        return
          $l->operandWithUnaryOperation
          ->next(
            P::many($l->binaryOperator->next($l->operandWithUnaryOperation))->flatten()
          )->flatten()
          ->map(function( $result ) {
            return count($result) <= 0 ? $result : $this->orderOperations( $result, function($ordered) {
              return P::token('operation',$ordered);
            });
          });
      },

      'operand' => function($l) {
        return P::any(
          $l->variable->token('variable'),
          $l->string,
          $l->primitive,
          P::sequence(
            $l->interpolatedWord,
            P::lookahead('(')
          )->chain(function($result) use ($l) {

            // Do a lookahead to capture both the CSS argument list AND the function call list
            // this way we can run the interpolation of the funciton name at runtime and determine
            // if the call should be run as a CSS function or TSS function

            return P::noop()->first()
              ->next(P::lookahead($l->parenInterpolation)->otherwise(null)->next($l->arguments)->otherwise(null))
              ->flatten()
              ->token('call');

          }),
          symbol('(')->then($l->expression)->skip(symbol(')')->abortOnError()), // treat parens as a nested expression
          $l->number,
          $l->hexColor,
          $l->interpolatedWord->token('primitive')
        );
      },

      'unaryOperator' => function($l) {
        return P::regex('/^(?:not\s|[-+])\s*/')->trim();
      },

      'binaryOperator' => function($l) {
        // * multiply
        // / divide or concat
        // % numeric modulus
        // + add or concat
        // - subtract or concat
        return P::regex('/^\s*(\*|\/|%|\+|-|<=|>=|<|>|==|!=|and\s|or\s)\s*/')->trim();
      },

      'binaryOperatorNoSlash' => function($l) {
        return P::regex('/^\s*(\*|%|\+|-|<=|>=|<|>|==|!=|and\s|or\s)\s*/')->trim();
      },

      // Syntax
      // ------

      'escape' => function($l) {
        return P::regex('/^\\\(.)/');
      },

      // alphanumeric + hyphen + non ASCII characters
      'word' => function( $l) {
        return P::regex('/^(?:[\w-]|[^\x00-\x7F])+/');
      },

      // Values
      // ------

      'stringInterpolation' => function($l) {
        return P::regex('/^#{\s*/')->then($l->expression)->skip(P::regex('/^\s*}/'));
      },

      'string' => function($l) {
        return P::any(
          $l->doubleQuotedString,
          $l->singleQuotedString
        );
      },

      'doubleQuotedString' => function($l) {
        return P::str('"')
          ->then( $this->interpolator($l, P::any(P::regex('/^[^\\"]/')))
          ->otherwise(''))
          ->skip(P::str('"'))
          ->token('doubleQuotedString');
      },

      'singleQuotedString' => function($l) {
        return P::str("'")
          ->then($this->interpolator($l, P::any(P::regex('/^[^\']/')))
          ->otherwise(''))
          ->skip(P::str("'"))
          ->token('singleQuotedString');
      },

      'hexColor' => function($l) {
        return P::str('#')->next(P::digitsWithHex())->join()->token('primitive');
      },

      'number' => function($l){
        $plusMinus = P::any(P::str('+'),P::str('-'))->otherwise('');
        return $plusMinus
          ->concat(P::any(
            P::digits()->concat(P::str('.'))->concat(P::digits()),
            P::str('.')->concat(P::digits()),
            P::digitsWithHex()->notFollowedBy(P::letters()),
            P::digits()
          ))
          // ->concat(P::any(P::str('e'), P::str('E'))
          //   ->concat($plusMinus)
          //   ->concat(P::digits())
          //   ->otherwise(''))
          ->next(
            P::any(P::str('%'), $l->interpolatedWord)->otherwise(null)
          )->map(function($result) {
            list( $number, $unit ) = $result;

            // When parsing numbers we'll keep the string representation and allow the code operating on the value to determine how it is used
            // $val = strpos($number, '.') !== false ? floatval( $number ) : intval( $number );

            if ($unit) return P::token('dimension', [ $number, $unit ]);
            return P::token('number', $number);
          });
      },

      'primitive' => function($l) {
        return P::any(P::str('true'),P::str('false'),P::str('null'))->map(function($result) {
          switch ($result) {
            case 'true':
              return true;
            case 'false':
              return false;
            case 'null':
              return null;
          }
        })->token('primitive');
      },

      'inputValue' => function($l) {
        return P::any(
          P::any(
            $l->propertyList->chain(function($result) use ($l) {
              if ($result->is('split') && empty( $result->content() ) ){
                return $l->selector->token('primitive');
              }
              return P::noop();
            })->skip(P::end()),
            $l->selector->token('primitive')
          )->skip(P::end()),
          P::many(P::anyChar())->skip(P::end())->join()->token('primitive')
        );
      }

    ]);

  }

  public static function make( $args = [] ) {
    return new self($args);
  }

  public function debugOutput($e) {
    list($prev,$error) = $e->getStates();
    var_dump( ['previous' => $prev->getResult() ]);
  }

  public function run( $input, $parser = 'document' ) {

    try {
      return $this->language->{$parser}->run( $this->cleanInput( $input ), $this->debug );
    } catch (ParseException $e) {
      if ($this->debug) {
        $this->debugOutput($e);
      }
      throw new \Exception( $e->getMessage() );
    }
  }

  public function cleanInput( $input ) {
    $input = preg_replace('/\/\*(?:.|\n)+?\*\//', '', $input); // multi line comments
    $input = preg_replace('/\/\/.*\\n/', '', $input); // single line comments
    return preg_replace('/\/\/.*$/', '', $input); // comments leading to end of input
  }

}