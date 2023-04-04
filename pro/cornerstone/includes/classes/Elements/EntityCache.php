<?php

namespace Themeco\Cornerstone\Elements;

use Themeco\Cornerstone\Util\MapCache;

class EntityCache extends MapCache {

  protected $idPopulater;
  protected $decorator;

  public function __construct( IdPopulater $idPopulater){
    $this->idPopulater = $idPopulater;
  }

  public function setDecorator($decorator) {
    $this->decorator = $decorator;
  }

  public function load( $entity ) {
    return $this->resolve( $entity->get_id(), function() use ($entity) {
      return $entity->get_root_element_data();
    } );
  }

  public function transform( $id, $elements ) {
    return $this->decorator->decorate(
      $id,
      is_array( $elements ) ? $this->idPopulater->populate( $elements ) : []
    );
  }
}