<?php

use Themeco\Cornerstone\Elements\BreakpointData;

/**
 * Access to Cornerstone data
 */
class Cornerstone_Element_Migrations  extends Cornerstone_Plugin_Component {

	public function migrate( $elements ) {

		if ( !is_array( $elements ) ) {
			return $elements;
		}

		$this->plugin->component( 'Element_Orchestrator' )->load_elements();

		foreach ($elements as $key => $element) {
			$is_classic = ! isset( $element['_type'] ) || ('section' === $element['_type'] && isset( $element['elements'] ) );
			$elements[$key] = $this->migrate_element( $is_classic ? $this->migrate_classic_element( $element ) : $element );
		}

		return $elements;
	}

	/**
	 * This will migrate an elements base values.
	 * We do not have logic at this time to migrate component values so component values should not change between versions
	 */
	public function apply_base_migrations( $element, $base_migrations, $base_values ) {

		if ( ! isset( $element['_m'] ) ) {
			$element['_m'] = [];
		}

		if ( ! isset( $element['_m']['e'] ) ) {
			$element['_m']['e'] = 0;
		}

		$start = $element['_m']['e'];
		$latest = count($base_migrations);

		if ($latest > $start) {
			$element['_m']['e'] = $latest;

			foreach ($base_migrations as $index => $migration ) {
				if ($index < $start) continue;

				// Explicitly set unset values to the earliest possible value in the migration list
				foreach($migration as $key => $value) {
					if ( ! isset( $element[$key] ) ) {
						$element[$key] = $value;
					}
				}

				// Unset values identicial to the the new default
				foreach($migration as $key => $value) {
					if ( isset( $element[$key] ) && $element[$key] === $base_values[$key] ) {
						unset( $element[$key] );
					}
				}
			}
		}

		return $element;

	}

	public function migrate_element( $element ) {

		$def = cs_get_element( $element['_type'] );
		$base_values = $def->get_base_values();
		$element = $this->query_style_migrations( $element, $base_values );

		$base_migrations = $def->get_migrations();
		if ( count( $base_migrations ) > 0 ) {
			$element = $this->apply_base_migrations( $element, $base_migrations, $base_values );
		}

		if ( isset( $element['_modules'] ) ) {
			foreach ( $element['_modules'] as $index => $child ) {
				$element['_modules'][$index] = $this->migrate_element( $child );
			}
		}

		return $element;
	}

	public function migrate_classic_element( $element ) {

		// Ensure '_type' is set
		if ( isset( $element['elType'] ) ) {
			$element['_type'] = $element['elType'];
			unset($element['elType']);
		}

		if ( !isset( $element['_type'] ) ) {
			return [ '_type' => 'unknown' ];
		}

		if ( false === strpos($element['_type'], 'classic:' ) ) {
			$element['_type'] = 'classic:' . $element['_type'];
		}

		if ( isset( $element['title'] ) && ! isset( $element['_label'] ) ) {
			$element['_label'] = $element['title'];
			unset( $element['title'] );
		}

		// Assign '_type' per element for children, and remove parent 'childType'
		if ( isset( $element['childType'] ) ) {
			if ( $element['childType'] != 'any' && isset( $element['elements'] ) ) {
				foreach ( $element['elements'] as $index => $child ) {
					$element['elements'][$index]['_type'] = $element['childType'];
				}
			}
			unset( $element['childType'] );
		}

		// Some quick inline layout migrations instead of checking the version for every individual element
		if ( 'classic:row' == $element['_type'] && isset( $element['columnLayout'] ) ) {
			unset($element['columnLayout']);
		}

		if ( 'classic:column' == $element['_type'] && isset( $element['active'] ) ) {
			$element['_active'] = $element['active'];
			unset($element['active']);
		}

		if ( isset( $element['custom_id'] ) ) {
			$element['id'] = $element['custom_id'];
			unset($element['custom_id']);
		}

		if ( isset( $element['border'] ) ) {
			if ( !isset( $element['border_width'] ) ) {
				$element['border_width'] = $element['border'];
			}
			unset( $element['border'] );
		}

		// Remap old visibility
		if ( isset( $element['visibility'] ) && is_array( $element['visibility'] ) ) {
			foreach ( $element['visibility'] as $key => $value) {
				$element['visibility'][$key] = str_replace( 'x-hide-', '', $value );
			}
		}

		// Remap old text align
		if ( isset( $element['text_align'] ) ) {
			$ta_migrate = array( 'left-text' => 'l', 'center-text' => 'c', 'right-text' => 'r', 'justify-text' => 'j' );
			if ( isset( $ta_migrate[ $element['text_align'] ] ) ) {
				$element['text_align'] = $ta_migrate[ $element['text_align'] ];
			}
		}

		if ( isset( $element['elements'] ) ) {
      $element['_modules'] = array();
			foreach ( $element['elements'] as $index => $child ) {
				$element['_modules'][$index] = $this->migrate_classic_element( $child );
			}
      unset($element['elements']);
		}

		return $element;

	}

