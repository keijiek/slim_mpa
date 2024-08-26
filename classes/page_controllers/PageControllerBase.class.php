<?php

namespace page_controllers;

require_once(dirname(__DIR__).'/page_viewers/PageViewerBase.class.php');
use page_viewers\PageViewerBase;

abstract class PageControllerBase {
  private string $page_title;
  private string $site_title;


  function __construct(string $page_title = '')
  {
    $this->page_title = $page_title;
    $this->site_title = 'PHP Multi Page App Test';
  }

  function html($html):string {}

  abstract function content():string;

}
