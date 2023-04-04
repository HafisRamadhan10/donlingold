<?php
/**
 * Responsible for loading all Cornerstone elements
 */
class Cornerstone_Legacy_Renderer extends Cornerstone_Plugin_Component {

	private $manager;

	public function setup() {
		$this->manager = CS()->component( 'Element_Orchestrator' );
	}

	/**
	 * Return an element that has been rendered with data formatted for saving
	 * @param  array $data  element data
	 * @return string       final shortcode
	 */
	public function save_element( $data ) {

		$element = $this->manager->get($data['_type']);

    $data = $this->mk3_unnormalize( $data );
    $formatted = $this->formatData( $data, true );

    return array(
      'content' => $element->renderElement( $formatted ),
      'data' => $this->mk3_normalize( $data  )
    );

	}

  public function mk3_unnormalize( $element ) {

    // Convert
    //   _modules -> elements
    //   classic:type -> type

    $element['_type'] = str_replace('classic:', '', $element['_type'] );

    if ( isset( $element['_modules'] ) ) {
      $elements = array();
			foreach ( $element['_modules'] as $child ) {
        $elements[] = $this->mk3_unnormalize( $child );
      }
      $element['elements'] = $elements;
      unset( $element['_modules'] );
    }

    return $element;
  }

  public function mk3_normalize( $element ) {

    $element['_type'] = 'classic:' . $element['_type'];

    if ( isset( $element['elements'] ) ) {
      $elements = array();
			foreach ( $element['elements'] as $child ) {
        $elements[] = $this->mk3_normalize( $child );
      }
      $element['_modules'] = $elements;
      unset( $element['elements'] );
    }

    return $element;
  }

	/**
	 * Return an element that has been rendered with data formatted for the preview window
	 * @param  array $data  element data
	 * @return string       shortcode to be processed for preview window
	 */
	public function renderElement( $data ) {

		$element = $this->manager->get($data['_type']);

		if ( !$element || !is_callable( array( $element, 'render' ) ) ) {
			return '';
		}

		if ( (did_action( 'cs_element_rendering' ) || did_action( 'cs_before_preview_frame' )) && !$element->can_preview() ) {
			return '';
		}

    $data = $this->formatData( $data );

		$emptyConditions = $element->emptyCondition();
		$renderEmpty = false;
		if ( is_array( $emptyConditions ) ) {

			$remainingConditions = array();

			foreach ($element->emptyCondition() as $conditionName => $conditionValue) {

				$negate = ( strpos($conditionName, '!') == 0 );

				if ($negate)
					$conditionName = str_replace('!', '', $conditionName);

			$controlValue = $data[$conditionName];

			$check = ( is_array($controlValue) ) ? in_array( $controlValue, $conditionValue ) : ( $controlValue == $conditionValue );

			if ( $negate )
				$check = !$check;

			if ($check)
				$remainingConditions[] = $conditionName;

			}

			$renderEmpty = empty($remainingConditions);

		} elseif ( $emptyConditions == true ) {
			$renderEmpty = true;
		}
	
		return $renderEmpty ? '' : $element->renderElement( $data );

	}

	/**
	 * Process data before it is rendered.
	 * @param  array   $data    Input data
	 * @param  boolean $saving  If the data is meant to be saved (otherwise we're in the preview window)
	 * @param  boolean $child   Flag indicating if we're working recursively
	 * @return [type]           Formatted output data
	 */
	public function formatData( $data, $saving = false, $child = false ) {

		$element = $this->manager->get( str_replace('classic:', '', $data['_type'] ) );

    if ( is_null( $element ) ) {
			trigger_error( sprintf( 'Cornerstone: Element %s not registered.', $data['_type'] ) );
			return $data;
		}

    // Capture Mk2 undefined
    if ( 'undefined' === $element->name() ) {
      return array( '_type' => 'undefined' );
    }

		$data = wp_parse_args( $data, $element->get_defaults() );

		if ( isset( $data['_modules'] ) ) {
			$data['elements'] = $data['_modules'];
		}

		// Recursively apply to child collections
		if (isset($data['elements']) && count( $data['elements'] ) > 0 ) {

			$elements = array();
			foreach ($data['elements'] as $key => $item) {
				$elements[] = $this->formatData( $item, $saving, true );
			}
			$data['elements'] = $elements;

		} else {
			$data['elements'] = array();
		}

		if ( isset( $data['custom_id'] ) ) {
			$data['id'] = $data['custom_id'];
			unset($data['custom_id']);
		}

		// Format data before rendering
		foreach ($data as $key => $item) {

			if ( is_array($item) && count($item) == 5 && ( $item[4] == 'linked' || $item[4] == 'unlinked' ) ) {
				$data[$key . '_linked' ] = array_pop($item);
				$data[$key] = array_map( 'esc_html', array( $item[0],$item[1],$item[2],$item[3] ) );
				continue;
			}

			// Convert boolean to string
			if ( $item === true ) {
				$data[$key] = 'true';
				continue;
			}

			if ( $item === false ) {
				$data[$key] = 'false';
				continue;
			}

		}

		if ( !isset( $data['content'] ) ) {
			$data['content'] = '';
		}

		return $data;
	}

}
