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
<?php else: ?>
        <meta name="HandheldFriendly" content="true">
<?php endif; ?>
<?php if ($mobile == TRUE && $mobile_ie == TRUE): ?>
        <meta http-equiv="cleartype" content="on">
<?php endif; ?>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="google" content="notranslate">
        <meta name="robots" content="noindex, nofollow">
<?php if ($mobile == TRUE && $ios == TRUE): ?>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="<?php echo $title; ?>">
<?php endif; ?>
<?php if ($mobile == TRUE && $android == TRUE): ?>
        <meta name="mobile-web-app-capable" content="yes">
<?php endif; ?>
        <link rel="icon" href="<?php echo base_url($dist_dir . '/img/ksu_logo.png'); ?>">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url($plugins_dir . '/fontawesome-free/css/all.min.css'); ?>">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Toastr -->
        <link rel="stylesheet" href="<?php echo base_url($plugins_dir . '/toastr/toastr.min.css'); ?>">
        <!-- Tempusdominus Bbootstrap 4 -->
        <link rel="stylesheet" href="<?php echo base_url($plugins_dir . '/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'); ?>">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="<?php echo base_url($plugins_dir . '/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
        <!-- JQVMap -->
        <link rel="stylesheet" href="<?php echo base_url($plugins_dir . '/jqvmap/jqvmap.min.css'); ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url($dist_dir . '/css/adminlte.min.css'); ?>">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="<?php echo base_url($plugins_dir . '/overlayScrollbars/css/OverlayScrollbars.min.css'); ?>">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo base_url($plugins_dir . '/datatables-bs4/css/dataTables.bootstrap4.css'); ?>">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        
<?php if ($mobile === FALSE && $admin_prefs['transition_page'] == TRUE): ?>
        <link rel="stylesheet" href="<?php echo base_url($plugins_dir . '/animsition/animsition.min.css'); ?>">
<?php endif; ?>
<?php if ($this->router->fetch_class() == 'groups' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
        <link rel="stylesheet" href="<?php echo base_url($plugins_dir . '/colorpickersliders/colorpickersliders.min.css'); ?>">
<?php endif; ?>
        <link rel="stylesheet" href="<?php echo base_url($frameworks_dir . '/domprojects/css/dp.min.css'); ?>">
<?php if ($mobile === FALSE): ?>
        <!--[if lt IE 9]>
            <script src="<?php echo base_url($plugins_dir . '/html5shiv/html5shiv.min.js'); ?>"></script>
            <script src="<?php echo base_url($plugins_dir . '/respond/respond.min.js'); ?>"></script>
        <![endif]-->
<?php endif; ?>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
    <!-- EDITED -->
<?php if ($mobile === TRUE && $admin_prefs['transition_page'] == FALSE): ?>
        <div class="wrapper animsition">
<?php else: ?>
        <div class="wrapper">
<?php endif; ?>
