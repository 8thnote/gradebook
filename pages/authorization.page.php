<?php

function authorization_page_info() {
  return array(
    'path'    => 'authorization',
    'title'   => 'authorization_page_title',
    'content' => 'authorization_page_content',
    'access'  => 'authorization_page_access',
  );
}

function authorization_page_title() {
  return 'Authorization';
}

function authorization_page_content() {
  return 'Authorization content';
}

function authorization_page_access() {
  return TRUE;
}

?>