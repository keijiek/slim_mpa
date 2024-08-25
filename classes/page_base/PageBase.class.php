<?php

namespace page_base;

require_once(__DIR__ . '/HeaderDisplayer.class.php');
require_once(__DIR__ . '/FooterDisplayer.class.php');

abstract class PageBase {

  public function __construct(string $page_title="", string $site_name = "PHPテスト")
  {
    $this->prepare();
    new HeaderDisplayer($site_name, $page_title);
    $this->view();
    new FooterDisplayer();
  }

  abstract function prepare():void;
  abstract function view():void;
}
