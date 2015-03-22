<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <title><?php if(isset($title)){ echo $title.'-';} echo APPNAME; ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- IE9 -->
    <script src="<?php echo URL; ?>js/modernizr-2.6.2-respond-1.1.0.min.js"></script>

    <!-- CSS -->
    <link href="<?php echo URL; ?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo URL; ?>css/style.css" rel="stylesheet">


</head>
<body>
    <!-- logo -->
    <div class="logo">
       Musika
    </div>

    <!-- navigation -->
    <div class="navigation">
        <a href="<?php echo URL; ?>">home</a>
        <a href="<?php echo URL; ?>home/exampleone">subpage</a>
        <a href="<?php echo URL; ?>home/exampletwo">subpage 2</a>
        <a href="<?php echo URL; ?>songs">songs</a>

        <!-- if user login -->

        <!--  <a href="#/account">My account</a>
        <a href="#/songs">My songs</a> -->


    </div>
