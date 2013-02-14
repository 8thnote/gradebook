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

function item_list($items, $attributes = array()) {
  $output = '';
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
      if (isset($_POST[$element_name])) {
        $value = $_POST[$element_name];
      }
      elseif (isset($form_element['value'])) {
        $value = $form_element['value'];
      }
      else {
        $value = '';
      }
      switch ($form_element['type']) {
        case 'hidden':
          $buil_element .= '<input' . tag_attributes(array('name'=> $element_name, 'type' => 'hidden', 'value' => $form_element['value'])) . '>';
          break;
        
        case 'textfield':
          $buil_element .= '<input' . tag_attributes(array('name'=> $element_name, 'type' => 'textfield', 'value' => $value)) . '>';
          break;
        
        case 'date':
          $buil_element .= '<input' . tag_attributes(array('name'=> $element_name, 'type' => 'date', 'value' => $value)) . '>';
          break;
        
        case 'password':
          $buil_element .= '<input' . tag_attributes(array('name'=> $element_name, 'type' => 'password')) . '>';
          break;
        
        case 'submit':
          $buil_element .= '<input' . tag_attributes(array('name'=> $element_name, 'type' => 'submit', 'value' => $form_element['value'])) . '>';
          break;
        
        case 'textarea':
          $buil_element .= tag('textarea', $value, array('name'=> $element_name));
          break;
        
        case 'select':
          $options = '';
          foreach ($form_element['options'] as $option_key => $option_value) {
            $attributes = ($value == $option_key)  ? array('value' => $option_key, 'selected' => 'selected') : array('value' => $option_key);
            $options   .= tag('option', $option_value, $attributes);
          }
          $buil_element .= tag('select', $options, array('name'=> $element_name));
          break;
        
      }
      $output .= tag('div', $buil_element, array('class' => array($element_name)));
    }
  }
  $output = tag('form', $output, array('id' => $form_id, 'method' => 'post', 'action' => url(get_path()), 'accept-charset' => 'UTF-8'));
  if (isset($_POST['form_id']) && ($_POST['form_id'] == $form_id)) {
    $submit_callback = $form_id . '_submit';
    if (function_exists($submit_callback)) {
      $submit_result = $submit_callback($_POST);
      if ($submit_result !== FALSE) {
        $redirect_url = is_bool($submit_result) ? url(get_path()) : url($submit_result);
        header('Location: ' . $redirect_url);
      }
    }
  }
  return $output;
}

?>