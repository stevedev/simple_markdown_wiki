<?php

include('config.php');
$config = new Config();

$filename = $_POST['filename'];
$file = str_replace('/', '_', $_POST['file']);
$content = $_POST['content'];

$result = file_put_contents($config->documents_dir . $file, $content);

header('location: /'.$filename);