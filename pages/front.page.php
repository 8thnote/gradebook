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
  $table = array(
    'caption'    => 'table_test',
    'header'     => array(
      array('data' => 1),
      array('data' => 1),
      array('data' => 3),
    ),
    'rows'       => array(),
    'attributes' => array('id' => 'foo'),
  );
  return table($table);
}

function front_page_access() {
  return TRUE;
}

?>