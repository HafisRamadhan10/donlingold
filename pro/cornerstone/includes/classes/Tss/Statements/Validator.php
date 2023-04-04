<?php

namespace Themeco\Cornerstone\Tss\Statements;

use Themeco\Cornerstone\Util\Factory;

use Themeco\Cornerstone\Tss\Statements\AssignVariable;
use Themeco\Cornerstone\Tss\Statements\ReturnCall;
use Themeco\Cornerstone\Tss\Statements\DefineModule;
use Themeco\Cornerstone\Tss\Statements\DefineMixin;
use Themeco\Cornerstone\Tss\Statements\DefineFunction;
use Themeco\Cornerstone\Tss\Statements\Debug;
use Themeco\Cornerstone\Tss\Statements\Error;
use Themeco\Cornerstone\Tss\Statements\Warn;
use Themeco\Cornerstone\Tss\Statements\FlowIf;
use Themeco\Cornerstone\Tss\Statements\FlowEach;
use Themeco\Cornerstone\Tss\Statements\IncludeCall;
use Themeco\Cornerstone\Tss\Statements\StyleRule;
use Themeco\Cornerstone\Tss\Statements\CssAtRule;
use Themeco\Cornerstone\Tss\Statements\AssignProperty;

use Themeco\Cornerstone\Tss\Constants\StatementTypes;


class Validator {

  protected $context;
  protected $allowed = [];

  public function __construct() {
    $this->allowed = StatementTypes::STYLE;
  }

  public function setContext($context) {
    $this->context = $context;
  }

  public function setAllowedStatementTypes($allowed) {
    $this->allowed = $allowed;
  }

  public function make( $type, $stack ) {
    return $this->identify( $type )->setStack($stack);
  }

  public function identify( $type ) {

    switch ($type) {
      case 'warn':
        return Factory::create(Warn::class);
      case 'debug':
        return Factory::create(Debug::class);
        break;
      case 'error':
        return Factory::create(Error::class);
    }

    if (!in_array( $type, $this->allowed, true)) {
      throw new \Exception( sprintf( 'Statement type [%s] not allowed in context [%s]', $type, $this->context ) );
    }

    switch ($type) {
      case 'assignVariable':
        return Factory::create(AssignVariable::class);
      case 'assignProperty':
        return Factory::create(AssignProperty::class);
      case 'return':
        return Factory::create(ReturnCall::class);
      case 'if':
        return Factory::create(FlowIf::class);
      case 'each':
        return Factory::create(FlowEach::class);
      case 'mixin':
        return Factory::create(DefineMixin::class);
      case 'module':
        return Factory::create(DefineModule::class);
      case 'function':
        return Factory::create(DefineFunction::class);
      case 'include':
        return Factory::create(IncludeCall::class);
      case 'styleRule':
        return Factory::create(StyleRule::class);
      case 'cssAtRule':
        return Factory::create(CssAtRule::class);

      default:
        throw new \Exception( 'Statement type not recognized: ' . $type );

    }
  }
}