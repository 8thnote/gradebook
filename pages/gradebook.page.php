<?php

function gradebook_page_info() {
  return array(
    'path'    => 'gradebook/%/%',
    'title'   => 'gradebook_page_title',
    'content' => 'gradebook_page_content',
    'access'  => 'gradebook_page_access',
  );
}

function gradebook_page_access() {
  return TRUE;
}

function gradebook_page_title($args) {
  $group_id   = $args[1];
  $subject_id = $args[2];
  $group_name   = db_select_field("`groups`", "`name`", "`id` = '$group_id'");
  $subject_name = db_select_field("`subjects`", "`name`", "`id` = '$subject_id'");
  return $subject_name . ' | ' . $group_name;
}

function gradebook_page_content($args) {
  $group_id   = $args[1];
  $subject_id = $args[2];
  
  $group_name   = db_select_field("`groups`", "`name`", "`id` = '$group_id'");
  $subject_name = db_select_field("`subjects`", "`name`", "`id` = '$subject_id'");
  $records  = db_select_array("`records`", "*", "`group_id` = '$group_id' AND `subject_id` = '$subject_id'");
  $students = db_select_array("`students`", "*", "`group_id` = '$group_id'");
  
  $table = array();
  $table['attributes'] = array('border' => 1);
  $table['caption'] = $subject_name . ' | ' . $group_name;
  
  $table['header']['title'] = array('data' => t('Student name'));
  foreach ($students as $student) {
    $table['rows'][$student['id']]['title'] = array('data' => $student['name']);
  }
  
  foreach ($records as $record) {
    $table['header'][$record['id']] = array('data' => $record['type'] . '<hr>' . $record['date']);
    foreach ($students as $student) {
      $mark = db_select_row("`marks`", "*", "`student_id` = '{$student['id']}' AND `subject_id` = '$subject_id' AND `record_id` = '{$record['id']}'");
      $table['rows'][$student['id']][$record['id']] = array('data' => $mark['value']);
    }
  }
  
  //if (isset($_SESSION['user'])) {
  if (TRUE) {
    $table['rows']['operations'][] = array('data' => 'foo', 'attributes' => array('colspan' => count($table['header'])));
  }
  
  return table($table);
}

?>