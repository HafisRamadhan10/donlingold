<?php

class Cornerstone_Header extends Cornerstone_Bar_Entity {
  protected $post_type = 'cs_header';
  protected $type = 'header';
  protected $entity = 'common.headers.entity';

  public function get_style_priority() {
    return 20;
  }
}
