<?php

require('lib.php');
require('markdown.php');

// Make sure config exists. 
if (!file_exists('config.php')) {
  redirect('install.php');
}

require('config.php');
$config = new Config();


// Check if documents dir exists
if (!file_exists($config->documents_dir)) {
  redirect('install.php');
}

verify_read_access($config->ip_whitelist);
$editor = verify_edit_access($config->allowed_edit_ips);


$filename = !empty($_GET['f']) ? $_GET['f'] : 'index.html';
$file = str_replace('/', '_', str_replace('.html', '.mdown', $filename));

if (file_exists($config->documents_dir . $file)) {
  $text = file_get_contents($config->documents_dir . $file);
  $html = Markdown($text);
  $title = ucwords(str_replace("_", " ", str_replace(".mdown", "", $file)));
  $editable = $editor;
} elseif ($editor) {
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
