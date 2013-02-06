<?php

function globals_init() {
  $GLOBALS['page'] = array(
    'title'      => 'title',
    'header'     => 'header',
    'breadcrumb' => 'breadcrumb',
    'content'    => 'content',
    'footer'     => 'footer',
  );
}

function process() {
}

function get_tpl($tpl) {
  global $page;
  ob_start();
  require_once("template/templates/$tpl.tpl.php");
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}

function render() {
  print get_tpl('html');
}

function get_page($path) {
  global $settings;
  $arg = explode('/', $path);
  $path = empty($arg[0]) ? $settings['homepage'] : $arg[0];
  if (empty($arg[0])) {
    $path = $settings['homepage'];
  }
  elseif (!db_select_row("`pages`", "*", "`path` = '$path'")) {
    $path = $settings['error_404_page'];
  }
  else {
    $path = $arg[0];
  }
  $page = db_select_row("`pages`", "*", "`path` = '$path'");
  $page['arg'] = $arg;
  return $page;
}

?>