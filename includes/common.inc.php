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
  return !empty($_GET['q']) ? rtrim($_GET['q'], '\/') : 'frontpage';
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
  $path_args  = explode('/', get_path());
  $page       = array();
  foreach ($pages_info as $page_info) {
    $page_args = explode('/', $page_info['path']);
    if (count($path_args) === count($page_args)) {
      $compare = array_diff($page_args, $path_args);
      if (empty($compare)) {
        $page = $page_info;
      }
      else {
        $miss = 0;
        foreach ($compare as $key => $arg) {
          if ($arg !== '%') {
            $miss ++;
          }
        }
        if ($miss === 0) {
          $page = $page_info;
        }
      }
    }
  }
  if (!empty($page)) {
    $page_access_function = $page['access'];
    if ($page_access_function($path_args)) {
      $page['args'] = $path_args;
      return $page;
    }
    else {
      exit('access_denied');
    }
  }
  else {
    exit('page_not_found');
  }
}

function execute() {
  $page = get_page();
  $vars = array(
    'header'    => get_header(),
    'menu'      => get_menu(),
    'message'   => get_message(),
    'copyright' => get_copyright(),
  );
  $elements = array('title', 'breadcrumb', 'content');
  foreach ($elements as $element) {
    if (isset($page[$element])) {
      $function       = $page[$element];
      $vars[$element] = $function($page['args']);
    }
    else {
      $vars[$element] = FALSE;
    }
  }
  print render_template('html', $vars);
}

function clear($text) {
  $text = trim($text);
  $text = stripslashes($text);
  $text = htmlspecialchars($text);
  return $text;
}

function t($text) {
  $translation = db_select_field("`locale`", "`ua`", "`default` = '$text'");
  return !empty($translation) ? $translation : $text;
}

function alert($message, $type = 'status') {
  $_SESSION['message'][$type][] = $message;
}

function user_role($role) {
  return !empty($_SESSION['user']) && $_SESSION['user']['role'] === $role;
}

function get_message() {
  $output = array();
  if (!empty($_SESSION['message'])) {
    foreach ($_SESSION['message'] as $type => $messages) {
      foreach ($messages as $message) {
        $output[] = tag('p', $message, array('class' => $type));
      }
    }
    $_SESSION['message'] = array();
  }
  return implode('', $output);
}

?>