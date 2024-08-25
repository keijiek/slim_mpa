<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
  if ($_SERVER['SERVER_NAME'] === 'localhost') {
  ?>
    <script type="module" src="http://127.0.0.1:5173/src/@vite/client"></script>
    <script type="module" src="http://127.0.0.1:5173/src/index.js"></script>
  <?php
  } else {
  ?>
    <link rel="stylesheet" href="<?= $main_css_path ?>">
    <script type="module" src="<?= $main_js_path ?>"></script>
  <?php
  }
  ?>
  <title><?= $page_title ?></title>
</head>

<body>
  <header>
    <div class="container mx-auto py-4 px-2 lg:px-0">
      <h1 class="text-4xl">見出し</h1>
      <nav>
        <ul class="flex flex-row gap-4">
          <li><a href="#">アイテム</a></li>
          <li><a href="#">アイテム</a></li>
          <li><a href="#">アイテム</a></li>
          <li><a href="#">アイテム</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <main>
    <div class="container mx-auto py-4 px-2 lg:px-0">
