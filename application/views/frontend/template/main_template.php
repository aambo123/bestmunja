<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<html>
<head>

    <?php $this->load->view('frontend/template/head'); ?>
    <?php
     $dat['general_info'] = $this->settings_model->get_meta();
     $this->load->view('frontend/template/meta',$dat); ?>
</head>

<body>
<div class="app">
<?php $this->load->view('frontend/template/menu'); ?>
<?php $this->load->view(''.$main_content.''); ?>
<?php $this->load->view('frontend/template/footer'); ?>
</div>
</body>
</html>
