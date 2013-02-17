<?php

function authorization_page_info() {
  return array(
    'path'    => 'authorization',
    'title'   => 'authorization_page_title',
    'content' => 'authorization_page_content',
    'access'  => 'authorization_page_access',
  );
}

function authorization_page_access() {
  return TRUE;
}

function authorization_page_title() {
  return t('Authorization');
}

function authorization_page_content() {
  $user_id = !empty($_SESSION['user']) ? $_SESSION['user']['id'] : 0;
  
  $output  = $user_id ? form('authorization_logout_form', array('name' => $_SESSION['user']['name'])) : form('authorization_login_form');
  
  if (user_role('admin')) {
    $nodes = array('faculty', 'group', 'student', 'teacher');
    $items = array();
    foreach ($nodes as $node) {
      $items[] = l(t('Add ' . $node), "$node/add", array('class' => array('button')));
    }
    $output .= item_list($items, array('class' => array('admin-menu')));
  }
  
  if (user_role('teacher')) {
    $groups   = db_select_array('groups', "*");
    $subjects = array();
    foreach ($groups as $group) {
      $group_info = unserialize($group['info']);
      foreach ($group_info as $subject_id => $teachers) {
        if (in_array($user_id, $teachers)) {
          $subjects[$subject_id][] = $group['id'];
        }
      }
    }
    
    foreach ($subjects as $subject_id => $groups_id) {
      $subject_name = db_select_field("`subjects`", "`name`", "`id` = '$subject_id'");
      $groups = array();
      foreach ($groups_id as $group_id) {
        $group_name = db_select_field("`groups`", "`name`", "`id` = '$group_id'");
        $groups[]   =  l($group_name, "gradebook/$group_id/$subject_id");
      }
      $output .= item_list($groups, array('class' => array('my-groups')), $subject_name);
    }
    
  }
  return $output;
}

function authorization_login_form() {
  $form = array();
  $form['name'] = array(
    'type'  => 'textfield',
    'title' => t('Name'),
  );
  $form['pass'] = array(
    'type'  => 'password',
    'title' => t('Password'),
  );
  $form['submit'] = array(
    'type'  => 'submit',
    'value' => t('Submit'),
  );
  return $form;
}

function authorization_login_form_submit($values) {
  $name = clear($values['name']);
  $pass = clear($values['pass']);
  if (empty($name) || empty($pass)) {
    alert(t('Empty fields.'), 'error');
    return FALSE;
  }
  else {
    $user_info = db_select_row("`users`", "*", "`name` = '$name'");
    if ($pass == $user_info['pass']) {
      $_SESSION['user'] = $user_info;
      alert(t('Enter success.'));
      return TRUE;
    }
    else {
      alert(t('Enter filed. Wrong name or password.'), 'error');
      return FALSE;
    }
  }
}

function authorization_logout_form($vars) {
  $form = array();
  $form['name'] = array(
    'type'   => 'item',
    'markup' => t('Hello') . ' ' . tag('strong', $vars['name']) . '!',
  );
  $form['submit'] = array(
    'type'  => 'submit',
    'value' => t('Exit'),
  );
  return $form;
}

function authorization_logout_form_submit($values) {
  $_SESSION['user'] = array();
  alert(t('Exit success.'));
  return TRUE;
}
  
?>