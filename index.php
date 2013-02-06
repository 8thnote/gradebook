<?php
require_once('includes/boot.inc.php');
session_start();
globals_init();
db_connect();
process();
render();
?>