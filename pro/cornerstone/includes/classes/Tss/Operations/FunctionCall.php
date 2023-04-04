<?php

namespace Themeco\Cornerstone\Tss\Operations;

use Themeco\Cornerstone\Tss\Traits\Call;
use Themeco\Cornerstone\Tss\Operations\Operation;
use Themeco\Cornerstone\Tss\Constants\StatementTypes;
use Themeco\Cornerstone\Tss\Constants\CssFunctions;

use Themeco\Cornerstone\Tss\Exceptions\UndefinedCallException;
use Themeco\Cornerstone\Tss\Functions\BuiltInFunction;

class FunctionCall extends Operation {

  use Call;

  public function run( $input ) {

    list($name, $cssArgs, $fnArgs) = $input;

    if ($cssArgs) {
      $cssFn = $this->stack->evaluator()->resolve($name)->toString();
      if (in_array( strtolower( $cssFn ), CssFunctions::LIST, true ) ) {
        return $this->cssFunction($name, $cssArgs);
      }
    }

    $builtIn = BuiltInFunction::make($name, $this->stack);

    if ($builtIn) {
      return $builtIn->call($this->parseArguments($fnArgs, $builtIn->getArgs()));
    }

    try {

      list($scope, $statements) = $this->resolveCallable( 'function', $name, $fnArgs, StatementTypes::FUNC );
      $scope->processStatements($statements);

      if ($scope->result()->isComplete()) {
        return $scope->result()->content();
      }
    } catch (UndefinedCallException $e) {
      return $this->cssFunction($name, $cssArgs);
    }

    throw new \Exception('Function call did not return: ' . $input[0]);
  }

  public function cssFunction($name, $args) {
    return $this->stack->evaluator()->makeTyped(
      'primitive',
      $name . $this->stack->evaluator()->resolve($args)->toString()
    );
  }

}