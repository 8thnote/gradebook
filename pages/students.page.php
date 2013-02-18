<?php

function students_page_info() {
  return array(
    'path'       => 'students/%',
    'title'      => 'students_page_title',
    'breadcrumb' => 'students_page_breadcrumb',
    'content'    => 'students_page_content',
    'access'     => 'students_page_access',
  );
}

function students_page_access() {
  return TRUE;
}

function students_page_title($args) {
  $group_id = $args[1];
  return is_numeric($group_id) ? db_select_field("`groups`", "`name`", "`id` = '$group_id'") : t('All students');
}

function students_page_breadcrumb($args) {
  $group_id = $args[1];
  if (is_numeric($group_id)) {
    $group_name   = db_select_field("`groups`", "`name`", "`id` = '$group_id'");
    $faculty_id   = db_select_field("`groups`", "`faculty_id`", "`id` = '$group_id'");
    $faculty_name = db_select_field("`faculties`", "`name`", "`id` = '$faculty_id'");
    $crumbs       = array(
      0 => l($faculty_name, 'groups/' . $faculty_id),
      1 => $group_name,
    );
    return item_list($crumbs);
  }
}

function students_page_content($args) {
  $group_id = $args[1];
  $students = is_numeric($group_id) ? db_select_array("`students`", "*", "`group_id` = '$group_id'", "name") : db_select_array("`students`", "*", "1", "name");
  
  $table = array(
    'caption'    => is_numeric($group_id) ? db_select_field("`groups`", "`name`", "`id` = '$group_id'") : t('All students'),
    'attributes' => array('class' => array('students-view')),
  );
  
  $table['header']['title'] = array('data' => t('Student name'));
  foreach ($students as $student) {
    $table['rows'][$student['id']]['student'] = array(
      'data' => $student['name'],
    );
  }
  
  if (user_role('admin')) {
    $table['header']['actions'] = array('data' => t('Actions'));
    foreach ($students as $student) {
      $actions = array(
        l(t('Edit'), "student/{$student['id']}/edit", array('class' => array('button'))),
        l(t('Delete'), "student/{$student['id']}/delete", array('class' => array('button'))),
      );
      $table['rows'][$student['id']]['actions'] = array(
        'data'       => item_list($actions, array('class' => array('actions'))),
        'attributes' => array('class' => 'actions'),
      );
    }
  }
  
  return table($table);
}

?>