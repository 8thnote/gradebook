<?php

function add_page_info() {
  return array(
    'path'    => '%/add',
    'title'   => 'add_page_title',
    'content' => 'add_page_content',
    'access'  => 'add_page_access',
  );
}

function add_page_access() {
  return user_role('admin');
}

function add_page_title($args) {
  return t('Adding of ' . $args[0]);
}

function add_page_content($args) {
  return form('add_form', array('type' => $args[0]));
}

function add_form($vars) {
  $form = array();
  
  switch ($vars['type']) {
    case 'faculty':
      $form['faculty_name'] = array(
        'type'     => 'textfield',
        'title'    => t('Faculty name'),
        'required' => TRUE,
      );
      break;
    
    case 'group':
      $form['group_name'] = array(
        'type'     => 'textfield',
        'title'    => t('Group name'),
        'required' => TRUE,
      );
      $faculties = db_select_array("`faculties`", "*");
      $options   = array();
      foreach ($faculties as $faculty) {
        $options[$faculty['id']] = $faculty['name'];
      }
      $form['faculty_id'] = array(
        'type'    => 'select',
        'title'   => t('Faculty'),
        'options' => $options,
      );
      break;
  }
  
  $form['type'] = array(
    'type'  => 'hidden',
    'value' =>  $vars['type'],
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

function add_form_submit($values) {
  $redirect = TRUE;
  
  switch ($values['type']) {
    case 'faculty':
      $result   = db_insert("`faculties`", "name", "'{$values['faculty_name']}'");
      $redirect = 'faculties';
      break;
    
    case 'group':
      $result   = db_insert("`groups`", "name, faculty_id, info", "'{$values['group_name']}', '{$values['faculty_id']}', 'a:0:{}'");
      $redirect = 'groups/all';
      break;
  }

  if ($result) {
    alert(t('Added.'));
    return $redirect;
  }
  else {
    alert(t('Adding failed.'), 'error');
    return FALSE;
  }
}

?>