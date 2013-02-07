<?php

function base_url() {
  $is_https  = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on';
  $protocol  = $is_https ? 'https' : 'http';
  $base_host = $_SERVER['HTTP_HOST'];
  $base_path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
  return $protocol . '://' . $_SERVER['HTTP_HOST'] . $base_path;
}

function render_template($template_file, $vars) {
  extract($vars, EXTR_SKIP);
  ob_start();
  include "template/templates/$template_file.tpl.php";
  return ob_get_clean();
}


function execute() {
  print('<h1>RomiOS*s DEBUG</h1><pre>' . print_r(scandir(ROOT_DIR . '/pages'),TRUE) . '</pre>');
  $vars = array(
    'title'      => 'title',
    'header'     => 'header',
    'breadcrumb' => 'breadcrumb',
    'content'    => 'content',
    'footer'     => 'footer',
  );
  print render_template('html', $vars);
}


function get_page_callbak() {
  if (!empty($_GET['q'])) {
    
  }
  else {
    $page = 'frontpage';
  }
  $path = $_GET['q'];
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