<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo APP_NAME . ' | ' . APP_DESCRIPTION ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/fontawesome-free/css/fontawesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/blog/custom.css">
        <script src="<?php echo base_url() ?>assets/js/blog/vue/vue.js"></script>
        <script src="<?php echo base_url() ?>assets/js/blog/vue/vue-router.js"></script>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <?php $this->load->view("blog/template/header"); ?>
        <section class="container">
            <div id="post_search"></div>
            {body}
        </section>

        <?php $this->load->view("blog/template/footer"); ?>

        <script src="<?php echo base_url() ?>assets/js/jquery-3.7.1.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>

        <script src="<?php echo base_url() ?>assets/js/store/vue/vue-plain-pagination.umd.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/store/vue/vue-cookies.js"></script>
        <script src="<?php echo base_url() ?>assets/js/store/vue/component/Car.js"></script>
        <script src="<?php echo base_url() ?>assets/js/store/vue/component/ModalPay.js"></script>
        <script src="<?php echo base_url() ?>assets/js/store/vue/component/TablePay.js"></script>
        <script src="<?php echo base_url() ?>assets/js/store/vue/component/TableRequest.js"></script>
        <script src="<?php echo base_url() ?>assets/js/store/vue/component/DetailRequest.js"></script>
        <script src="<?php echo base_url() ?>assets/js/store/vue/component/Pay.js"></script>
        <script src="<?php echo base_url() ?>assets/js/store/vue/component/List.js"></script>
        <script src="<?php echo base_url() ?>assets/js/store/vue/component/Category.js"></script>
        <script src="<?php echo base_url() ?>assets/js/store/vue/component/Detail.js"></script>
        <script src="<?php echo base_url() ?>assets/js/store/vue/component/Checkout.js"></script>
        <script src="<?php echo base_url() ?>assets/js/store/vue/app.js"></script>
        
    </body>
</html>
