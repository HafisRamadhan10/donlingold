<?php

class Cornerstone_Condition_Matcher extends Cornerstone_Plugin_Component {

  public function normalize_rule_set_groups( $rule_sets ) {
    $groups = [];
    $index = 0;

    foreach ($rule_sets as $set) {

      if ( isset( $set['group'] ) && $set['group'] ) {
        $index++;
      }
      if ( ! isset( $groups[$index] ) ) {
        $groups[$index] = [];
      }

      $groups[$index][] = [
        $set['condition'],
        $set['value'],
        isset( $set['toggle'] ) ? ! $set['toggle'] : null,
        isset( $set['operator'] ) ? $set['operator'] : null,
        isset( $set['operand'] ) ? $set['operand'] : null
      ];

    }

    return array_values($groups);
  }

  public function evaluate_rule( $type, $value, $invert = false, $operator = null, $operand = null ) {

    $parts = explode( '|', $type );
    $handler = array_shift( $parts );
    $rule_name = str_replace(':', '_', str_replace('-', '_', $handler ) );
    if ( $operator ) $rule_name .= '_' . str_replace('-', '_', $operator );
    $base_args = is_null( $operand ) ? [ $value ] : [ $operand, $value ];
    $args = empty( $parts ) ? $base_args : array_merge( $parts, $base_args);

    $method = [ 'Cornerstone_Condition_Rules', $rule_name ];
    $is_callable = is_callable( $method );

    if ( ! has_filter( 'cs_condition_rule_' . $rule_name ) && ! $is_callable ) {
      trigger_error("No rule matching function for $rule_name ", E_USER_WARNING );
      return false;
    }

    $result = apply_filters('cs_condition_rule_' . $rule_name, $is_callable ? call_user_func_array( $method, $args ) : false, $args);

    return $invert && ! $operator ? ! $result : $result;
  }

  // A group matches if all of its rules are true
  public function match_rule_group( $rule_group ) {

    foreach ($rule_group as $rule) {
      if ( ! call_user_func_array( [ $this, 'evaluate_rule'], $rule ) ) {
        return false;
      }
    }

    return true;
  }

  // A set matches if any of its groups are true

  public function match_rule_set( $rule_sets ) {

    $groups = $this->normalize_rule_set_groups( $rule_sets );

    foreach ($groups as $group) {
      if ( $this->match_rule_group( $group ) ) {
        return true;
      };
    }

    return false;

  }
}
