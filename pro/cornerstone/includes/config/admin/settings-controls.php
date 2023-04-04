<?php

return [
  [
    'key' => 'custom_app_slug',
    'type' => 'text',
    'title'       => __( 'Custom Path', 'cornerstone' ),
    'description' => __( 'Change the path used to load the main interface.', 'cornerstone' ),
    'options' => array(
      'placeholder' => apply_filters( 'cornerstone_default_app_slug', 'cornerstone' )
    ),
  ],
  [
    'key' => 'hide_access_path',
    'type' => 'checkbox',
    'title'       => __( 'Hide Access Path', 'cornerstone' ),
    'description' => __( 'Logged out users trying to access the interface will see a 404 instead of a login prompt.', 'cornerstone' ),
  ]
];
