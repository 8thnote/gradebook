<?php

function base_path() {
  return rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
}

function base_url() {
  $is_https  = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on';
  $protocol  = $is_https ? 'https' : 'http';
  $base_host = $_SERVER['HTTP_HOST'];
  return $protocol . '://' . $_SERVER['HTTP_HOST'] . BASE_PATH;
}

function get_path() {
  return !empty($_GET['q']) ? $_GET['q'] : 'frontpage';
}

function url($path) {
  $parse_path = parse_url($path);
  return empty($parse_path['scheme']) ? BASE_PATH . '/' . $path : $path;
}

function render_template($template_file, $vars = array()) {
  extract($vars, EXTR_SKIP);
  ob_start();
  include "template/templates/$template_file.tpl.php";
  return ob_get_clean();
}

function pages_info() {
  $pages_dir_path = ROOT_DIR . '/pages';
  $pages_dir_arr  = scandir($pages_dir_path);
  $pages_info_arr = array();
  foreach ($pages_dir_arr as $file_name) {
    $file_name_arr = explode('.', $file_name);
    if (!empty($file_name_arr[0]) && !empty($file_name_arr[1]) && !empty($file_name_arr[2])) {
      if ($file_name_arr[1] === 'page' && $file_name_arr[2] === 'php') {
        include $pages_dir_path . '/' . $file_name;
        $page_key      = $file_name_arr[0];
        $page_function = $page_key . '_page_info';
        if (function_exists ($page_function)) {
          $page_info_arr             = $page_function();
          $pages_info_arr[$page_key] = $page_info_arr;
        }
      }
    }
  }
  return $pages_info_arr;
}

function get_page() {
  $pages_info = pages_info();
  $path       = get_path();
  $page       = array();
  foreach ($pages_info as $page_info) {
    $path_args = explode('/', $path);
    $page_args = explode('/', $page_info['path']);
    if (count($path_args) === count($page_args)) {
      $compare = array_diff($page_args, $path_args);
      if (empty($compare)) {
        $page = $page_info;
      }
      else {
        $args  = array();
        $other = 0;
        foreach ($compare as $key => $arg) {
          if ($arg === '%') {
            $args[] = $path_args[$key];
          }
          else {
            $other ++;
          }
        }
        if (empty($other) && !empty($args)) {
          $page = $page_info;
          $page['args'] = $args;
        }
      }
    }
  }
  return !empty($page) ? $page : $pages_info['page_not_found'];
}

function execute() {
  $vars = array(
    'menu'       => get_menu(),
    'message'    => get_message(),
    'copyright'  => get_copyright(),
    'breadcrumb' => FALSE,
  );
  foreach (get_page() as $element => $function) {
    if (function_exists ($function)) {
      $vars[$element] = $function();
    }
  }
  print render_template('html', $vars);
}

function clear($text) {
  $text = stripslashes($text);
  $text = htmlspecialchars($text);
  return $text;
}

function alert($message, $type = 'status') {
  $GLOBALS['message'][$type][] = $message;
}

function get_message() {
  $output = array();
  foreach ($GLOBALS['message'] as $type => $messages) {
    foreach ($messages as $message) {
      $output[] = tag('p', $message, array('class' => $type));
    }
  }
  return implode('', $output);
}

?>