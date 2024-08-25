<?php

namespace page_base;

require_once(dirname(__DIR__) . '/manifest_json_parser/ManifestJsonParser.class.php');
use ManifestJsonParser;

class HeaderDisplayer {
  function __construct(string $site_name, string $title="")
  {
    $this->display($this->generateTitle($site_name, $title));

  }

  private function display($page_title) {
    $manifest_json_path = dirname(__DIR__, 2).'/dist/.vite/manifest.json';
    $manifest_json = new ManifestJsonParser($manifest_json_path);
    $main_js_path =  '/' . 'dist/' . $manifest_json->main_js_path() .  '?' . $manifest_json->hash_param();
    $main_css_path = '/' . 'dist/' . $manifest_json->main_css_path() . '?' . $manifest_json->hash_param();
    require_once(dirname(__DIR__, 2) . '/html/header_part/header_part.php');
  }

  private function generateTitle($site_name, $page_title=""):string
  {
    if ($page_title) {
      return $page_title . ' | '. $site_name;
    } else {
      return $site_name;
    }
  }
}
