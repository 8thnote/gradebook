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

function add_page_title() {
  return t('Content adding');
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
    
    case 'subject':
      $form['subject_name'] = array(
        'type'     => 'textfield',
        'title'    => t('Subject name'),
        'required' => TRUE,
      );
      break;
    
    case 'student':
      $form['student_name'] = array(
        'type'     => 'textfield',
        'title'    => t('Student name'),
        'required' => TRUE,
      );
      $groups  = db_select_array("`groups`", "*", "1", "name");
      $options = array();
      foreach ($groups as $group) {
        $options[$group['id']] = $group['name'];
      }
      $form['group_id'] = array(
        'type'    => 'select',
        'title'   => t('Group'),
        'options' => $options,
      );
      break;
    
    case 'teacher':
      $form['teacher_name'] = array(
        'type'     => 'textfield',
        'title'    => t('Name'),
        'required' => TRUE,
      );
      $form['teacher_pass'] = array(
        'type'     => 'textfield',
        'title'    => t('Password'),
        'required' => TRUE,
      );
      break;
    
  }
  
  $form['type'] = array(
    'type'  => 'hidden',
    'value' =>  $vars['type'],
  );
  if (!empty($_SERVER['HTTP_REFERER'])) {
    $form['cancel'] = array(
      'type'   => 'item',
      'markup' => l(t('Cancel'), $_SERVER['HTTP_REFERER'], array('class' => array('button'))),
    );
  }
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
      $redirect = 'groups/' . $values['faculty_id'];
      break;
    
    case 'subject':
      $result   = db_insert("`subjects`", "name", "'{$values['subject_name']}'");
      $redirect = 'subjects/all';
      break;
    
    case 'student':
      $result   = db_insert("`students`", "name, group_id", "'{$values['student_name']}', '{$values['group_id']}'");
      $redirect = 'students/' . $values['group_id'];
      break;
    
    case 'teacher':
      $result   = db_insert("`users`", "name, pass, role", "'{$values['teacher_name']}', '{$values['teacher_pass']}', 'teacher'");
      $redirect = 'teachers';
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