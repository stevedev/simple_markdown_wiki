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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/document.css" type="text/css" media="screen" title="no title" charset="utf-8">
  </head>
  <body>    
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a href="/" class="brand pull-left">docs.stevedev.com/<b><?= $filename ?></b></a>

          <?php if ($editable) : ?><a href="/edit/<?= $filename ?>" class="btn pull-right ">Edit</a><?php endif?>
        </div>
      </div>
    </div>
    
    <div class="container-fluid">
      <div class="row-fluid">
        <?= stripslashes($html) ?>
      </div>
    </div>
  </body>
</html>
