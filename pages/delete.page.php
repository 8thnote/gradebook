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
  return form('delete_form', array('node_type' => $args[0], 'node_id' => $args[1]));
}

function delete_form($vars) {
  $form = array();
  $form['confirm'] = array(
    'type'  => 'markup',
    'value' => t('Are you confirm delete?'),
  );
  $form['cancel'] = array(
    'type'  => 'markup',
    'value' => l(t('Cancel'), $_SERVER['HTTP_REFERER'], array('class' => array('button'))),
  );
  $form['submit'] = array(
    'type'  => 'submit',
    'value' => t('Confirm'),
  );
  return $form;
}
?>