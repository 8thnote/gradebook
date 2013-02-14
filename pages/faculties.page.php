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
  return t('Faculties');
}

function faculties_page_content() {
  $faculties = db_select_array("`faculties`", "*");
  
  $table = array(
    'caption'    => t('Faculties'),
    'attributes' => array('class' => array('faculties-view')),
  );
  
  $table['header']['title'] = array('data' => t('Faculty name'));
  foreach ($faculties as $faculty) {
    $table['rows'][$faculty['id']]['faculty'] = array(
      'data' => l($faculty['name'], 'groups/' . $faculty['id']),
    );
  }
  
  if (user_role('admin')) {
    $table['header']['actions'] = array('data' => t('Actions'));
    foreach ($faculties as $faculty) {
      $actions = array(
        l(t('Edit'), "faculty/{$faculty['id']}/edit", array('class' => array('button'))),
        l(t('Delete'), "faculty/{$faculty['id']}/delete", array('class' => array('button'))),
      );
      $table['rows'][$faculty['id']]['actions'] = array(
        'data' => item_list($actions, array('class' => array('actions'))),
      );
    }
  }
  
  return table($table);
}

?>