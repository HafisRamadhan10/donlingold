<?php

add_filter('cornerstone_app_choices_wpforms', function() {

  $forms = wpforms()->form->get( '', array( 'order' => 'DESC' ) );
  $result = [];

  foreach ($forms as $form) {
    $result[] = array( 'value' => $form->ID, 'label' => $form->post_title );
  }

  return $result;

});
