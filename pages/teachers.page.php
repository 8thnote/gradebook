<?php

function teachers_page_info() {
  return array(
    'path'    => 'teachers',
    'title'   => 'teachers_page_title',
    'content' => 'teachers_page_content',
    'access'  => 'teachers_page_access',
  );
}

function teachers_page_access() {
  return TRUE;
}

function teachers_page_title() {
  return t('Teachers');
}

function teachers_page_content() {
  $teachers = db_select_array("`users`", "*", "`role` = 'teacher'", 'name');
  
  $table = array(
    'caption'    => t('Teachers'),
    'attributes' => array('class' => array('faculties-view')),
  );
  
  $table['header']['title'] = array('data' => t('Teacher name'));
  foreach ($teachers as $teacher) {
    $table['rows'][$teacher['id']]['faculty'] = array(
      'data' => $teacher['name'],
    );
  }
  
  if (user_role('admin')) {
    $table['header']['actions'] = array('data' => t('Actions'));
    foreach ($teachers as $teacher) {
      $actions = array(
        l(t('Edit'), "teacher/{$teacher['id']}/edit", array('class' => array('button'))),
        l(t('Delete'), "teacher/{$teacher['id']}/delete", array('class' => array('button'))),
      );
      $table['rows'][$teacher['id']]['actions'] = array(
        'data'       => item_list($actions, array('class' => array('actions'))),
        'attributes' => array('class' => 'actions'),
      );
    }
  }

  return table($table);
}

?>