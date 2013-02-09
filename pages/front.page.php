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
  return 'Frontpage';
}

function front_page_content() {
  $table = array(
    'caption' => 'table_test',
    'header' => array(
      array('data' => 1),
      array('data' => 2),
      array('data' => 3),
    ),
    'rows' => array(
      array(
        array('data' => 5),
        array('data' => 6),
        array('data' => 7),
      ),
      array(
        array('data' => 7),
        array('data' => 8),
        array('data' => 9),
      ),
    ),
    'attributes' => array('border' => 1),
  );
  return table($table);
}

?>