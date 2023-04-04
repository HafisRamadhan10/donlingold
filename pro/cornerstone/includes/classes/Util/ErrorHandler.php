<?php

namespace Themeco\Cornerstone\Util;

class ErrorHandler {

  protected $handler;
  protected $errors = [];

  public function setHandler($handler) {
    $this->handler = $handler;
  }

  public function start() {
    set_error_handler( [$this, 'errorHandler' ]);
  }

  public function stop() {
    restore_error_handler();
  }

  public function flush() {
    foreach ($this->errors as $error) {
      echo "$error\n";
    }
    $this->errors = [];
  }

  public function errors() {
    return $this->errors;
  }

  public function errorHandler( $errno, $errstr, $errfile, $errline) {

    if ( ! ( error_reporting() & $errno ) ) {
      return false;
    }

    $error = $this->formatError($errno, $errstr, $errfile, $errline);
    $this->errors[] = $error;

    if ( is_callable( $this->handler ) ) {
      $cb = $this->handler;
      $cb($error);
    }

    return true;
  }

  protected function formatError($errno, $errstr, $errfile, $errline) {
    return $this->getErrorType( $errno ) . ": $errstr in $errfile on line $errline.";
  }

  protected function getErrorType( $errno ) {

    switch ( $errno ) {
      case E_ERROR:
        return 'E_ERROR';
      case E_WARNING:
        return "PHP Warning";
      case E_PARSE:
        return 'E_PARSE';
      case E_NOTICE:
        return "PHP Notice";
      case E_CORE_ERROR:
        return 'E_CORE_ERROR';
      case E_CORE_WARNING:
        return 'E_CORE_WARNING';
      case E_COMPILE_ERROR:
        return 'E_COMPILE_ERROR';
      case E_COMPILE_WARNING:
        return 'E_COMPILE_WARNING';
      case E_USER_ERROR:
        return 'E_USER_ERROR';
      case E_USER_WARNING:
        return 'E_USER_WARNING';
      case E_USER_NOTICE:
        return 'E_USER_NOTICE';
      case E_STRICT:
        return 'E_STRICT';
      case E_RECOVERABLE_ERROR:
        return 'E_RECOVERABLE_ERROR';
      case E_DEPRECATED:
        return 'E_DEPRECATED';
      case E_USER_DEPRECATED:
        return 'E_USER_DEPRECATED';
    }

    return "Unknown Error [$errno]";

  }

}