<?php
define('ROOT_DIR', getcwd());
require_once 'includes/boot.inc.php';
session_start();
db_connect();
execute();
?>