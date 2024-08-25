<?php

namespace common_class;

require_once(dirname(__DIR__) . '/page_base/PageBase.class.php');
use page_base\PageBase;

class CommonPage extends PageBase {

  function __construct(string $page_title="")
  {
    parent::__construct($page_title);
  }

  function prepare():void
  {

  }

  function view():void
  {

  }
}
