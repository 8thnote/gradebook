<!DOCTYPE html>
<html>
<head>
  <title><?php print $title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" type="text/css" href="<?php print BASE_URL . '/template/css/style.css'; ?>">
  <link rel="shortcut icon" href="/images/favicon.ico">
</head>
<body>
  <div id="container">
    <div id="header"><?php print $menu; ?></div>
    <?php if ($breadcrumb) { ?>
      <div id="breadcrumb"><?php print $breadcrumb; ?></div>
    <?php } ?>
    <?php if ($message) { ?>
      <div id="message"><?php print $message; ?></div>
    <?php } ?>
    <div id="content"><?php print $content; ?></div>
    <div id="footer"><?php print $copyright; ?></div>
  </div>
</body>
</html>