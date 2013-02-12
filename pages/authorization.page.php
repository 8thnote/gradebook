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
  $form_id = empty($_SESSION['user']) ? 'authorization_login_form' : 'authorization_logout_form';
  return form($form_id);
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

function authorization_logout_form() {
  $form = array();
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