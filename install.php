<?php

$problems = array();
$documents_dir = null;

if (file_exists('config.php')) {
  require('config.php');
  
  if (empty($documents_dir)) {
    $problems[] = 'empty_documents_dir';
  }
  
  if (!file_exists($documents_dir)) {
    $problems[] = 'documents_folder_not_found';
  }
  
  if (!is_writable($documents_dir)) {
    $problems[]  = 'documents_not_writable';
  }

} else {
  $problems[] = 'no-config';
}
?><!DOCTYPE html>
<html lang="en">
  <head>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/document.css" type="text/css" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
    
    <div class="container-fluid">
      <h1>Simple Markdown Wiki</h1>
      
      <p>
        Please fix the errors below:
      </p>
      
      <?php if (in_array('no-config', $problems)) : ?>
        <div class="alert alert-error">
          No <strong>config.php</strong> found! Please copy <strong>config_example.php</strong> to <strong>config.php</strong> and adjust the options as needed. 
        </div>
      <?php else : ?>
      
        <?php if (in_array('empty_documents_dir', $problems)): ?>
          <div class="alert alert-error">
            <p>
              Edit <strong>config.php</strong> and make sure you have $documents_dir set to something like this: 
            </p>
<pre>
$documents_dir = 'documents/';            
</pre>
          </div>
        <?php elseif (in_array('documents_folder_not_found', $problems)) : ?>
          <div class="alert alert-error">
            You need to create a folder called '<strong><?= rtrim($documents_dir, '/') ?></strong>'.
          </div>
        <?php elseif (in_array('documents_not_writable', $problems)) : ?>
           <div class="alert alert-error">
             '<strong><?= rtrim($documents_dir, '/') ?></strong>' is not writable.
            </div>
        <?php else : ?>
          <div class="alert alert-success">
            Good to go!
          </div>
        <?php endif ?>
        
      <?php endif ?>
      
    </div>
  </body>
</html>
