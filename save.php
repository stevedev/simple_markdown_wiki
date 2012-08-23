<?php

include('config.php');

$filename = $_POST['filename'];
$file = str_replace('/', '_', $_POST['file']);
$content = $_POST['content'];

$result = file_put_contents($documents_dir . $file, $content);

header('location: /'.$filename);