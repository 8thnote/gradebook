<?php

function subjects_page_info() {
  return array(
    'path'    => 'subjects/%',
    'title'   => 'subjects_page_title',
    'content' => 'subjects_page_content',
    'access'  => 'subjects_page_access',
  );
}

function subjects_page_access() {
  return TRUE;
}

function subjects_page_title($args) {
  $group_id = $args[1];
  return db_select_field("`groups`", "`name`", "`id` = '$group_id'");
}

function subjects_page_content($args) {
  $group_id = $args[1];
  $group = db_select_row("`groups`", "*", "`id` = '$group_id'");
  $group_name = $group['name'];
  $group_info = unserialize($group['info']);
  $table = array();
  $table['attributes'] = array('border' => 1);
  $table['caption'] = $group_name;
  $table['header'] = array(
    array('data' => t('Subject')),
    array('data' => t('Teacher')),
  );
  foreach ($group_info as $subject_id => $teachers_id) {
    $subject_name = db_select_field("`subjects`", "`name`", "`id` = '$subject_id'");
    $teachers_name = array();
    foreach($teachers_id as $teacher_id) {
      $teachers_name[] = db_select_field("`users`", "`name`", "`id` = '$teacher_id'");
    }
    $table['rows'][] = array(
      array('data' => l($subject_name, "gradebook/$group_id/$subject_id")),
      array('data' => implode(', ', $teachers_name)),
    );
  }
  return table($table);
}

?>