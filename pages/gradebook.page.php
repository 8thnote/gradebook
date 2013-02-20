<?php

function gradebook_page_info() {
  return array(
    'path'       => 'gradebook/%/%',
    'title'      => 'gradebook_page_title',
    'breadcrumb' => 'gradebook_page_breadcrumb',
    'content'    => 'gradebook_page_content',
    'access'     => 'gradebook_page_access',
  );
}

function gradebook_page_access() {
  return TRUE;
}

function gradebook_page_title($args) {
  $group_id   = $args[1];
  $subject_id = $args[2];
  $group_name   = db_select_field("`groups`", "`name`", "`id` = '$group_id'");
  $subject_name = db_select_field("`subjects`", "`name`", "`id` = '$subject_id'");
  return $subject_name . ' | ' . $group_name;
}

function gradebook_page_breadcrumb($args) {
  $group_id     = $args[1];
  $group_name   = db_select_field("`groups`", "`name`", "`id` = '$group_id'");
  $subject_id   = $args[2];
  $subject_name = db_select_field("`subjects`", "`name`", "`id` = '$subject_id'");
  $faculty_id   = db_select_field("`groups`", "`faculty_id`", "`id` = '$group_id'");
  $faculty_name = db_select_field("`faculties`", "`name`", "`id` = '$faculty_id'");
  $crumbs       = array(
    l($faculty_name, 'groups/' . $faculty_id),
    l($group_name, 'subjects/' . $group_id),
    $subject_name,
  );
  return item_list($crumbs);
}

function gradebook_page_content($args) {
  $group_id   = $args[1];
  $subject_id = $args[2];
  
  $group_name   = db_select_field("`groups`", "`name`", "`id` = '$group_id'");
  $subject_name = db_select_field("`subjects`", "`name`", "`id` = '$subject_id'");
  $records  = db_select_array("`records`", "*", "`group_id` = '$group_id' AND `subject_id` = '$subject_id'", "`date`");
  $students = db_select_array("`students`", "*", "`group_id` = '$group_id'");
  
  $table = array(
    'caption'    => $subject_name . ' | ' . $group_name,
    'attributes' => array('class' => array('gradebook', 'gradebook-view')),
  );
  
  $table['header']['students'] = array(
    'data'       => t('Students'),
    'attributes' => array('class' => 'title'),
  );
  foreach ($students as $student) {
    $table['rows'][$student['id']]['title'] = array(
      'data'       => $student['name'],
      'attributes' => array('class' => 'title'),
    );
  }
  
  foreach ($records as $record) {
    $record_name = db_select_field("`record_types`", "`name`", "`id` = '{$record['type_id']}'");
    $table['header'][$record['id']] = array('data' => t($record_name) . '<hr>' . date('d.m.Y' ,strtotime($record['date'])));
    foreach ($students as $student) {
      $mark = db_select_row("`marks`", "*", "`student_id` = '{$student['id']}' AND `subject_id` = '$subject_id' AND `record_id` = '{$record['id']}'");
      $table['rows'][$student['id']][$record['id']] = array('data' => $mark['value']);
    }
  }

  $table['header']['current_sum'] = array('data' => t('Current Sum'));
  $table['header']['modular_sum'] = array('data' => t('Modular Sum'));
  $table['header']['total_sum']   = array('data' => t('Total Sum'));
  $table['header']['absence_sum'] = array('data' => t('Absence Num'));
  foreach ($students as $student) {
    $marks = db_select_array("`marks`", "*", "`student_id` = '{$student['id']}' AND `subject_id` = '$subject_id'");
    $current_sum = 0;
    $modular_sum = 0;
    $absence_num = 0;
    foreach ($marks as $mark) {
      if (is_numeric($mark['value'])) {
        $value = $mark['value'];
      }
      else {
        $value = 0;
        $absence_num ++;
      }
      $value = is_numeric($mark['value']) ? $mark['value'] : 0;
      $record_type = db_select_field("`records`", "`type_id`", "`id` = '{$mark['record_id']}'");
      if ($record_type == 4) {
        $modular_sum += $value;
      }
      else {
        $current_sum += $value;
      }
    }
    $table['rows'][$student['id']]['current_sum'] = array('data' => $current_sum);
    $table['rows'][$student['id']]['modular_sum'] = array('data' => $modular_sum);
    $table['rows'][$student['id']]['total_sum']   = array('data' => ($current_sum + $modular_sum));
    $table['rows'][$student['id']]['absence_sum'] = array('data' => $absence_num);
  }
  
  if (gradebook_edit_page_access($args)) {
    $actions = array(
      l(t('Edit'), "gradebook/$group_id/$subject_id/edit", array('class' => array('button'))),
      l(t('Add'), "gradebook/$group_id/$subject_id/add", array('class' => array('button'))),
    );
    return table($table) . item_list($actions, array('class' => array('gradebook-actions')));
  }
  else {
    return table($table);
  }
}

?>