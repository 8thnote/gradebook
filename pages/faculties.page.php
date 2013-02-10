<?php

function faculties_page_info() {
  return array(
    'path'    => 'faculties',
    'title'   => 'faculties_page_title',
    'content' => 'faculties_page_content',
    'access'  => 'faculties_page_access',
  );
}

function faculties_page_access() {
  return TRUE;
}

function faculties_page_title() {
  return 'Faculties';
}

function faculties_page_content() {
  $faculties = db_select_array("`faculties`", "*");
  $table = array();
  $table['attributes'] = array('border' => 1);
  $table['caption'] = t('Faculties');
  $table['header'] = array(
    array('data' => t('Faculty name')),
  );
  foreach ($faculties as $faculty) {
    $table['rows'][] = array(
      array('data' => l($faculty['name'], 'groups/' . $faculty['id'])),
    );
  }
  return table($table);
}

?>