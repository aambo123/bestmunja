<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<html>
<head>
    <meta charset="utf-8" />
    <title>Admin Panel</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <?php $this->load->view('admin/template/head'); ?>
    

    <!--    <link rel="shortcut icon" href="favicon.ico" />-->
</head>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-md">

<?php $this->load->view('admin/template/header'); ?>

<div class="clearfix"> </div>

<div class="page-container">
    <?php $this->load->view('admin/template/left_menu'); ?>

    <div class="page-content-wrapper">
        <?php $this->load->view('admin/'.$main_content.''); ?>
    </div>
</div>

<?php $this->load->view('admin/template/footer'); ?>



<script>
    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").slideUp(500);

    });
</script>

</body>
</html>
