<?php

class Config {

  // Editing whitelist. Leave empty for wide open access.
  var $allowed_edit_ips = array('127.0.0.1');

  // Whitelist for access. Leave empty if you don't want to restrict access.
  var $ip_whitelist = array();

  // Document Storage Dir
  var $documents_dir = 'documents/'; // add trailing slash

}