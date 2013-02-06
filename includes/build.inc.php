<?php

function link($url, $value, $class = array()) {
}

function url($url, $text, $title = NULL) {
  $title = empty($title) ? $text : $title;
  return '<a class = "button" href="/' . $url . '" title="' . $title . '">' . $text . '</a>';
}

function alert($message, $time = 1, $url = NULL) {
  print '
  <div id="alert">' . $message . '</div>
  <meta http-equiv="refresh" content="' . $time . '; url=' . $url . '">';
}

function clear($text) {
  $text = stripslashes($text);
  $text = htmlspecialchars($text);
  return $text;
}

?>