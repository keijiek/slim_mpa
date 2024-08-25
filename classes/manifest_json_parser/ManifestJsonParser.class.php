<?php

class ManifestJsonParser {
  private $file_path;
  private $json;

  function __construct($manifest_json_path=null)
  {
    $this->file_path = $manifest_json_path ?? dirname(__DIR__, 2). '/dist/.vite/manifest.json' ;
    $json_string = file_get_contents($this->file_path);
    $this->json = json_decode($json_string, true);
  }

  function main_js_path():string
  {
    return $this-> json['index.js']['file'];
  }

  function main_css_path():string
  {
    return $this->json['index.js']['css'][0];
  }

  function hash_param():string
  {
    return filemtime($this->file_path);
  }
}
