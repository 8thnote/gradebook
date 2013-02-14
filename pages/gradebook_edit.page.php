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
  return user_role('admin') || user_role('teacher');
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
  $records  = db_select_array("`records`", "*", "`group_id` = '$group_id' AND `subject_id` = '$subject_id'", "`date`");
  $students = db_select_array("`students`", "*", "`group_id` = '$group_id'");
  
  $table = array(
    'caption'    => $subject_name . ' | ' . $group_name,
    'attributes' => array('class' => array('gradebook', 'gradebook-edit')),
  );

  $table['header']['students'] = array('data' => t('Students'));
  foreach ($students as $student) {
    $table['rows'][$student['id']]['title'] = array(
      'data'       => $student['name'],
      'attributes' => array('class' => 'title'),
    );
  }
  
  foreach ($records as $record) {
    $record_options = '';
    foreach ($record_types as $record_type) {
      $attributes = ($record_type['id'] == $record['type_id'])  ? array('value' => $record_type['id'], 'selected' => 'selected') : array('value' => $record_type['id']);
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
  
  return table($table) . form('gradebook_edit_form', array('subject_id' => $subject_id, 'group_id' => $group_id));
}

function gradebook_edit_form($vars) {
  $form = array();
  $form['subject_id'] = array(
    'type'  => 'hidden',
    'value' => $vars['subject_id'],
  );
  $form['group_id'] = array(
    'type'  => 'hidden',
    'value' => $vars['group_id'],
  );
  $form['submit'] = array(
    'type'  => 'submit',
    'value' => t('Save'),
  );
  return $form;
}

function gradebook_edit_form_submit($values) {

  $author_id  = 1; //Ne zavtukatu
  $group_id   = $values['group_id'];
  $subject_id = $values['subject_id'];
  
  $results = array();
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
        $marks[$record_id][$student_id] = clear($value);
        break;
    }
  }
  
  foreach ($records as $record_id => $record_values) {
    $results[] = db_update("`records`", "`date` = '{$record_values['date']}', `type_id` = '{$record_values['type']}'", "`id` = '$record_id'");
  }
  
  foreach ($marks as $record_id => $students) {
    foreach ($students as $student_id => $mark_value) {
      $exist_mark = db_select_row("`marks`", "*", "`record_id` = '$record_id' AND `student_id` = '$student_id'");
      if (($mark_value !== '') && !empty($exist_mark)) {
        $results[] = db_update("`marks`", "`value` = '$mark_value', `author_id` = '$author_id'", "`record_id` = '$record_id' AND `student_id` = '$student_id' AND `subject_id` = '$subject_id'");
      }
      elseif (($mark_value !== '') && empty($exist_mark)) {
        $results[] = db_insert("`marks`", "value, record_id, student_id, subject_id, author_id", "'$mark_value', '$record_id', '$student_id', '$subject_id', '$author_id'");
      }
      elseif (($mark_value === '') && !empty($exist_mark)) {
        $results[] = db_delete("`marks`", "`record_id` = '$record_id' AND `student_id` = '$student_id' AND `subject_id` = '$subject_id'");
      }
    }
  }
  
  if (in_array(TRUE, $results) && !in_array(FALSE, $results)) {
    alert(t('Gradebook saved.'));
    return "gradebook/$group_id/$subject_id";
  }
  else {
    alert(t('Saving filed.'), 'error');
    return FALSE;
  }
}

?>