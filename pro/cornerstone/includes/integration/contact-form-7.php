<?php

add_filter('cornerstone_app_choices_contact_form_7', function() {

  $forms = WPCF7_ContactForm::find();
  $result = [];

  foreach ($forms as $form) {
    $result[] = array( 'value' => $form->id(),  'label' => $form->title() );
  }

  return $result;

});
