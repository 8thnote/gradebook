<?php

function subjects_page_info() {
  return array(
    'path'       => 'subjects/%',
    'title'      => 'subjects_page_title',
    'breadcrumb' => 'subjects_page_breadcrumb',
    'content'    => 'subjects_page_content',
    'access'     => 'subjects_page_access',
  );
}

function subjects_page_access() {
  return TRUE;
}

function subjects_page_title($args) {
  $group_id = $args[1];
  return is_numeric($group_id) ? db_select_field("`groups`", "`name`", "`id` = '$group_id'") : t('All subjects');
}

function subjects_page_breadcrumb($args) {
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

function subjects_page_content($args) {
  $group_id = $args[1];
  $table    = array('attributes' => array('class' => array('subjects-view')));
  
  if (is_numeric($group_id)) {
    $group = db_select_row("`groups`", "*", "`id` = '$group_id'");
    $group_name = $group['name'];
    $group_info = unserialize($group['info']);
    $subjects   = array();
    $table['caption'] = $group_name;
    $table['header']  = array(
      'subject' => array('data' => t('Subject')),
      'teacher' => array('data' => t('Teachers')),
    );
    foreach ($group_info as $subject_id => $teachers_id) {
      $subject_name = db_select_field("`subjects`", "`name`", "`id` = '$subject_id'");
      $subjects[]   = array('id' => $subject_id, 'name' => $subject_name);
      $teacher_name = array();
      foreach($teachers_id as $teacher_id) {
        $teacher_name[] = db_select_field("`users`", "`name`", "`id` = '$teacher_id'");
      }
      $table['rows'][$subject_id] = array(
        'subject' => array('data' => l($subject_name, "gradebook/$group_id/$subject_id")),
        'teacher' => array('data' => implode(', ', $teacher_name)),
      );
    }
  }
  else {
    $subjects = db_select_array("`subjects`", "*", "1", "name");
    $table['caption'] = t('All subjects');
    $table['header']  = array(
      'subject' => array('data' => t('Subject')),
    );
    foreach ($subjects as $subject) {
      $table['rows'][$subject['id']] = array(
        'subject' => array('data' => $subject['name']),
      );
    }
  }
  
  if (user_role('admin')) {
    $table['header']['actions'] = array('data' => t('Actions'));
    foreach ($subjects as $subject) {
      $actions = array(
        l(t('Edit'), "subject/{$subject['id']}/edit", array('class' => array('button'))),
        l(t('Delete'), "subject/{$subject['id']}/delete", array('class' => array('button'))),
      );
      $table['rows'][$subject['id']]['actions'] = array(
        'data'       => item_list($actions, array('class' => array('actions'))),
        'attributes' => array('class' => 'actions'),
      );
    }
  }
  
  return table($table);
}

?>