	public function query_style_migrations( $element, $base_values ) {

		// All elements prior Cornerstone 6 do not have a base breakpoints
		if ( ! isset( $element['_bp_base'] ) ) {
			// treat legacy content as "desktop first" with 5 breakpoints (legacy stacks)
			$element['_bp_base'] = '4_4';
			// Will return an element that is "desktop first"
			$element = $this->layout_element_responsive_migration( $element );
		}

		list($base, $ranges, $size) = CS()->novus()->service('Breakpoints')->breakpointConfig();

		if ($base . '_' . $size !== $element['_bp_base'] ) { // current element does not match current base breakpoint

			$breakpointData = CS()->novus()->resolve(BreakpointData::class);
			$breakpointData->setElement($element, $base_values);
			$element = $breakpointData->convertTo($base, $size);
		}

		return $element;

	}

	public function layout_element_responsive_migration( $element ) {

		// Only migrate elements with legacy responsive values

		if ( ! in_array( $element['_type'], ['layout-grid', 'layout-cell', 'layout-row' ], true ) ) {
			return $element;
		}

		if ( $element['_type'] === 'layout-grid') {

			// migrate md,lg, and xl values from their previous defaults to ensure they exist

			if ( ! isset( $element['layout_grid_template_columns_md'] ) ) {
				$element['layout_grid_template_columns_md'] = '1fr 1fr';
			}

			if ( ! isset( $element['layout_grid_template_columns_lg'] ) ) {
				$element['layout_grid_template_columns_lg'] = '1fr 1fr';
			}

			if ( ! isset( $element['layout_grid_template_columns_xl'] ) ) {
				$element['layout_grid_template_columns_xl'] = '1fr 1fr 1fr 1fr';
			}

			return $this->migrate_layout_query_values( $element, [
				'layout_grid_template_columns' => '1fr',
				'layout_grid_template_rows'    => 'auto',
			]);
		}

		if ( $element['_type'] === 'layout-row') {
			return $this->migrate_layout_query_values( $element, [ 'layout_row_layout' => '100%' ] );
		}

		if ( $element['_type'] === 'layout-cell') {
			return $this->migrate_layout_query_values( $element, [
				'layout_cell_column_start'  => '',
				'layout_cell_column_end'    => '',
				'layout_cell_row_start'     => '',
				'layout_cell_row_end'       => '',
				'layout_cell_justify_self'  => 'auto',
				'layout_cell_align_self'    => 'auto'
			] );
		}



		return $element;

	}

	public function migrate_layout_query_values( $element, $values) {
		foreach ($values as $key => $default) {
			$element = $this->migrate_layout_query_value($element, $key, $default);
		}

		return $element;
	}

	public function migrate_layout_query_value( $element, $dataKey, $default ) {

		$breakpointKey = '_bp_data' . $element['_bp_base'];
		$allValues = [];

		$bps = ['xl', 'lg', 'md', 'sm', 'xs'];

		// Create an ordered list with all values present
		foreach ($bps as $index => $bp) {
			$bp_key = $dataKey . '_' . $bp;
			$allValues[$index] = isset($element[$bp_key]) ? $element[$bp_key] : $default;
		}

		// Set the new base key if it doesn't match the element default
		if ($allValues[0] !== $default) {
			$element[$dataKey] = $allValues[0];
		}


		// populate query values
		$queryValues = [];
		$previous = $allValues[0];
		$hasQueryValues = false;

		foreach ($allValues as $index => $value) {
			if ($index === 0 || $value === $previous) {
				$queryValues[$index] = null;
				continue;
			}
			$previous = $value;
			$queryValues[$index] = $value;
			$hasQueryValues = true;
		}

		// set the query values
		if ($hasQueryValues) {
			if ( ! isset( $element[$breakpointKey] ) ) {
				$element[$breakpointKey] = [];
			}
			$element[$breakpointKey][$dataKey] = array_reverse($queryValues);

		}

		return $element;
	}

}
