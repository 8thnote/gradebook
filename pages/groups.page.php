<?php

function groups_page_info() {
  return array(
    'path'    => 'groups/%',
    'title'   => 'groups_page_title',
    'content' => 'groups_page_content',
    'access'  => 'groups_page_access',
  );
}

function groups_page_access() {
  return TRUE;
}

function groups_page_title($args) {
  $faculty_id = $args[1];
  return db_select_field("`faculties`", "`name`", "`id` = '$faculty_id'");
}

function groups_page_content($args) {
  $faculty_id = $args[1];
  $faculty = db_select_field("`faculties`", "`name`", "`id` = '$faculty_id'");
  $groups = db_select_array("`groups`", "*", "`faculty_id` = '$faculty_id'");
  $table = array();
  $table['attributes'] = array('border' => 1);
  $table['caption'] = $faculty;
  $table['header'] = array(
    array('data' => t('Group name')),
  );
  foreach ($groups as $group) {
    $table['rows'][] = array(
      array('data' => l($group['name'], 'subjects/' . $group['id'])),
    );
  }
  return table($table);
}

?>