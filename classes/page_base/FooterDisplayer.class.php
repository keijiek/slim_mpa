<?php

namespace page_base;

class FooterDisplayer {
  function __construct() {
    require_once(dirname(__DIR__, 2) . '/html/footer_part/footer_part.php');
  }
}
