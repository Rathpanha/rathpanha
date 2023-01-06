<!DOCTYPE HTML>
<html>
  <head>
    <title><?php echo $header->title; ?></title>
    
    <!-- META -->
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1"/>
    <meta name="theme-color" content="#626567">
    <meta charset="UTF-8"/>
    <meta name="keywords" content="<?php echo $header->keyword; ?>" />
    <meta name="description" content="<?php echo $header->description; ?>" />	
    <meta property="og:title" content="<?php echo $header->title; ?>" />
    <meta property="og:url" content="<?php echo "https://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]; ?>" />
    <meta property="og:description" content="<?php echo $header->description; ?>" />
    <meta property="og:site_name" content="Rathpanha"/>
    <?php if (!empty($header->image)) { ?>
      <meta property="og:image" content="https:<?php echo $header->image; ?>" />
    <?php } else { ?>
      <meta property="og:image" content="https://www.rathpanha.com/images/rathpanha.jpg" />
    <?php } ?>
      
    <?php \Security\CSRF::generateMeta(); ?>
    
    <!-- CSS -->  
    <link href="/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link href="/favicon.ico" type="image/x-icon" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata&display=swap" rel="stylesheet">
    <link href="/css/style.css?2" rel="stylesheet">
  </head>

  <body>
