<?php

function front_page_info() {
  return array(
    'path'    => 'frontpage',
    'title'   => 'front_page_title',
    'content' => 'front_page_content',
    'access'  => 'front_page_access',
  );
}

function front_page_access() {
  return TRUE;
}

function front_page_title() {
  return t('Front');
}

function front_page_content() {
  return tag('h3', 'Hello World!!!');
}

?>