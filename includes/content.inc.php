<?php

function get_menu() {
  $menu_items = array(
    l('Front', ''),
    l('Gradebook', 'gradebook'),
    l('Authorization', 'authorization'),
  );
  return tag('div', item_list($menu_items), array('id' => array('menu')));
}

function get_copyright() {
  return 'Made by RomiOS';
}

?>