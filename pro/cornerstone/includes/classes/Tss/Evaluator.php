<?php

namespace Themeco\Cornerstone\Tss;

use Themeco\Cornerstone\Util\Factory;
use Themeco\Cornerstone\Parsy\Token;
use Themeco\Cornerstone\Tss\Operations\Validator;
use Themeco\Cornerstone\Tss\Traits\StackAccessor;
use Themeco\Cornerstone\Tss\Operations\GetVariable;
use Themeco\Cornerstone\Tss\Operations\DefineSplit;
use Themeco\Cornerstone\Tss\Operations\DefineList;
use Themeco\Cornerstone\Tss\Operations\DefineCommaList;
use Themeco\Cornerstone\Tss\Operations\FunctionCall;
use Themeco\Cornerstone\Tss\Operations\StringInterpolation;
use Themeco\Cornerstone\Tss\Operations\Unary;
use Themeco\Cornerstone\Tss\Operations\Binary;

use Themeco\Cornerstone\Tss\Typed\Typed;
use Themeco\Cornerstone\Tss\Typed\Primitive;
use Themeco\Cornerstone\Tss\Typed\Dimension;
use Themeco\Cornerstone\Tss\Typed\Number;
use Themeco\Cornerstone\Tss\Typed\ValueList;
use Themeco\Cornerstone\Tss\Typed\CommaList;
use Themeco\Cornerstone\Tss\Typed\Split;
use Themeco\Cornerstone\Tss\Typed\DoubleQuotedString;
use Themeco\Cornerstone\Tss\Typed\SingleQuotedString;

class Evaluator {

  use StackAccessor;

  // This should consistently take an input and resolve to
  // a single typed value
  // this could involve
  public function resolve($input) {

    if ( is_a( $input, Typed::class ) ) {
      return $input;
    }

    $token = is_a( $input, Token::class ) ? $input : new Token('primitive', $input);
    $type = $token->type();

    $operation = $this->identifyOperation( $type );
    if (!$operation) {
      return $this->makeTyped( $type, $token->content() );
    }

    $operation->setStack($this->stack);
    return $operation->run( $token->content() );

  }

  public function identifyOperation( $type ) {
    switch ($type) {
      case 'interpolated':
        return Factory::create(StringInterpolation::class);
      case 'list':
        return Factory::create(DefineList::class);
      case 'list-comma':
        return Factory::create(DefineCommaList::class);
      case 'split':
        return Factory::create(DefineSplit::class);
      case 'unary':
        return Factory::create(Unary::class);
      case 'operation':
        return Factory::create(Binary::class);
      case 'call':
        return Factory::create(FunctionCall::class);
      case 'variable':
        return Factory::create(GetVariable::class);
      default:
        return false;
        throw new \Exception("unknown type: $type");
    }

  }

  public function identifyTyped( $type ) {
    switch ($type) {
      case 'primitive':
        return Factory::create(Primitive::class);
      case 'dimension':
        return Factory::create(Dimension::class);
      case 'number':
        return Factory::create(Number::class);
      case 'valueList':
        return Factory::create(ValueList::class);
      case 'commaList':
        return Factory::create(CommaList::class);
      case 'split':
        return Factory::create(Split::class);
      case 'doubleQuotedString':
        return Factory::create(DoubleQuotedString::class);
      case 'singleQuotedString':
        return Factory::create(SingleQuotedString::class);
      default:
        throw new \Exception("unknown type: $type");
    }

  }

  public function makeTyped( $type, $value ) {
    $typed = $this->identifyTyped( $type );
    if ( is_a( $value, Token::class ) && $value->is('interpolated') ) {
      $value = $this->resolve( $value );
    }
    $typed->setValue( $value );
    return $typed;
  }

  public function ensureType( $input ) {
    return is_a( $input, Typed::class ) ? $input : Factory::create(Primitive::class)->setValue($input);
  }

}