<?php

function edit_page_info() {
  return array(
    'path'    => '%/%/edit',
    'title'   => 'edit_page_title',
    'content' => 'edit_page_content',
    'access'  => 'edit_page_access',
  );
}

function edit_page_access() {
  return user_role('admin');
}

function edit_page_title($args) {
  return t('Content editing');
}

function edit_page_content($args) {
  return form('edit_form', array('type' => $args[0], 'id' => $args[1]));
}

function edit_form($vars) {
  $form = array();
  
  switch ($vars['type']) {
    
    case 'faculty':
      $faculty_name = db_select_field("`faculties`", "`name`", "`id` = '{$vars['id']}'");
      $form['faculty_name'] = array(
        'type'     => 'textfield',
        'title'    => t('Faculty name'),
        'value'    => $faculty_name,
        'required' => TRUE,
      );
      break;
    
    case 'group':
      $group_name = db_select_field("`groups`", "`name`", "`id` = '{$vars['id']}'");
      $form['group_name'] = array(
        'type'     => 'textfield',
        'title'    => t('Group name'),
        'value'    => $group_name,
        'required' => TRUE,
      );
      $faculties = db_select_array("`faculties`", "*");
      $options   = array();
      foreach ($faculties as $faculty) {
        $options[$faculty['id']] = $faculty['name'];
      }
      $faculty_id = db_select_field("`groups`", "`faculty_id`", "`id` = '{$vars['id']}'");
      $form['faculty_id'] = array(
        'type'    => 'select',
        'title'   => t('Faculty'),
        'options' => $options,
        'value'   => $faculty_id,
      );
      $group_info_string = db_select_field("`groups`", "`info`", "`id` = '{$vars['id']}'");
      $group_info_array  = unserialize($group_info_string);
      $subjects = db_select_array("`subjects`", "*", '1', 'name');
      $teachers = db_select_array("`users`", "*", "`role` = 'teacher'");
      foreach ($subjects as $subject) {
        $teachers_block_id  = 'subject-' . $subject['id'] . '-teachers';
        $teachers_block_vis = array_key_exists($subject['id'] ,$group_info_array) ? 'block' : 'none';
        $form['subject_' . $subject['id']] = array(
          'type'    => 'checkbox',
          'markup'  => $subject['name'],
          'checked' => array_key_exists($subject['id'] ,$group_info_array),
          'onclick' => "document.getElementById('$teachers_block_id').style.display = (this.checked) ? 'block' : 'none';",
        );
        $form['teacher_' . $subject['id'] . '_markup'] = array(
          'type'    => 'item',
          'markup'  => '<div class="teachers" id="' . $teachers_block_id . '" style="display: ' . $teachers_block_vis . ';">',
          'nocover' => TRUE,
        );
        foreach ($teachers as $teacher) {
          $form['teacher_' . $subject['id'] . '_' . $teacher['id']] = array(
            'type'    => 'checkbox',
            'markup'  => $teacher['name'],
            'checked' => !empty($group_info_array[$subject['id']]) && in_array($teacher['id'], $group_info_array[$subject['id']]),
          );
        }
        $form['teacher_' . $subject['id'] . '_end_markup'] = array(
          'type'    => 'item',
          'markup'  => '</div>',
          'nocover' => TRUE,
        );
      }
      break;
    
    case 'subject':
      $subject = db_select_row("`subjects`", "*", "`id` = '{$vars['id']}'");
      $form['subject_name'] = array(
        'type'     => 'textfield',
        'title'    => t('Subject name'),
        'value'    => $subject['name'],
        'required' => TRUE,
      );
      break;
    
    case 'student':
      $student = db_select_row("`students`", "*", "`id` = '{$vars['id']}'");
      $form['student_name'] = array(
        'type'     => 'textfield',
        'title'    => t('Student name'),
        'value'    => $student['name'],
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
        'value'   => $student['group_id'],
      );
      break;
    
    case 'teacher':
      $teachers = db_select_row("`users`", "*", "`id` = '{$vars['id']}'");
      $form['teacher_name'] = array(
        'type'     => 'textfield',
        'title'    => t('Teacher name'),
        'value'    => $teachers['name'],
        'required' => TRUE,
      );
      $form['teacher_pass'] = array(
        'type'     => 'textfield',
        'title'    => t('Password'),
        'value'    => $teachers['pass'],
        'required' => TRUE,
      );
      break;
    
  }

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
    'value' => t('Save'),
  );
  
  return $form;
}

function edit_form_submit($values) {
  $redirect = TRUE;
  
  switch ($values['type']) {
    
    case 'faculty':
      $result   = db_update("`faculties`", "`name` = '{$values['faculty_name']}'", "`id` = '{$values['id']}'");
      $redirect = 'faculties';
      break;
    
    case 'group':
      $subjects = array();
      $teachers = array();
      foreach ($values as $key => $value) {
        $key_parse = explode('_', $key);
        switch ($key_parse[0]) {
          case 'subject':
            $subjects[] = $key_parse[1];
            break;
          
          case 'teacher':
            $teachers[$key_parse[1]][] = $key_parse[2];
            break;
        }
      }
      $group_info_array = array();
      foreach ($subjects as $subject_id) {
        if (!empty($teachers[$subject_id])) {
          $group_info_array[$subject_id] = $teachers[$subject_id];
        }
      }
      $group_info_string = serialize($group_info_array);
      $result = db_update("`groups`",
        "`name` = '{$values['group_name']}', `faculty_id` = '{$values['faculty_id']}', `info` = '$group_info_string'",
        "`id` = '{$values['id']}'");
      $redirect = 'groups/' . $values['faculty_id'];
      break;
    
    case 'subject':
      $result   = db_update("`subjects`", "`name` = '{$values['subject_name']}'", "`id` = '{$values['id']}'");
      $redirect = 'subjects/all';
      break;
    
    case 'student':
      $result   = db_update("`students`",
        "`name` = '{$values['student_name']}', `group_id` = '{$values['group_id']}'",
        "`id` = '{$values['id']}'");
      $redirect = 'students/' . $values['group_id'];
      break;
    
    case 'teacher':
      $result   = db_update("`users`",
        "`name` = '{$values['teacher_name']}', `pass` = '{$values['teacher_pass']}'",
        "`id` = '{$values['id']}'");
      $redirect = 'teachers';
      break;
    
  }
  
  if ($result) {
    alert(t('Saved.'));
    return $redirect;
  }
  else {
    alert(t('Saving failed.'), 'error');
    return FALSE;
  }
}

?>