<!doctype html>
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
    <meta property="og:site_name" content="Rathpanha Custom" />
    <?php if (!empty($header->image)) { ?>
      <meta property="og:image" content="https:<?php echo $header->image; ?>" />
    <?php } else { ?>
      <meta property="og:image" content="https://custom.rathpanha.com/images/logo.png" />
    <?php } ?>
      
    <?php \Security\CSRF::generateMeta(); ?>
    
    <!-- CSS -->  
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/css/core.css?2"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/chosen.min.css?4"/>
<!--    <link rel="stylesheet" type="text/css" href="/assets/masterslider/style.css">
    <link rel="stylesheet" type="text/css" href="/css/masterslider.css"/>-->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=PT+Sans">
    
    <!-- JS --> 
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="/js/chosen.jquery.min.js"></script>
<!--    <script src="/js/masterslider.min.js"></script>-->
    <script src="/js/core.js?1"></script>
    <script src="/js/jquery_mousewheel.js"></script>
    <script src="/js/jquery_visible.js"></script>
    <script src="/js/jquery_resize.js"></script>
    <script src="/js/animate_number.js"></script>
</head>

<body>
  <div class="nav-replace"></div>
    <nav class="menu">
      <div class="nav <?php echo ($panel == "admin" ? "admin" : ""); ?>">
        <a class="items side-menu-toggle <?php echo ($panel == "admin" ? "admin" : ""); ?>" href="#"><i class="fas fa-bars fa-lg fa-fw"></i></a>
        <a class="items flex logo" href="/"><img src='/images/logo.png'/></a>
        <div class="items fill no-padding"></div>
      </div>
    </nav>
  
    <?php $this->show('parts/side_menu'); ?>