<?php

include('markdown.php');
include('config.php');

if (in_array($_SERVER['REMOTE_ADDR'], $allowed_ips)) {
  $admin = true;
} else { 
  $admin = false;
}

// Check if documents dir exists
if (!file_exists($documents_dir)) {
  header('location:install.php');
  exit();
}

$filename = !empty($_GET['f']) ? $_GET['f'] : 'index.html';
$file = str_replace('/', '_', str_replace('.html', '.mdown', $filename));

if (file_exists($documents_dir . $file)) {
  $text = file_get_contents($documents_dir . $file);
  $html = Markdown($text);
  $title = ucwords(str_replace("_", " ", str_replace(".mdown", "", $file)));
  $editable = $admin;
} elseif ($admin) {
  $html = "<p>File does not yet exist. <a href=\"/edit/{$file}\">Create it.</a> </p>";
  $editable = false;
} else {
  $editable = false;
  $html = 'File not found!';
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/document.css" type="text/css" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
    
    <div class="container-fluid">
      
      <div class="row-fluid">
        <div class="span9">
          /<a href="/">docs.stevedev.com</a>/<?= $filename ?>
        </div>
        <p class="span3" style="text-align: right">
          <?php if ($editable) : ?>
            <a href="/edit/<?= $filename ?>" class="btn">Edit Document</a>
          <?php endif?>
        </p>
      </div>
      <div class="row-fluid">
        <?= stripslashes($html) ?>
      </div>
    </div>
  </body>
</html>
