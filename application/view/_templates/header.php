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
   <div class="logo" align="center" style=" width: 850px;
                                            margin: 30px auto;
                                           background-color: #888888;
                                           color: #acb82d;
                                           font-family: Helvetica">
        MUSIKA <br>
   </div>

    <!-- navigation -->
    <div class="navigation" align="left" style="width: 850px;
                                            margin: 30px auto; color: #222222">
        <a href="<?php echo URL; ?>" style="margin-right: 20px; border-radius: 5px; background: gray; width: 130px">home</a>
        <a href="<?php echo URL; ?>songs" style="margin-right: 20px; border-radius: 5px; background: gray; width: 130px">songs</a>
        <a href="<?php echo URL; ?>users" style="margin-right: 20px; border-radius: 5px; background: gray; width: 130px">Account</a>
        <a href="#" style="margin-right: 20px; border-radius: 5px; background: gray; width: 130px">FAQ</a>

        <!-- if user login -->

        <!--  <a href="#/account">My account</a>
        <a href="#/songs">My songs</a> -->


    </div>
