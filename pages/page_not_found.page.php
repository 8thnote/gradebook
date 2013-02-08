<?php

function page_not_found_page_info() {
  return array(
    'path'    => 'page_not_found',
    'title'   => 'page_not_found_page_title',
    'content' => 'page_not_found_page_content',
    'access'  => 'page_not_found_page_access',
  );
}

function page_not_found_page_title() {
  return 'Page Not Found';
}

function page_not_found_page_content() {
  return 'Page Not Found (404)';
}

function page_not_found_page_access() {
  return TRUE;
}

?>