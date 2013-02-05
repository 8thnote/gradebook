<!DOCTYPE html>
<html>
<head>
  <title><?php print $page['title']; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8;">
  <link rel="stylesheet" type="text/css" href="/themes/rcms/style.css">
  <link rel="shortcut icon" href="/images/favicon.ico">
</head>
<body>
  <div id="page">
    <div id="header"><?php include('blocks/header.php'); ?></div>
    <div id="left"><?php include('blocks/user_bar.php'); ?></div>
    <div id="right"><?php include('blocks/user_bar.php'); ?></div>
    <div id="center"><?php include('pages/' . $page['path'] . '.php'); ?></div>
    <div id="footer"><?php include('blocks/footer.php'); ?></div>
  </div>
</body>
</html>