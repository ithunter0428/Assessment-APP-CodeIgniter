<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<!doctype html>
<html lang="<?php echo $lang; ?>">
    <head>
        <meta charset="<?php echo $charset; ?>">
        <title><?php echo $title; ?></title>
<?php if ($mobile === FALSE): ?>
        <!--[if IE 8]>
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
<?php endif; ?>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="google" content="notranslate">
        <meta name="robots" content="noindex, nofollow">
        <link rel="icon" href="<?php echo base_url($dist_dir . '/img/ksu_logo.png'); ?>">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url($plugins_dir . '/fontawesome-free/css/all.min.css'); ?>">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Toastr -->
        <link rel="stylesheet" href="<?php echo base_url($plugins_dir . '/toastr/toastr.min.css'); ?>">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="<?php echo base_url($plugins_dir . '/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url($dist_dir . '/css/adminlte.min.css'); ?>">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <!-- Main CSS -->
        <link rel="stylesheet" href="<?php echo base_url($frameworks_dir . '/public/css/stylesheet.css'); ?>">

        <!-- <link rel="stylesheet" href=" -->
        <?php 
        // echo base_url($plugins_dir . '/icheck/css/blue.css'); 
        ?>
        <!-- "> -->

<?php if ($mobile === FALSE): ?>
        <!--[if lt IE 9]>
            <script src="<?php echo base_url($plugins_dir . '/html5shiv/html5shiv.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/respond/respond.min.js'); ?>"></script>
        <![endif]-->
<?php endif; ?>
    </head>
    <body class="hold-transition login-page login-style">
        <div class="login-box">
