<?php
/**
 * Function for connect to database.
 */
function db_connect($db_host, $db_user, $db_pass, $db_name) {
  mysql_connect($db_host, $db_user, $db_pass) or die('ERROR_001');
  mysql_select_db($db_name) or die('ERROR_002');
  return TRUE;
}
/**
 * Function for select from database.
 */
function db_select($db_table, $db_field, $db_condition) {
  $sql = "SELECT $db_field FROM $db_table WHERE $db_condition";
  $result = mysql_query($sql) or die('ERROR_003');
  $value[0] = mysql_num_rows($result);
  for ($i=1; $i<=$value[0]; $i++) {
    $value[$i] = mysql_fetch_assoc($result);
  }
  return $value;
}
/**
 * Function for insert into database.
 */
function db_insert($db_table, $db_field, $db_values) {
  $sql = "INSERT INTO $db_table ($db_field) VALUES ($db_values)";
  $result = mysql_query($sql) or die('ERROR_004');
  return $result;
}
/**
 * Function for delete from database.
 */
function db_update($db_table, $db_new_values, $db_condition) {
  $sql = "UPDATE $db_table SET $db_new_values WHERE $db_condition";
  $result = mysql_query($sql) or die('ERROR_005');
  return $result;
}
/**
 * Function update database.
 */
function db_delete($db_table, $db_condition) {
  $sql = "DELETE FROM $db_table WHERE $db_condition";
  $result = mysql_query($sql) or die('ERROR_006');
  return $result;
}
?>