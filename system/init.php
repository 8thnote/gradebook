<?php
session_start();
db_connect();
$settings = get_settings();
$page = get_page($_GET['page']);
print '<pre>' . print_r($page,true) . '</pre>';
?>