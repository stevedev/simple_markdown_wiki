<?php

// Common functions


function redirect($path) {
  header('location:' . $path);
  exit();
}


function verify_read_access($ip_whitelist) {
  if (!empty($ip_whitelist) && !in_array($_SERVER['REMOTE_ADDR'], $ip_whitelist)) {
    redirect('access_denied.html');
  }
}

function verify_edit_access($allowed_edit_ips) {
  return (empty($allowed_edit_ips) || in_array($_SERVER['REMOTE_ADDR'], $allowed_edit_ips));
}