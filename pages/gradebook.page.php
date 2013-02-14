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
  $records  = db_select_array("`records`", "*", "`group_id` = '$group_id' AND `subject_id` = '$subject_id'", "`date`");
  $students = db_select_array("`students`", "*", "`group_id` = '$group_id'");
  
  $table = array(
    'caption'    => $subject_name . ' | ' . $group_name,
    'attributes' => array('class' => 'gradebook'),
  );
  
  $table['header']['students'] = array('data' => t('Students'));
  foreach ($students as $student) {
    $table['rows'][$student['id']]['title'] = array('data' => $student['name']);
  }
  foreach ($records as $record) {
    $record_name = db_select_field("`record_types`", "`name`", "`id` = '{$record['type_id']}'");
    $table['header'][$record['id']] = array('data' => t($record_name) . '<hr>' . $record['date']);
    foreach ($students as $student) {
      $mark = db_select_row("`marks`", "*", "`student_id` = '{$student['id']}' AND `subject_id` = '$subject_id' AND `record_id` = '{$record['id']}'");
      $table['rows'][$student['id']][$record['id']] = array('data' => $mark['value']);
    }
  }

  $table['header']['current_sum'] = array('data' => t('Current Sum'));
  $table['header']['modular_sum'] = array('data' => t('Modular Sum'));
  $table['header']['total_sum']   = array('data' => t('Total Sum'));
  foreach ($students as $student) {
    $marks = db_select_array("`marks`", "*", "`student_id` = '{$student['id']}' AND `subject_id` = '$subject_id'");
    $current_sum = 0;
    $modular_sum = 0;
    foreach ($marks as $mark) {
      $value = is_numeric($mark['value']) ? $mark['value'] : 0;
      $record_type = db_select_field("`records`", "`type_id`", "`id` = '{$mark['record_id']}'");
      if ($record_type == 4) {
        $modular_sum += $value;
      }
      else {
        $current_sum += $value;
      }
    }
    $table['rows'][$student['id']]['current_sum'] = array('data' => $current_sum);
    $table['rows'][$student['id']]['modular_sum'] = array('data' => $modular_sum);
    $table['rows'][$student['id']]['total_sum']   = array('data' => ($current_sum + $modular_sum));
  }
    
  return table($table) . tag('div', l(t('Edit'), "gradebook/$group_id/$subject_id/edit"), array('class' => array('gradebook-actions')));
}

?>