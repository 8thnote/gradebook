<?php

function get_menu() {
  $menu_items = array(
    l(t('Front'), ''),
    l(t('Gradebook'), 'faculties'),
    l(t('Authorization'), 'authorization'),
  );
  return item_list($menu_items);
}

function get_header() {
  return tag('h1', t('Gradebook'));
}

function get_copyright() {
  return tag('strong' ,t('Made by RomiOS'));
}

?>