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
  $record_types = db_select_array("`record_types`", "*");
  $records  = db_select_array("`records`", "*", "`group_id` = '$group_id' AND `subject_id` = '$subject_id'");
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
    $record_options = '';
    foreach ($record_types as $record_type) {
      $attributes = ($record_type['id'] == $record['type_id'])  ? array('value' => $record_type['id'], 'selected' => 'selected') : array('value' => $record['type_id']);
      $record_options .= tag('option', $record_type['name'], $attributes);
    }
    $record_type_select = tag('select', $record_options, array('name'=> 'record_type_' . $record['id'], 'form' => 'gradebook_edit_form'));
    $record_date_input  = '<input' . tag_attributes(array(
      'name'      => 'record_date_' . $record['id'],
      'type'      => 'date',
      'value'     => $record['date'],
      'required'  => 'required',
      'size'      => 10,
      'maxlength' => 10,
      'form'      => 'gradebook_edit_form')) . '>';
    $table['header'][$record['id']] = array('data' => $record_type_select . $record_date_input);
    foreach ($students as $student) {
      $mark = db_select_row("`marks`", "*", "`student_id` = '{$student['id']}' AND `subject_id` = '$subject_id' AND `record_id` = '{$record['id']}'");
      $mark_input = '<input' . tag_attributes(array(
        'name'      => 'mark_' . $record['id'] . '_' . $student['id'],
        'type'      => 'textfield',
        'value'     => $mark['value'],
        'size'      => 10,
        'maxlength' => 2,
        'form'      => 'gradebook_edit_form')) . '>';
      $table['rows'][$student['id']][$record['id']] = array('data' => $mark_input);
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
  
  return table($table) . tag('div', form('gradebook_edit_form'), array('class' => array('gradebook-actions')));
}

function gradebook_edit_form() {
  $form = array(); 
  $form['submit'] = array(
    'type'  => 'submit',
    'value' => t('Submit'),
  );
  return $form;
}

function gradebook_edit_form_submit($values) {
  $records = array();
  $marks   = array();
  foreach ($values as $key => $value) {
    $key_parse = explode('_', $key);
    switch ($key_parse[0]) {
      case 'record':
        $record_type = $key_parse[1];
        $record_id   = $key_parse[2];
        $records[$record_id][$record_type] = $value;
        break;
      
      case 'mark':
        $record_id  = $key_parse[1];
        $student_id = $key_parse[2];
        $marks[$record_id][$student_id] = $value;
        break;
    }
  }
  foreach ($records as $record_id => $record_values) {
    db_update("`records`", "`date` = '{$record_values['date']}'", "`id` = '$record_id'");
  }
  foreach ($marks as $record_id => $students) {
    
  }
}

?>