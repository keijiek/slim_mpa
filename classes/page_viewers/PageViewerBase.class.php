<?php

namespace page_viewers;

require_once(dirname(__DIR__, 2) . '/classes/manifest_json_parser');
use helpers\ManifestJsonParser;

abstract class PageViewerBase {
  private string $page_title;
  private string $site_name;

  function __construct(string $page_title, string $site_name)
  {
    $this->page_title = $page_title;
    $this->site_name = $site_name;
  }

  function html():string
  {
    ob_start();
    $this->helmet();
    $this->content();
    $this->footer_part();
    return ob_get_clean();
  }

  // 抽象: 継承する子クラスらが、それぞれ表示したいページ内容を用意するメソッド
  abstract function content(): void;

  private function helmet(): void
  {
    $this->head_part();
    $this->header_part();
  }

  /**
   * <html>開始 & <head></head> & <body>開始
   */
  private function head_part(): void
  {
    // heaer_part が使う変数を用意
    $manifest_json = new ManifestJsonParser();
    $js_path = $manifest_json->main_js_path_with_hash();
    $css_path = $manifest_json->main_css_path_with_hash();
    $page_title = $this->generateTitle($this->site_name, $this->page_title);
    // header_part を require
    require_once(dirname(__DIR__, 2) . '/html/helmet/head_part.php');
  }

  /**
   * <header></header> ~ <main>開始
   */
  private function header_part(): void
  {
    require_once(dirname(__DIR__, 2) . '/html/helmet/header_element.php');
  }

  /**
   * </main> ~ <footer></footer> & </body> & </html> 終了
   */
  private function footer_part(): void
  {
    require_once(dirname(__DIR__, 2) . '/html/boots/footer_part.php');
  }

  private function generateTitle(string $site_name, string $page_title = ""): string
  {
    if ($page_title) {
      return $page_title . ' | ' . $site_name;
    } else {
      return $site_name;
    }
  }
}
