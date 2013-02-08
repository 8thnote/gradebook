<?php

function front_page_info() {
  return array(
    'path'    => 'frontpage',
    'title'   => 'front_page_title',
    'content' => 'front_page_content',
    'access'  => 'front_page_access',
  );
}

function front_page_title() {
  return 'Frontpage';
}

function front_page_content() {
  return 'Frontpage content';
}

function front_page_access() {
  return TRUE;
}

?>