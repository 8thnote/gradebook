<?php

function render_template($template_file, $vars) {
  extract($vars, EXTR_SKIP);
  ob_start();
  include "template/templates/$template_file.tpl.php";
  return ob_get_clean();
}


function execute() {
  $vars = array(
    'title'      => 'title',
    'header'     => 'header',
    'breadcrumb' => 'breadcrumb',
    'content'    => 'content',
    'footer'     => 'footer',
  );
  print render_template('html', $vars);
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