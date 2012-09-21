<?php

include('config.php');
include('lib.php');
$config = new Config();

verify_edit_access($config->allowed_edit_ips);

$filename = ltrim($_SERVER['PATH_INFO'], '/');
$file = str_replace('/', '_', str_replace('.html', '.mdown', $filename));

if (file_exists($config->documents_dir . $file)) {
  $text = file_get_contents($config->documents_dir . $file);
} else {
  $text = '';
}

$cancel_link = str_replace('edit', '', $filename);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Edit Document</title>
    <link rel="stylesheet" href="/document.css" type="text/css" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
    <div class="container-fluid">
      
        <form action="/save.php" method="post" id="edit_form">
          <input type="hidden" name="filename" value="<?= $filename ?>">
          <input type="hidden" name="file" value="<?= $file ?>">
          <div class="row-fluid">
            <p class="span6">Editing /<em><?= $cancel_link ?></em></p>
            <p class="span6" style="text-align: right">
              <a href="javascript:document.getElementById('edit_form').submit()" class="btn btn-primary">Save Document</a>
              <a href="/<?= $cancel_link ?>" class="btn">Cancel</a>
            </p>

          <div class="row-fluid">
            <div class="span12">
              <textarea rows="40" style="width: 100%" name="content"><?= stripslashes($text) ?></textarea>
              <p align="right">
                <a href="http://daringfireball.net/projects/markdown/dingus" target="_blank">Use Markdown</a>
              </p>
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </body>
</html>
