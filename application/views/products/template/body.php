<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo APP_NAME . ' | ' . APP_DESCRIPTION ?></title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/fontawesome-free/css/all.min.css">
        <!-- adminlte-->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/admin/adminlte.min.css">

        <script src="<?php echo base_url() ?>assets/js/jquery-3.7.1.min.js"></script>

        <?php (isset($grocery_crud)) ? $this->load->view("admin/template/grocery_crud_header", ["grocery_crud" => $grocery_crud]) : '' ?>
    </head>
    <body class="hold-transition sidebar-mini pace-primary">
        <!-- Site wrapper -->
        <div class="wrapper">

            <?php $this->load->view("admin/template/header"); ?>
            <?php $this->load->view("admin/template/nav"); ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>
                                    {title}
                                </h1>
                            </div>
                            <div class="col-sm-6">
                                <?php (isset($breadcrumb)) ? $this->load->view("admin/template/breadcrumb", ["breadcrumb" => $breadcrumb]) : '' ?>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <?php if (isset($body)): ?>
                        <div class="card">
                            <div class="card-body">
                                {body}
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php (isset($grocery_crud)) ? $this->load->view("admin/template/grocery_crud", ["grocery_crud" => $grocery_crud]) : '' ?>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->


        <?php $this->load->view("admin/template/footer"); ?>


        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url() ?>assets/js/admin/adminlte.min.js"></script>
        <script src="<?php echo base_url() ?>assets/ckeditor/ckeditor.js"></script>
        <script src="<?php echo base_url() ?>assets/js/admin/main.js"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.toaster.js"></script>

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