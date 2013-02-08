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

function item_list($items, $type = 'ul') {
  $output = '<' . $type . '>';
  foreach ($items as $item) {
    $output .= '<li>' . $item . '</li>';
  }
  $output .= '</' . $type . '>';
  return $output;
}

?>