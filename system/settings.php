<?php
/***********************************************/
/*      File for configuration.                */
/***********************************************/
$set = array();
/*********** Database settings *****************/
$set['db_host'] = 'openserver';
$set['db_user'] = 'mysql';
$set['db_pass'] = 'mysql';
$set['db_name'] = 'rcms';
/************** Style settings *****************/
$set['charset'] = 'utf-8';
$set['style'] = 'themes/rcms/style.css';
$set['favicon'] = 'themes/rcms/images/favicon.ico';
$set['header_menu'] = array(
  '1' => array(
    'title' => 'Ссилка 1',
    'link'  => '/nopage',
  ),
  '2' => array(
    'title' => 'Ссилка 2',
    'link'  => '/nopage',
  ),
  '3' => array(
    'title' => 'Ссилка 3',
    'link'  => '/nopage',
  ),
  '4' => array(
    'title' => 'Ссилка 4',
    'link'  => '/nopage',
  ),
  '5' => array(
    'title' => 'Ссилка 5',
    'link'  => '/nopage',
  ),
  '6' => array(
    'title' => 'Ссилка 6',
    'link'  => '/nopage',
  ),
);
?>