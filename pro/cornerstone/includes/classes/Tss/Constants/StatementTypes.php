<?php

namespace Themeco\Cornerstone\Tss\Constants;

class StatementTypes {

  const STYLE = [
    'assignVariable',
    'styleRule',
    'assignProperty',
    'cssAtRule',
    'include',
    'if',
    'each'
  ];

  const FUNC = [
    'assignVariable',
    'if',
    'each',
    'return'
  ];

  const ROOT = [
    'mixin',
    'module',
    'function',
    'assignVariable'
  ];

}