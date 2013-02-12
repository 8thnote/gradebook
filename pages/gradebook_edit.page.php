<?php

function gradebook_edit_page_info() {
  return array(
    'path'    => 'gradebook/%/%/edit',
    'title'   => 'gradebook_edit_page_title',
    'content' => 'gradebook_edit_page_content',
    'access'  => 'gradebook_edit_page_access',
  );
}

function gradebook_edit_page_access() {
  return TRUE;
}

function gradebook_edit_page_title($args) {
  $group_id   = $args[1];
  $subject_id = $args[2];
  $group_name   = db_select_field("`groups`", "`name`", "`id` = '$group_id'");
  $subject_name = db_select_field("`subjects`", "`name`", "`id` = '$subject_id'");
  return $subject_name . ' | ' . $group_name;
}

function gradebook_edit_page_content($args) {
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
    $table['header'][$record['id']] = form('gradebook_edit_form', array('type' => 'record', 'record' => $record));
    foreach ($students as $student) {
      $mark = db_select_row("`marks`", "*", "`student_id` = '{$student['id']}' AND `subject_id` = '$subject_id' AND `record_id` = '{$record['id']}'");
      $table['rows'][$student['id']][$record['id']] = array(
        'data' => form('gradebook_edit_form', array('type' => 'mark', 'mark' => $mark)),
      );
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
  
  return table($table);
}

function gradebook_edit_form($vars) {
  $form = array();
  switch ($vars['type']) {
    case 'mark':
      $form['mark_' . $vars['mark']['id']] = array(
        'type'  => 'textfield',
        'value' => $vars['mark']['value'],
      );
      break;
    
    case 'record':
      $record_types   = db_select_array("`record_types`", "*");
      $record_options = array();
      foreach ($record_types as $record_type) {
        $record_options[$record_type['id']] = $record_type['name'];
      }
      $form['record_type_' . $vars['record']['id']] = array(
        'type'    => 'select',
        'options' => $record_options,
        'value'   => $vars['record']['type_id'],
      );
      $form['record_date_' . $vars['record']['id']] = array(
        'type'    => 'textfield',
        'value'   => $vars['record']['date'],
      );
      break;
    
  }
  return $form;
}

?>