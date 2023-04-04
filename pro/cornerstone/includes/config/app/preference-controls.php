<?php

return array(

  array(
    'key'         => 'content_layout_element',
    'type'        => 'select',
    'title'       => __( 'Content Layout Element', 'cornerstone' ),
    'description' => __( 'Select which element you would like to be the default child when adding new sections.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.content_layout_element.user' => true ),
    'options'     => array(
        'choices' => apply_filters( 'cs_content_layout_element_options', [
             [ 'value' => 'layout-row', 'label' => __( 'Row', 'cornerstone' ) ],
             [ 'value' => 'row', 'label' => __( 'Classic Row', 'cornerstone' ) ]
        ] )
    )
  ),

  array(
    'key'         => 'dynamic_content',
		'type'        => 'toggle',
		'title'       => __( 'Dynamic Content', 'cornerstone' ),
		'description' => __( 'Show controls to open Dynamic Content wherever it is supported.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.dynamic_content.user' => true ),
	),

  array(
    'key'         => 'show_wp_toolbar',
		'type'        => 'toggle',
		'title'       => __( 'WordPress Toolbar', 'cornerstone' ),
		'description' => __( 'Allow WordPress to display the toolbar above the app. Requires a page refresh to take effect.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.show_wp_toolbar.user' => true ),
	),

  array(
    'key'         => 'help_text',
		'type'        => 'toggle',
		'title'       => __( 'Help Text', 'cornerstone' ),
		'description' => __( 'Show helpful inline messaging throughout the tool to describe various features.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.help_text.user' => true ),
  ),

  array(
    'key'         => 'rich_text_default',
    'type'        => 'toggle',
    'title'       => __( 'Rich Text Editor Default', 'cornerstone' ),
    'description' => __( 'By default, start text editors in rich text mode whenever possible.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.rich_text_default.user' => true ),
  ),

  array(
    'key'         => 'context_menu',
		'type'        => 'toggle',
		'title'       => __( 'Context Menu', 'cornerstone' ),
		'description' => __( 'Allow context menu to appear when alt-clicking in the live preview.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.help_text.user' => true ),
  ),

  array(
    'key'         => 'ui_theme',
    'type'        => 'choose',
    'title'       => __( 'UI Theme', 'cornerstone' ),
    'description' => __( 'Select how you would like the application UI to appear.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.ui_theme.user' => true ),
    'options'     => array(
      'choices' => array(
        array( 'value' => 'light', 'label' => __( 'Light', 'cornerstone' ) ),
        array( 'value' => 'dark', 'label' => __( 'Dark', 'cornerstone' ) )
      )
    )
  ),

  array(
    'key'         => 'status_indicators',
    'type'        => 'select',
    'title'       => __( 'Status Indicators', 'cornerstone' ),
    'description' => __( 'Select the contexts where you would like to see element status indicators.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.content_layout_element.user' => true ),
    'options'     => array(
      'choices' => array(
        array( 'value' => 'all', 'label' => __( 'Workspace and Breadcrumbs', 'cornerstone' ) ),
        array( 'value' => 'breadcrumbs', 'label' => __( 'Breadcrumbs Only', 'cornerstone' ) ),
        array( 'value' => 'workspace', 'label' => __( 'Workspace Only', 'cornerstone' ) ),
        array( 'value' => 'off', 'label' => __( 'Off', 'cornerstone' ) )
      )
    )
  ),

  array(
    'key'         => 'dev_toolkit',
    'type'        => 'toggle',
    'title'       => __( 'Dev Toolkit', 'cornerstone' ),
    'description' => __( 'Experimental functionality used by Themeco developers. Use at your own risk.', 'cornerstone' ),
    'condition'   => array( 'user_can:manage_options' => true ),
  ),

  array(
    'key'         => 'auto_close_elements',
		'type'        => 'toggle',
		'title'       => __( 'Auto Close Elements', 'cornerstone' ),
		'description' => __( 'Close Elements when an element is dragged in. Hold cmd/ctrl to invert.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.auto_close_elements.user' => true ),
  ),

  array(
    'key'         => 'preserve_nav_group',
		'type'        => 'toggle',
		'title'       => __( 'Preserve Inspector Group', 'cornerstone' ),
		'description' => __( 'When navigating between elements this will keep the same group open if it exists on the subsequent element. Hold cmd/ctrl to invert.', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.preserve_nav_group.user' => true ),
  ),

  array(
    'key'         => 'navbar_orientation',
		'type'        => 'select',
		'title'       => __( 'Navigation Bar', 'cornerstone' ),
		'description' => __( 'Set the order and alignment of the Navigation Bar components', 'cornerstone' ),
    'condition'   => array( 'user_can:preference.navbar_orientation.user' => true ),
    'options'     => array(
      'choices' => array(
        array( 'value' => 'start|breadcrumbs|control-groups',  'label' => __( 'Breadcrumbs + Control Groups (Left)', 'cornerstone' ) ),
        array( 'value' => 'end|breadcrumbs|control-groups',    'label' => __( 'Breadcrumbs + Control Groups (Right)', 'cornerstone' ) ),
        array( 'value' => 'spaced|breadcrumbs|control-groups', 'label' => __( 'Breadcrumbs + Control Groups (Spaced)', 'cornerstone' ) ),
        array( 'value' => 'start|control-groups|breadcrumbs',  'label' => __( 'Control Groups + Breadcrumbs (Left)', 'cornerstone' ) ),
        array( 'value' => 'end|control-groups|breadcrumbs',    'label' => __( 'Control Groups + Breadcrumbs (Right)', 'cornerstone' ) ),
        array( 'value' => 'spaced|control-groups|breadcrumbs', 'label' => __( 'Control Groups + Breadcrumbs (Spaced)', 'cornerstone' ) )
      )
    )
  ),

);
