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
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a href="/" class="brand">docs.stevedev.com/<b><?= $filename ?></b></a>
          <div class="pull-right btn-group">
           <a href="javascript:document.getElementById('edit_form').submit()" class="btn btn-primary">Save</a>
            <a href="/<?= $cancel_link ?>" class="btn">Cancel</a>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
        <form action="/save.php" method="post" id="edit_form">
          <input type="hidden" name="filename" value="<?= $filename ?>">
          <input type="hidden" name="file" value="<?= $file ?>">

          <div class="row-fluid">
            <textarea rows="40" name="content" class="span12"><?= stripslashes($text) ?></textarea>
            <p class="pull-right">
              Tip: <a href="http://daringfireball.net/projects/markdown/dingus" target="_blank">Use Markdown</a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
