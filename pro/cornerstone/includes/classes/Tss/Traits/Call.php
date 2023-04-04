<?php

namespace Themeco\Cornerstone\Tss\Traits;

use Themeco\Cornerstone\Tss\Exceptions\UndefinedCallException;

trait Call {

  public function resolveCallable($type, $name, $callArgs = [], $allowedStatementTypes = null, $valueParserScope = null) {

    list($target, $callableStack) = $this->stack->lookupWithStack($type, $name);

    if (!$target) {
      throw new UndefinedCallException("Undefined $type call: $name");
    }

    list($targetArgs, $statements) = $target;

    // Parse the arguments in the calling scope
    $args = $this->parseArguments($callArgs, $targetArgs);

    // Create a new scope based on the defined callable's stack
    $scope = $callableStack->newScope();


    $_valueParserScope = is_null( $valueParserScope ) ? $this->stack : $valueParserScope;
    // Bring over the value parser from the

    $scope->define(
      'parser',
      'valueParser',
      $_valueParserScope->lookup('parser','valueParser')
    );

    $scope->validator->setContext($type);
    if ( is_array( $allowedStatementTypes ) ) {
      $scope->validator->setAllowedStatementTypes( $allowedStatementTypes );
    }

    // Define the arguments as variables inside the new scope
    foreach( $args as $name => $value) {
      $scope->define('variable', $name, $value);
    }

    return [$scope, $statements];

  }

  public function parseArguments( $callArgs, $callableArgs ) {
    $indexed = [];
    $keyed = [];

    foreach ($callArgs as $arg) {
      if ($arg->is('keywordArgument')) {
        list($var, $value) = $arg->content();
        $keyed[$var] = $value;
      } else {
        $indexed[] = $arg;
      }
    }

    $keys = array_keys($callableArgs);

    $parsed = [];
    foreach( $keys as $index => $key) {
      $parsed[$key] = $callableArgs[$key];
      if (isset($indexed[$index])) {
        $parsed[$key] = $indexed[$index];
      }

      if (isset($keyed[$key])) {
        $parsed[$key] = $keyed[$key];
      }
      $parsed[$key] = $this->stack->evaluator()->resolve($parsed[$key]);
    }

    return $parsed;
  }

}