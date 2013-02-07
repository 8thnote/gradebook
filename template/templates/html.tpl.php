<!DOCTYPE html>
<html>
<head>
  <title><?php print $title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8;">
  <link rel="stylesheet" type="text/css" href="<?php print BASE_URL . '/template/css/style.css'; ?>">
  <link rel="shortcut icon" href="/images/favicon.ico">
</head>
<body>
  <div id="container">
    <div id="header"><?php print $header; ?></div>
    <div id="breadcrumb"><?php print $breadcrumb; ?></div>
    <div id="content"><?php print $content; ?></div>
    <div id="footer"><?php print $footer; ?></div>
  </div>
</body>
</html>