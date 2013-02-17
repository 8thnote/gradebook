<?php

function edit_page_info() {
  return array(
    'path'    => '%/%/edit',
    'title'   => 'edit_page_title',
    'content' => 'edit_page_content',
    'access'  => 'edit_page_access',
  );
}

function edit_page_access() {
  return user_role('admin');
}

function edit_page_title($args) {
  return t('Editing of ' . $args[0]);
}

function edit_page_content($args) {
  return form('edit_form', array('type' => $args[0], 'id' => $args[1]));
}

function edit_form($vars) {

  $form = array();
  switch ($vars['type']) {
    case 'faculty':
      $faculty_name = db_select_field("`faculties`", "`name`", "`id` = '{$vars['id']}'");
      $form['faculty_name'] = array(
        'type'     => 'textfield',
        'title'    => t('Faculty name'),
        'value'    => $faculty_name,
        'required' => TRUE,
      );
      break;
  }

  $form['type'] = array(
    'type'  => 'hidden',
    'value' =>  $vars['type'],
  );
  $form['id'] = array(
    'type'  => 'hidden',
    'value' =>  $vars['id'],
  );
  $form['cancel'] = array(
    'type'   => 'item',
    'markup' => l(t('Cancel'), $_SERVER['HTTP_REFERER'], array('class' => array('button'))),
  );
  $form['submit'] = array(
    'type'  => 'submit',
    'value' => t('Save'),
  );
  
  return $form;
}

function edit_form_submit($values) {
  $redirect = TRUE;
  
  switch ($values['type']) {
    case 'faculty':
      $result   = db_update("`faculties`", "`name` = '{$values['faculty_name']}'", "`id` = '{$values['id']}'");
      $redirect = 'faculties';
      break;
  }
  
  if ($result) {
    alert(t('Saved.'));
    return $redirect;
  }
  else {
    alert(t('Saving failed.'), 'error');
    return FALSE;
  }
}

?>