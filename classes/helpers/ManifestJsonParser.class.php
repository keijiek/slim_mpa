<?php
namespace helpers;

class ManifestJsonParser {
  private $json;
  private $manifest_hash;

  function __construct($manifest_json_path=null)
  {
    $manifest_path = $manifest_json_path ?? dirname(__DIR__, 2) . '/dist/.vite/manifest.json';
    $this->json = json_decode(
      file_get_contents($manifest_path),
      true
    );
    $this->manifest_hash = filemtime($manifest_path);
  }

  function hash_param(): string
  {
    return $this->manifest_hash;
  }

  function main_js_path():string
  {
    return $this-> json['index.js']['file'];
  }

  function main_css_path():string
  {
    return $this->json['index.js']['css'][0];
  }

  function main_js_path_with_hash():string
  {
    return '/' . $this->main_js_path() . '?' . $this->hash_param();
  }

  function main_css_path_with_hash():string
  {
    return '/' . $this->main_css_path() . '?' . $this->hash_param();
  }
}
