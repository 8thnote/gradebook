<?php

function faculty_add_page_info() {
  return array(
    'path'    => 'faculty/add',
    'title'   => 'faculty_add_page_title',
    'content' => 'faculty_add_page_content',
    'access'  => 'faculty_add_page_access',
  );
}

function faculty_add_page_access() {
  return user_role('admin');
}

function faculty_add_page_title() {
  return t('Faculty add');
}

function faculty_add_page_content() {
  return form('faculty_add_form');
}

function faculty_add_form($vars) {
  $form = array();
  $form['faculty_name'] = array(
    'type'     => 'textfield',
    'title'    => t('Faculty name'),
    'required' => TRUE,
  );
  $form['cancel'] = array(
    'type'   => 'item',
    'markup' => l(t('Cancel'), $_SERVER['HTTP_REFERER'], array('class' => array('button'))),
  );
  $form['submit'] = array(
    'type'  => 'submit',
    'value' => t('Add'),
  );
  return $form;
}

function faculty_add_form_submit($values) {
  $result = db_insert("`faculties`", "name", "'{$values['faculty_name']}'");
  if ($result) {
    alert(t('Faculty added.'));
    return 'faculties';
  }
  else {
    alert(t('Adding failed.'), 'error');
    return FALSE;
  }
}

?>