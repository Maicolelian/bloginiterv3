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
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/store/custom.css">
        <script src="<?php echo base_url() ?>assets/js/store/vue/vue.js"></script>
        <script src="<?php echo base_url() ?>assets/js/store/vue/vue-router.js"></script>
        <script src="https://js.stripe.com/v3/"></script>

        <script>
            var BASE_URL = "<?php echo base_url() ?>";
            var BASE_URL_REST = "<?php echo base_url() ?>rest/store/";
            var BASE_URL_REST_PERSON = "<?php echo base_url() ?>rest/person/";
        </script>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div id="app">
            <?php $this->load->view("store/template/header"); ?>
            <section class="container-fluid">

                <?php if ($this->session->userdata("auth_level") == 9): ?>
                    <a href="<?php echo base_url() ?>admin" class="btn-success btn btn-sm m-2">
                        <i class="fa fa-cog"></i> Admin
                    </a>

                <?php endif; ?>

                <router-view></router-view>

                <?php if (isset($body)): ?>
                    <div class="container">
                        {body}
                    </div>
                <?php endif; ?>
            </section>

            <?php $this->load->view("store/template/footer"); ?>


        </div>

        <script src="<?php echo base_url() ?>assets/js/jquery-3.7.1.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.toaster.js"></script>

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
        <?php if ($this->session->flashdata("text") != null): ?>
            <script>
            $.toaster({
                priority: '<?php echo $this->session->flashdata("type") ?>',
                title: '<?php echo $this->session->flashdata("text") ?>',
                message: ''});
            </script>
        <?php endif; ?>
    </body>
</html>
