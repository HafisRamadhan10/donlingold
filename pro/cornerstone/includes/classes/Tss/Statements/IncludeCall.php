<?php

namespace Themeco\Cornerstone\Tss\Statements;

use Themeco\Cornerstone\Tss\Statements\Statement;
use Themeco\Cornerstone\Tss\Traits\Call;
use Themeco\Cornerstone\Tss\Constants\StatementTypes;

class IncludeCall extends Statement {

  use Call;

  public function process( $include ) {
    list($name, $args) = $include;

    // Locate and run the mixin
    list($scope, $statements) = $this->resolveCallable( 'mixin', $name, $args);

    // Updat the include scope to access the base/current module data
    $scope->define( 'data', 'module-base', $this->stack->lookup('data', 'module-base') );
    $scope->define( 'data', 'module-current', $this->stack->lookup('data', 'module-current') );

    $scope->processStatements($statements);

    $mixinResult = $scope->result()->content();

    // merge the results with the current scope

    if ( ! is_null( $mixinResult ) ) {
      $this->stack->result()->update(function( $result ) use ($mixinResult) {
        if ( ! is_array( $result ) ) $result = [];
        $resultTypes = [ 'styleRules', 'cssAtRules', 'properties'];

        foreach ($resultTypes as $resultType) {
          if ( isset( $mixinResult[$resultType] ) ) {
            if ( ! isset( $result[$resultType] ) ) $result[$resultType] = [];
            $result[$resultType] = array_merge($result[$resultType], $mixinResult[$resultType]);
          }
        }

        return $result;
      });
    }

  }

}