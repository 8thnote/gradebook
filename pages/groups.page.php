<?php

function groups_page_info() {
  return array(
    'path'       => 'groups/%',
    'title'      => 'groups_page_title',
    'breadcrumb' => 'groups_page_breadcrumb',
    'content'    => 'groups_page_content',
    'access'     => 'groups_page_access',
  );
}

function groups_page_access() {
  return TRUE;
}

function groups_page_title($args) {
  $faculty_id = $args[1];
  return is_numeric($faculty_id) ? db_select_field("`faculties`", "`name`", "`id` = '$faculty_id'") : t('All groups');
}

function groups_page_breadcrumb($args) {
  $faculty_id = $args[1];
  if (is_numeric($faculty_id)) {
    $crumbs = array(
      0 => db_select_field("`faculties`", "`name`", "`id` = '$faculty_id'"),
    );
    return item_list($crumbs);
  }
}

function groups_page_content($args) {
  $faculty_id = $args[1];
  $faculty    = is_numeric($faculty_id) ? db_select_field("`faculties`", "`name`", "`id` = '$faculty_id'") : t('All groups');
  $groups     = is_numeric($faculty_id) ? db_select_array("`groups`", "*", "`faculty_id` = '$faculty_id'") : db_select_array("`groups`", "*");
  
  $table = array(
    'caption'    => $faculty,
    'attributes' => array('class' => array('groups-view')),
  );
  
  $table['header'] = array(
    'title'   => array('data' => t('Group name')),
    'options' => array('data' => t('Options')),
  );
  
  foreach ($groups as $group) {
    $table['rows'][$group['id']]['group'] = array(
      'data' => $group['name'],
    );
    $options = array(
      l(t('Subjects'), 'subjects/' . $group['id']),
      l(t('Students'), 'students/' . $group['id']),
    );
    $table['rows'][$group['id']]['options'] = array(
      'data' => item_list($options, array('class' => array('options'))),
    );
  }
  
  if (user_role('admin')) {
    $table['header']['actions'] = array('data' => t('Actions'));
    foreach ($groups as $group) {
      $actions = array(
        l(t('Edit'), "group/{$group['id']}/edit", array('class' => array('button'))),
        l(t('Delete'), "group/{$group['id']}/delete", array('class' => array('button'))),
      );
      $table['rows'][$group['id']]['actions'] = array(
        'data'       => item_list($actions, array('class' => array('actions'))),
        'attributes' => array('class' => 'actions'),
      );
    }
  }
  
  return table($table);
}

?>