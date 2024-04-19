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

        <?php
        meta_tags($title, $desc, $imgurl, $url);
        ?>

        <script>
            var BASE_URL = "<?php echo base_url() ?>";
        </script>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div id="app">
            <?php $this->load->view("spa/template/header"); ?>
            <section class="container">

                // <?php if ($this->session->userdata("auth_level") == 9): ?>
                    <a href="<?php echo base_url() ?>admin" class="btn-success btn btn-sm m-2">
                        <i class="fa fa-cog"></i> Admin
                    </a>
                // <?php endif; ?>

                <div v-html="res_search"></div>
                <router-view></router-view>
            </section>

            <?php $this->load->view("spa/template/footer"); ?>


        </div>

        <script src="<?php echo base_url() ?>assets/js/jquery-3.7.1.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.toaster.js"></script>

        <script src="<?php echo base_url() ?>assets/js/blog/jquery-comments.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/blog/jquery-comments.css">

        <script src="<?php echo base_url() ?>assets/js/blog/vue/vue-plain-pagination.umd.min.js"></script>
        <script src="<?php echo base_url() ?>assets/js/blog/vue/component/CategoryPost.js"></script>
        <script src="<?php echo base_url() ?>assets/js/blog/vue/component/SocialLinks.js"></script>
        <script src="<?php echo base_url() ?>assets/js/blog/vue/component/ImagePost.js"></script>
        <script src="<?php echo base_url() ?>assets/js/blog/vue/component/ListPostBase.js"></script>
        <script src="<?php echo base_url() ?>assets/js/blog/vue/component/ListPost.js"></script>
        <script src="<?php echo base_url() ?>assets/js/blog/vue/component/ListCategoryPost.js"></script>
        <script src="<?php echo base_url() ?>assets/js/blog/vue/component/DetailPost.js"></script>
        <script src="<?php echo base_url() ?>assets/js/blog/vue/app.js"></script>
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
