<?php

namespace Themeco\Cornerstone\Tss;
use Themeco\Cornerstone\Parsy\Token;
use Themeco\Cornerstone\Parsy\Serializer;

class Compiler {


  public function __construct(StyleParser $parser, Serializer $serializer) {
    $this->parser = $parser;
    $this->serializer = $serializer;
  }

  public function setup() {
    $this->parser->setup();
  }

  public function run($input) {
    return $this->serializer->serialize(new Token('document', $this->parse($input)));
  }

  public function parse($filename) {
    if (! file_exists($filename)) {
      throw new \Exception("Input file does not exist: $filename");
    }

    $tss = file_get_contents($filename);

    if (!$tss) return [];

    $base = dirname($filename) . '/';
    try {
      $statements = $this->parser->run(file_get_contents($filename))->content();
    } catch  (\Throwable $e) {
      $message = $e->getMessage();
      throw new \Exception( "$message $filename");
    }


    $combined = [];
    foreach ($statements as $statement) {
      if ($statement->is('import')) {
        $combined = array_merge( $combined, $this->parse( $base . $statement->content()->content() . '.tss'));
      } else {
        $combined[] = $statement;
      }
    }

    return $combined;
  }
}