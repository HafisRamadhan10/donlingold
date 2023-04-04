<?php

namespace Themeco\Cornerstone\Tss;

use Themeco\Cornerstone\Util\Factory;
use Themeco\Cornerstone\Tss\Traits\StackAccessor;
use Themeco\Cornerstone\Tss\Traits\Call;
use Themeco\Cornerstone\Tss\Constants\StatementTypes;
use Themeco\Cornerstone\Tss\Reducers\RuleReducer;
use Themeco\Cornerstone\Tss\Reducers\QueryStyleReducer;
use Themeco\Cornerstone\Tss\Reducers\ModuleReducer;
use Themeco\Cornerstone\Tss\Reducers\DeclarationReducer;
use Themeco\Cornerstone\Tss\Reducers\RuntimeReducer;
use Themeco\Cornerstone\Tss\Util\IdEncoder;

class Runtime {

  use Call;
  use StackAccessor;

  protected $id = 0;
  protected $env;
  protected $modules = [];
  protected $dynamicContent = [];

  public function __construct(RuleReducer $ruleReducer, DeclarationReducer $declarationReducer, IdEncoder $dcIdEncoder) {
    $this->ruleReducer = $ruleReducer;
    $this->dcIdEncoder = $dcIdEncoder;
    $this->declarationReducer = $declarationReducer;
  }

  public function setup($id, $env) {
    $this->id = $id;
    $this->env = $env;
    $this->dcIdEncoder->setup( $id, 'dc' );
  }

  public function process( $id, $type, $data ) {

    $modules = $this->stack->lookup('container', $type);

    $containerScope = $this->stack->newScope();
    $containerScope->define('parser', 'valueParser', function($input, $key) use ($containerScope) {

      return $this->env->parseValue($input, function($input) use ($containerScope) {
        return preg_replace_callback( '/{{dc:(?:[A-Za-z0-9_-]*):?(?:[A-Za-z0-9_-]*)(?:.*?)}}/', function($matches) use ($containerScope){
          $id = $this->dcIdEncoder->nextId();
          $containerScope->define('dc', $id, $matches[0]);
          return "var(--tco-$id)";
        }, $input );
      });
    });

    if ( ! is_null( $modules ) ) {
      foreach( $modules as $module) {
        $this->module( $containerScope, $id, $module, $data );
      }
    }

    $this->dynamicContent[ $id ] = $containerScope->getAllFromNamespace('dc');

  }


  public function normalizeModuleData( $config, $data ) {
    $baseData = is_null( $config['remap'] ) ? $data : $this->remap( $data, $config['remap'] );

    if ( isset($data['_bp_base'] ) ) {
      $bpKey = '_bp_data' . $data['_bp_base'];
      if ( isset( $data[$bpKey] ) ) {
        $baseData['_bp_data'] = is_null( $config['remap'] ) ? $data[$bpKey] : $this->remap( $data[$bpKey], $config['remap'] );
      }
    }

    return $baseData;
  }

  // ID is the name of the calling element
  public function module( $containerScope, $id, $config, $data ) {

    if ( !isset( $this->modules[ $config['module'] ] ) ) {
      $this->modules[ $config['module'] ] = [];
    }

    $baseBreakpoint = $this->stack->lookup('internal', 'baseBreakpoint');
    $ranges = $this->stack->lookup('internal', 'breakpointRanges');
    $size = count($ranges) - 1;
    $baseData = $this->normalizeModuleData( $config, $data );
    $modName = is_null($config['name']) ? $config['module'] : $config['name'];

    if ( ! $this->conditionCheck( $data, $config['conditions'] ) ) {
      $this->modules[ $config['module'] ]["$id:$modName"] = [
        $id,
        $modName,
        []
      ];
      return;
    }

    // Fill the array. This ensures the indexes are in the right order before the reduced runs
    $queryResult = [];
    for ($i = 0; $i <= $size; $i++) {
      $queryResult[$i] = [];
    }


    $baseResult = $this->runModuleStatements( $containerScope, $config, $baseData, $baseData, true);

    // Base -> UP
    $currentData = $baseData;

    for ($i = $baseBreakpoint + 1; $i <= $size; $i++) {
      $queryResult[$i] = $this->runModuleForBreakpoint($containerScope, $config, $i, $baseData, $currentData);
    }

    // Base -> DOWN
    $currentData = $baseData;

    for ($i = $baseBreakpoint - 1; $i >= 0; $i--) {
      $queryResult[$i] = $this->runModuleForBreakpoint($containerScope, $config, $i, $baseData, $currentData);
    }

    $queryStyleReducer = Factory::create(QueryStyleReducer::class);

    $reduced = $queryStyleReducer->reduce($baseBreakpoint, $baseResult, $queryResult);
    $modName = is_null($config['name']) ? $config['module'] : $config['name'];

    $this->modules[ $config['module'] ]["$id:$modName"] = [ $id, $modName, $reduced ];

  }

