
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bloginiter</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/fontawesome-free/css/all.min.css">
        <!-- adminlte-->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/admin/adminlte.min.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/admin/custom.css">
        <script src="<?php echo base_url() ?>assets/js/jquery-3.7.1.min.js"></script>

        
    </head>
    <body class="hold-transition sidebar-mini pace-primary">
        <!-- Site wrapper -->
        <div class="wrapper">
            <?php $this->load->view("admin/template/header"); ?>
            <?php $this->load->view("admin/template/nav"); ?>
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-stream"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#" class="nav-link"></a>
                    </li>
                </ul>


            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="<?php echo base_url() ?>blog" class="brand-link">
                    <img src="<?php echo base_url() ?>assets/img/luna-astronauta.jpg" alt="AdminLTE" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">BLog</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                        <img src="<?php echo base_url() ?>assets/img/astro_space.jpg" alt="AdminLTE" class="brand-image img-circle elevation-3" style="opacity: .8">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block">Maic Elian</a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                                 with font-awesome or any other icon font library -->
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-info-circle"></i>
                                    <p>
                                        Dashboard
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo base_url() ?>admin/welcome" class="nav-link">
                                            <i class="far fa-file-alt"></i>
                                            <p>Dashboard v1</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url() ?>admin/welcome" class="nav-link">
                                            <i class="far fa-file-alt"></i>
                                            <p>Dashboard v2</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-user"></i>
                                    <p>
                                        Usuarios
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo base_url() ?>admin/user_crud/add" class="nav-link">
                                            <i class="far fa-plus-square"></i>
                                            <p>Crear</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url() ?>admin/user_crud" class="nav-link">
                                            <i class="fas fa-sort-amount-down"></i>
                                            <p>Listar</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-list"></i>
                                    <p>
                                        Productos
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo base_url() ?>products/product_save" class="nav-link">
                                            <i class="far fa-plus-square"></i>
                                            <p>Crear</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url() ?>products/product_list" class="nav-link">
                                            <i class="fas fa-sort-amount-down"></i>
                                            <p>Listar</p>
                                        </a>
                                    </li>
                                </ul>
                            </li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-list"></i>
                                    <p>
                                        Post
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo base_url() ?>admin/post_save" class="nav-link">
                                            <i class="far fa-plus-square"></i>
                                            <p>Crear</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url() ?>admin/post_list" class="nav-link">
                                            <i class="fas fa-sort-amount-down"></i>
                                            <p>Listar</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-list"></i>
                                    <p>
                                        Categorías
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo base_url() ?>admin/category_list/add" class="nav-link">
                                            <i class="far fa-plus-square"></i>
                                            <p>Crear</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url() ?>admin/category_list" class="nav-link">
                                            <i class="fas fa-sort-amount-down"></i>
                                            <p>Listar</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {title}
                    </h1>
                    <?php (isset($breadcrumb)) ? $this->load->view("admin/template/breadcrumb", ["breadcrumb" => $breadcrumb]) : '' ?>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            
                        </div>
                        <!-- /.card-header -->
                        <div class="box-body">
                            <?php if (isset($body)): ?>
                                {body}
                            <?php endif; ?>

                            <?php (isset($grocery_crud)) ? $this->load->view("admin/template/grocery_crud", ["grocery_crud" => $grocery_crud]) : '' ?>
                            <!-- <?php (isset($grocery_crud)) ? $this->load->view("admin/template/grocery_crud", ["grocery_crud_header" => $grocery_crud]) : '' ?> -->

                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php $this->load->view("admin/template/footer"); ?>
            <div class="control-sidebar-bg"></div>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->


        
        <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url() ?>assets/js/admin/adminlte.min.js"></script>
        <script src="<?php echo base_url() ?>assets/ckeditor/ckeditor.js"></script>
        <script src="<?php echo base_url() ?>assets/js/admin/main.js"></script>
        
    </body>
</html>
