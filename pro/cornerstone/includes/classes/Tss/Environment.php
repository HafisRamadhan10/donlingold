<?php

namespace Themeco\Cornerstone\Tss;

use Themeco\Cornerstone\Util\Factory;
use Themeco\Cornerstone\Tss\Runtime;
// use Themeco\Cornerstone\Util\TransientCache;
use Themeco\Cornerstone\Tss\Stack;
use Themeco\Cornerstone\Tss\Constants\StatementTypes;
use Themeco\Cornerstone\Parsy\Serializer;
use Themeco\Cornerstone\Parsy\Token;

use Themeco\Cornerstone\Plugin;

class Environment {

  protected $parsedValues = [];
  protected $entities = [];
  protected $setup = false;
  protected $imported = [];

  public function __construct(StyleParser $parser, Serializer $serializer, /* TransientCache $cache, */ Stack $stack) {
    $this->parser = $parser;
    $this->serializer = $serializer;
    // $this->cache = $cache;
    $this->stack = $stack;
  }

  public function ready() {
    if ($this->setup) return;
    $this->setup = true;
    $this->parser->setup();
    $this->stack->validator()->setContext('root');
    $this->stack->validator()->setAllowedStatementTypes(StatementTypes::ROOT);
  }

  public function configureBreakpoints($base, $ranges) {
    $this->configure( 'baseBreakpoint', $base < count($ranges) ? $base : 0);
    $this->configure( 'breakpointRanges', $ranges);
  }

  public function configure( $key, $value ) {
    $this->stack->define('internal', $key, $value );
  }

  public function import($name, $content) {
    $this->ready();
    if ( ! isset( $this->imported[$name] ) ) {
      $doc = $this->serializer->unserialize($content);
      $this->stack->processStatements($doc->content());
      $this->imported[$name] = true;
    }
  }

  public function runtime( $id ) {
    $this->ready();
    if ( ! isset( $this->entities[$id] ) ) {
      $runtime = Factory::create(Runtime::class);
      $runtime->setStack($this->stack->newScope());
      $runtime->setup( $id, $this );
      $this->stack->define('parser', 'valueParser', function( $input, $key ) {
        return $this->parseValue($input);
      });
      $this->entities[$id] = $runtime;
    }
    return $this->entities[$id];
  }

  public function registerType($name, $config) {
    if (!is_a($config, ContainerConfig::class)) {
      throw new Exception("Tss module config must be a ContainerConfig: $name");
    }

    $this->stack->define('container', $name, $config->modulesForEnv( $this ) );

  }

  public function getType( $name ) {
    return $this->stack->lookup('container', $name );
  }

  public function parseValue( $input, $prefilter = null ) {
    if ( is_bool( $input ) || is_null( $input )) {
      return new Token('primitive', $input);
    }

    if ( is_array( $input ) ) {
      return new Token('list', array_map( [$this, 'parseValue' ], $input) );
    }

    if ( is_numeric( $input ) ) {
      return new Token('number', $input );
    }

    if ( ! is_string( $input ) ) {
      throw new \Exception('Invalid value type');
    }

    // Resolve alternate content. This is used by Dynamic Content to return var(--tco-XXX) instead of a DC statement
    $normalized = ! is_null( $prefilter ) && is_callable( $prefilter ) ? $prefilter( $input ) : $input;
    $normalized = str_replace('global-color:', 'global-color-', $normalized );

    if ( ! isset( $this->parsedValues[ $normalized ] ) ) {
      try {
        $this->parsedValues[ $normalized ] = $this->parser->run( $normalized, 'inputValue' );
      } catch (\Exception $e) {
        if ( defined('TCO_DEBUG') && TCO_DEBUG ) {
          trigger_error( 'Cornerstone CSS parser unable to identify value type: ' . $input , E_USER_WARNING );
        }

        $this->parsedValues[ $normalized ] = new Token('primitive', $normalized);
      }

    }

    return $this->parsedValues[ $normalized ];

  }

  function parseModuleArg($key, $value) {
    return new Token('keywordArgument', [$key, $this->parseValue($value)]);
  }

}