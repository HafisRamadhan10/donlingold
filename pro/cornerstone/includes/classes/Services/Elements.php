<?php

namespace Themeco\Cornerstone\Services;

use Themeco\Cornerstone\Elements\EntityCache;
use Themeco\Cornerstone\Elements\Renderer;
use Themeco\Cornerstone\Elements\Decorator;
use Themeco\Cornerstone\Elements\Manager;

class Elements extends Aggregate {

  public function __construct(EntityCache $entities, Tss $tss, Decorator $decorator, Renderer $renderer, Manager $manager) {
    $this->entities = $entities;
    $this->tss = $tss;
    $this->renderer = $renderer;
    $this->manager = $manager;
    $this->decorator = $decorator;
  }

  public function setup() {
    $this->entities->setDecorator($this->decorator);
    $this->decorator->setElementManager($this->manager);
    $this->tss->setElementManager($this->manager);
    $this->renderer->setElementManager($this->manager);
    $this->renderer->setElementDecorator($this->decorator);
  }

  public function init() {
    $this->manager->register(); // can not run earlier than the init action without potential plugin conflicts
    $this->renderer->start();
  }

  public function loadEntity( $entity ) {
    return $this->entities->load($entity);
  }

  public function registerEntityStyles( $entity ) {
    $id = $entity->get_id();
    $elementData = $this->loadEntity( $entity );
    $priority = $entity->get_style_priority();
    if (apply_filters( 'cs_register_entity_styles', true, $id, $priority ) ) {
      $this->tss->registerEntity( $id, $priority, $elementData);
    }
  }

}
