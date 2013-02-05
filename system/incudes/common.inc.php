<?php
/*************************************************************************************************/
function db_connect() {
  $settings = parse_ini_file('system/db.ini', TRUE);
  mysql_connect($settings['host'], $settings['user'], $settings['pass']) or die('ERROR_CONNECT_TO_MYSQL');
  mysql_select_db($settings['name']) or die('ERROR_SELECT_DB');
  return TRUE;
}
/*************************************************************************************************/
function db_select_array($db_table, $db_field, $db_condition) {
  $sql = "SELECT $db_field FROM $db_table WHERE $db_condition";
  $result = mysql_query($sql) or die('ERROR_SELECT_DATA_FROM_DB');
  $num_rows = mysql_num_rows($result);
  $value[0] = $num_rows;
  for ($i=1; $i<=$num_rows; $i++) {
    $value[$i] = mysql_fetch_assoc($result);
  }
  return $value;
}
/*************************************************************************************************/
function db_select_row($db_table, $db_field, $db_condition) {
  $sql = "SELECT $db_field FROM $db_table WHERE $db_condition";
  $result = mysql_query($sql) or die('ERROR_SELECT_DATA_FROM_DB');
  $value = mysql_fetch_assoc($result);
  return $value;
}
/*************************************************************************************************/
function db_select_field($db_table, $db_field, $db_condition) {
  $sql = "SELECT $db_field FROM $db_table WHERE $db_condition";
  $result = mysql_query($sql) or die('ERROR_SELECT_DATA_FROM_DB');
  $value = mysql_fetch_array($result);
  return $value[0];
}
/*************************************************************************************************/
function db_insert($db_table, $db_field, $db_values) {
  $sql = "INSERT INTO $db_table ($db_field) VALUES ($db_values)";
  $result = mysql_query($sql) or die('ERROR_INSERT_DATA_INTO_DB');
  return $result;
}
/*************************************************************************************************/
function db_update($db_table, $db_new_values, $db_condition) {
  $sql = "UPDATE $db_table SET $db_new_values WHERE $db_condition";
  $result = mysql_query($sql) or die('ERROR_UPDATE_DATA_INTO_DB');
  return $result;
}
/*************************************************************************************************/
function db_delete($db_table, $db_condition) {
  $sql = "DELETE FROM $db_table WHERE $db_condition";
  $result = mysql_query($sql) or die('ERROR_DELETE_DATA_FROM_DB');
  return $result;
}
/*************************************************************************************************/

/*************************************************************************************************/
function url($url, $text, $title = NULL) {
  $title = empty($title) ? $text : $title;
  return '<a class = "button" href="/' . $url . '" title="' . $title . '">' . $text . '</a>';
}
/*************************************************************************************************/
function alert($message, $time = 1, $url = NULL) {
  print '
  <div id="alert">' . $message . '</div>
  <meta http-equiv="refresh" content="' . $time . '; url=' . $url . '">';
}
/*************************************************************************************************/
function clear($text) {
  $text = stripslashes($text);
  $text = htmlspecialchars($text);
  return $text;
}
/*************************************************************************************************/
function get_settings() {
  $sql = "SELECT * FROM `settings`";
  $result = mysql_query($sql) or die('ERROR_SELECT_SETTINGS');
  $settings = mysql_fetch_assoc($result);
  return $settings;
}
/*************************************************************************************************/
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
/*************************************************************************************************/
function get_message($user_id, $message_type) {
  if ($message_type == 'in') {
    $sql = "SELECT * FROM `messages` WHERE `receiver` = '$user_id'";
  }
  if ($message_type == 'out') {
    $sql = "SELECT * FROM `messages` WHERE `sender` = '$user_id'";
  }
  $result = mysql_query($sql) or die('ERROR_SELECT_DATA_FROM_DB');
  $number = mysql_num_rows($result);
  if ($number == 0) {
    $message = NULL;
  }
  else {
    $message[0] = $number;
    for ($i=1; $i<=$value[0]; $i++) {
      $message[$i] = mysql_fetch_assoc($result);
    }
  }
  return $message;
}
/*************************************************************************************************/
?>