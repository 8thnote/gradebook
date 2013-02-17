<?php

function delete_page_info() {
  return array(
    'path'    => '%/%/delete',
    'title'   => 'delete_page_title',
    'content' => 'delete_page_content',
    'access'  => 'delete_page_access',
  );
}

function delete_page_access() {
  return user_role('admin');
}

function delete_page_title() {
  return t('Delete confirm');
}

function delete_page_content($args) {
  return form('delete_form', array('type' => $args[0], 'id' => $args[1]));
}

function delete_form($vars) {
  $form = array();
  $form['confirm'] = array(
    'type'   => 'item',
    'markup' => t('Are you confirm delete?'),
  );
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
    'value' => t('Delete'),
  );
  return $form;
}

function delete_form_submit($values) {
  $redirect = TRUE;
  
  switch ($values['type']) {
    
    case 'faculty':
      $result   = db_delete("`faculties`", "`id` = '{$values['id']}'");
      $redirect = 'faculties';
      break;
    
    case 'group':
      $results = array();
      $records = db_select_array("`records`", "*", "`group_id` = '{$values['id']}'");
      foreach ($records as $record) {
        $marks = db_select_array("`marks`", "*", "`record_id` = '{$record['id']}'");
        foreach ($marks as $mark) {
          $results[] = db_delete("`marks`", "`id` = '{$mark['id']}'");
        }
        $results[] = db_delete("`records`", "`id` = '{$record['id']}'");
      }
      $results[] = db_delete("`groups`", "`id` = '{$values['id']}'");
      $result    = in_array(TRUE, $results) && !in_array(FALSE, $results);
      $redirect  = 'groups/all';
      break;
    
    case 'student':
      $results = array();
      $marks   = db_select_array("`marks`", "*", "`student_id` = '{$values['id']}'");
      foreach ($marks as $mark) {
        $results[] = db_delete("`marks`", "`id` = '{$mark['id']}'");
      }
      $results[] = db_delete("`students`", "`id` = '{$values['id']}'");
      $result    = in_array(TRUE, $results) && !in_array(FALSE, $results);
      $redirect  = 'students/all';
      break;
    
    case 'teacher':
      $result   = db_delete("`users`", "`id` = '{$values['id']}'");
      $redirect = 'teachers';
      break;
    
  }
  
  if ($result) {
    alert(t('Deleted.'));
    return $redirect;
  }
  else {
    alert(t('Deleting failed.'), 'error');
    return FALSE;
  }
}

?>