<?php

function get_attributes($attributes) {
  foreach ($attributes as $attribute => &$data) {
    $data = implode(' ', (array) $data);
    $data = $attribute . '="' . $data . '"';
  }
  return $attributes ? ' ' . implode(' ', $attributes) : '';
}

function l($text, $path, $attributes = array()) {
  if (empty($path)) {
    $path = 'frontpage';
  }
  if ($path == get_path()) {
    $attributes['class'][] = 'active';
  }
  return '<a href="' . $path . '"' . get_attributes($attributes) . '>' . $text . '</a>';
}

function item_list($items, $type = 'ul') {
  $output = '<' . $type . '>';
  foreach ($items as $item) {
    $output .= '<li>' . $item . '</li>';
  }
  $output .= '</' . $type . '>';
  return $output;
}

?>