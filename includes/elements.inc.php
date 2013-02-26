<?php

function tag_attributes($attributes) {
  foreach ($attributes as $attribute => &$data) {
    $data = implode(' ', (array) $data);
    $data = $attribute . '="' . $data . '"';
  }
  return $attributes ? ' ' . implode(' ', $attributes) : '';
}

function tag($tag, $text, $attributes = array()) {
  return '<' . $tag . tag_attributes($attributes) . '>' . $text . '</' . $tag . '>';
}

function l($text, $path, $attributes = array()) {
  if (empty($path)) {
    $path = 'frontpage';
  }
  if ($path == get_path()) {
    $attributes['class'][] = 'active';
  }
  $attributes['href'] = url($path);
  return tag('a', $text, $attributes);
}

function item_list($items, $attributes = array(), $title = '') {
  $output = !empty($title) ? tag('h3', $title) : '';
  foreach ($items as $item) {
    $output .= tag('li', $item);
  }
  return tag('ul', $output, $attributes);
}

function table($vars) {
  $output = '';
  if (!empty($vars['caption'])) {
    $output .= tag('caption', $vars['caption']);
  }
  if (!empty($vars['header'])) {
    $header_output = '';
    foreach ($vars['header'] as $header_cell) {
      $data       = !empty($header_cell['data']) ? $header_cell['data'] : '';
      $attributes = !empty($header_cell['attributes']) ? $header_cell['attributes'] : array();
      $header_output .= tag('th', $data, $attributes);
    }
    $output .= tag('tr', $header_output);
  }
  if (!empty($vars['rows'])) {
    foreach ($vars['rows'] as $row) {
      $row_output = '';
      foreach ($row as $cell) {
        $data       = isset($cell['data']) ? $cell['data'] : '';
        $attributes = !empty($cell['attributes']) ? $cell['attributes'] : array();
        $row_output .= tag('td', $data, $attributes);
      }
      $output .= tag('tr', $row_output);
    }
  }
  else {
    $row_output = tag('td', t('Empty'), array('colspan' => count($vars['header'])));
    $output    .= tag('tr', $row_output);
  }
  return !empty($vars['attributes']) ? tag('table', $output, $vars['attributes']) : tag('table', $output);
}

function form($form_id, $vars = array()) {
  $output = '<input' . tag_attributes(array('name'=> 'form_id', 'type' => 'hidden', 'value' => $form_id)) . '>';
  $form   = function_exists($form_id) ? $form_id($vars) : array();
  foreach ($form as $element_name => $form_element) {
    if (is_array($form_element) && !empty($form_element['type'])) {
      $buil_element = '';
      
      if (!empty($form_element['title'])) {
        $buil_element .= tag('p', $form_element['title'], array('class' => array('input-lable')));
      }
      
      $attributes = array(
        'id'   => $element_name,
        'name' => $element_name,
        'type' => $form_element['type'],
      );
      
      if (isset($_POST[$element_name])) {
        $attributes['value'] = $_POST[$element_name];
      }
      elseif (isset($form_element['value'])) {
        $attributes['value'] = $form_element['value'];
      }
      
      if (!empty($form_element['class'])) {
        $attributes['class'] = $form_element['class'];
      }
      
      if (!empty($form_element['required'])) {
        $attributes['required'] = 'required';
      }
      
      if (!empty($form_element['checked'])) {
        $attributes['checked'] = 'checked';
      }
      
      if (!empty($form_element['onclick'])) {
        $attributes['onclick'] = $form_element['onclick'];
      }
      
      switch ($form_element['type']) {
        case 'hidden':
        case 'textfield':
        case 'date':
        case 'password':
        case 'submit':
          $buil_element .= '<input' . tag_attributes($attributes) . '>';
          break;
        
        case 'checkbox':
          $buil_element .= '<input' . tag_attributes($attributes) . '>';
          $buil_element .= tag('label', $form_element['markup'], array('for' => $attributes['id']));
          break;
        
        case 'item':
          $buil_element .= $form_element['markup'];
          break;
        
        case 'textarea':
          $value = !empty($attributes['value']) ? $attributes['value'] : '';
          $buil_element .= tag('textarea', $value, array('name'=> $element_name));
          break;
        
        case 'select':
          $options = '';
          $value   = !empty($attributes['value']) ? $attributes['value'] : '';
          foreach ($form_element['options'] as $option_key => $option_value) {
            $attributes = ($value == $option_key)  ? array('value' => $option_key, 'selected' => 'selected') : array('value' => $option_key);
            $options   .= tag('option', $option_value, $attributes);
          }
          $buil_element .= tag('select', $options, array('name' => $element_name));
          break;
        
      }
      $output .= empty($form_element['nocover']) ? tag('div', $buil_element, array('class' => array($element_name))) : $buil_element;
    }
  }
  $output = tag('form', $output, array('id' => $form_id, 'method' => 'post', 'action' => url(get_path()), 'accept-charset' => 'UTF-8'));
  if (isset($_POST['form_id']) && ($_POST['form_id'] == $form_id)) {
    $submit_callback = $form_id . '_submit';
    if (function_exists($submit_callback)) {
      $submit_values = array();
      foreach ($_POST as $key => $value) {
        $submit_values[$key] = mysql_real_escape_string($value);
      }
      $submit_result = $submit_callback($submit_values);
      if ($submit_result !== FALSE) {
        $redirect_url = is_bool($submit_result) ? url(get_path()) : url($submit_result);
        header('Location: ' . $redirect_url);
      }
    }
  }
  return $output;
}

?>