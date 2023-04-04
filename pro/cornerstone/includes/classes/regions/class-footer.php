<?php

class Cornerstone_Footer extends Cornerstone_Bar_Entity {
  protected $post_type = 'cs_footer';
  protected $type = 'footer';
  protected $entity = 'common.footers.entity';

  public function get_style_priority() {
    return 30;
  }
}
