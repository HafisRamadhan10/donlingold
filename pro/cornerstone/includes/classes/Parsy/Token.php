<?php


namespace Themeco\Cornerstone\Parsy;

use Themeco\Cornerstone\Parsy\Serializer;

class Token implements \JsonSerializable {
  protected $type;
  protected $content = null;

  public function __construct($type, $content = null) {
    $this->type = $type;
    $this->content = $content;
  }

  public function content() {
    return $this->content;
  }

  public function setContent($content) {
    $this->content = $content;
  }

  public function type() {
    return $this->type;
  }

  public function is($type) {
    return $this->type === $type;
  }

  public function jsonSerialize() {
    if (Serializer::isActive()) {
      $type = Serializer::index($this->type);
      return [ $type => $this->content ];
    }
    return [ 'node' => $this->type, 'content' => $this->content ];
  }

}