  public function runModuleForBreakpoint($containerScope, $config, $i, $baseData, &$currentData) {

    if ( !isset( $baseData['_bp_data'] ) ) {
      return [];
    }

    $indexData = [];

    foreach ($baseData['_bp_data'] as $key => $value ) {
      if (!is_null($value[$i])) {
        $indexData[$key] = $value[$i];
      }
    }

    if (empty($indexData)) {
      return [];
    }

    $currentData = array_merge( // Assign the next layer of data by reference
      $currentData,
      is_null( $config['remap'] ) ? $indexData : $this->remap( $bpData, $config['remap'] )
    );

    return $this->runModuleStatements( $containerScope, $config, $baseData, $currentData, false);
  }

  public function runModuleStatements( $containerScope, $config, $baseData, $currentData, $isBase ) {
    // 1. Convert $options into call args
    list($scope, $statements) = $this->resolveCallable( 'module',  $config['module'], $config['args'], StatementTypes::STYLE, $containerScope);


    // 2. Parse all "data" into types, then store in the scope
    $scope->define('data', 'module-base', $baseData );
    $scope->define('data', 'module-current', $currentData );
    $scope->define('data', 'is-base', $isBase );

    $scope->processStatements($statements);
    return $this->ruleReducer->reduce($scope->result()->content());

  }

  public function remap($data, $remap) {
    $remapped = [];

    foreach ( $data as $key => $value) {
      foreach ($remap as $base => $rewrite) {
        if (strpos($key, $base) === 0) {
          $new_key = $rewrite . substr($key, strlen($base));
          $remapped[$new_key] = $value;
        }
      }
    }


    return $remapped;
  }

  public function conditionCheck( $data, $conditions ) {
    if (empty($conditions)) {
      return true;
    }

    foreach ($conditions as $condition) {
      if (!$data[$condition['key']] === $condition['value']) {
        return false;
      }
    }

    return true;
  }

  public function finalize() {

    $moduleReducer = Factory::create(ModuleReducer::class);
    $moduleReducer->setup($this->id, 'm');
    $containers = [];
    $declarations = [];

    $containerResult = [];

    $utilized_var_ids = [];
    foreach ( $this->modules as $name => $module ) {
      list($container, $result) = $moduleReducer->reduce($module);

      foreach ( $result as $index => $declaration ) {
        if (preg_match_all('/var\(--tco-([\w-]+)\)/', $result[$index][0], $matches, PREG_SET_ORDER) ) {
          foreach($matches as $match) {
            $utilized_var_ids[$match[1]] = true;
          }
        }
      }

      foreach($container as $id => $modules) {
        if (!isset($containers[$id])) {
          $containers[$id] = [];
        }
        $containers[$id] = array_merge( $containers[$id], $modules );
      }

      $declarations = array_merge( $declarations, $result );
    }

    foreach ( $this->dynamicContent as $id => $list ) {
      if (!isset($containers[$id])) {
        $containers[$id] = [];
      }

      $containers[$id]['dynamic-content'] = [];

      foreach ($list as $key => $value) {
        if (isset( $utilized_var_ids[$key] ) ) {
          $containers[$id]['dynamic-content'][$key] = $value;
        }
      }

    }

    $tss = $this->declarationReducer->reduce(
      $declarations,
      $this->stack->lookup('internal', 'baseBreakpoint'),
      $this->stack->lookup('internal', 'breakpointRanges'),
      $this->stack->lookup('internal', 'selectorPrefix')
    );

    return [
      'containers' => $containers,
      'tss' => $tss
    ];
  }

}