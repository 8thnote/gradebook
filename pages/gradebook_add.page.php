<?php

function gradebook_add_page_info() {
  return array(
    'path'    => 'gradebook/%/%/add',
    'title'   => 'gradebook_add_page_title',
    'content' => 'gradebook_add_page_content',
    'access'  => 'gradebook_add_page_access',
  );
}

function gradebook_add_page_access() {
  return user_role('admin') || user_role('teacher');
}

function gradebook_add_page_title($args) {
  $group_id   = $args[1];
  $subject_id = $args[2];
  $group_name   = db_select_field("`groups`", "`name`", "`id` = '$group_id'");
  $subject_name = db_select_field("`subjects`", "`name`", "`id` = '$subject_id'");
  return $subject_name . ' | ' . $group_name;
}

function gradebook_add_page_content($args) {
  $group_id   = $args[1];
  $subject_id = $args[2];
  return form('gradebook_add_form', array('subject_id' => $subject_id, 'group_id' => $group_id));
}

function gradebook_add_form($vars) {
  $form = array();
  $record_types   = db_select_array("`record_types`", "*");
  $record_options = array();
  foreach ($record_types as $record_type) {
    $record_options[$record_type['id']] = $record_type['name'];
  }
  $form['record_type'] = array(
    'type'    => 'select',
    'title'   => t('Select record type'),
    'options' => $record_options,
  );
  $form['record_date'] = array(
    'type'  => 'date',
    'title' => t('Select record date'),
    'value' => date('Y-m-d'),
  );
  $form['group_id'] = array(
    'type'  => 'hidden',
    'value' => $vars['group_id'],
  );
  $form['subject_id'] = array(
    'type'  => 'hidden',
    'value' => $vars['subject_id'],
  );
  $form['submit'] = array(
    'type'  => 'submit',
    'value' => t('Save'),
  );
  return $form;
}

function gradebook_add_form_submit($values) {
  $results = db_insert("`records`", "type_id, date, group_id , subject_id", "'{$values['record_type']}', '{$values['record_date']}', '{$values['group_id']}', '{$values['subject_id']}'");
  if ($results) {
    alert(t('Record added.'));
    return "gradebook/{$values['group_id']}/{$values['subject_id']}/edit";
  }
  else {
    alert(t('Adding filed.'), 'error');
    return FALSE;
  }
}

?>