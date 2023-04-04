<?php

namespace Themeco\Cornerstone\Util;

class TransientCache {

  protected $cache;

  protected $config = [
    'salt'          => '',
    'transient'     => '',
    'metaDelimiter' => ':',
    'metaPrefix'    => 'r',
    'rowDelimeter'  => 'ENDROW',
    'set'           => null,
    'serialize'     => null,
    'unserialize'   => null,
  ];

  protected $dirty = false;

  public function config( $args ) {
    $this->config = array_merge( $this->config, $args);
  }

  public function get( $name, $input, $transform ) {

    $key = crc32($name . $this->config['salt']);

    if (!isset($this->cache) && $this->config['transient']) {
      $this->load();
    }

    $hash = $this->checksum($input);

    if (!isset($this->cache[$key]) || $this->cache[$key]['hash'] !== $hash ) {

      $result = is_callable( $transform ) ? $transform($input) : $input;
      $this->cache[ $key ] = [
        'hash' => $hash,
        'unserialized' => $result,
        'serialized' => $this->serialize($result)
      ];

      $this->dirty = true;
    }

    return $this->cache[$key]['unserialized'];

  }

  public function load() {

    // delete_transient($this->config['transient']);
    $stored = get_transient($this->config['transient']);
    if (false === $stored) return [];

    $rows = explode($this->config['rowDelimeter'], $stored);

    $this->cache = [];

    $key = null;

    foreach ($rows as $row) {
      if (strpos($row, $this->config['metaPrefix'] . $this->config['metaDelimiter']) === 0) {
        list($prefix, $key, $hash) = explode($this->config['metaDelimiter'], $row);
        $this->cache[$key] = [ 'hash' => (int) $hash, 'serialized' => [] ];
        continue;
      } else {
        if (!$key) {
          continue;
        }
      }

      $this->cache[$key]['serialized'][] = $row;
    }

    foreach( $this->cache as $key => $row ) {
      $this->cache[$key]['serialized'] = implode($this->config['rowDelimeter'], $this->cache[$key]['serialized']);
      $this->cache[$key]['unserialized'] = $this->unserialize($this->cache[$key]['serialized']);
    }

  }

  public function checksum($input) {
    return crc32($input);
  }

  public function commit() {
    if (!$this->dirty) return;

    $buffer = [];

    foreach( $this->cache as $id => $row) {
      $buffer[] = $this->config['metaPrefix'] . ':' . $id . ':' . $row['hash'];
      $buffer[] = $row['serialized'];
    }

    set_transient($this->config['transient'], implode($this->config['rowDelimeter'], $buffer));

  }

  public function configFn($name, $input) {
    $fn = $this->config[$name];
    return is_callable( $fn) ? $fn($input) : $input;
  }

  public function set($input) {
    return $this->configFn( 'set', $input );
  }

  public function serialize($input) {
    return $this->configFn( 'serialize', $input );
  }

  public function unserialize($input) {
    return $this->configFn( 'unserialize', $input );
  }

}
