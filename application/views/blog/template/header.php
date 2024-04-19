<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo base_url() . 'admin/post_list' ?>">
        <img class="logo" src="<?php echo base_url() . 'assets/img/astro.jpg' ?>">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#"><?php echo APP_NAME ?> <span class="sr-only">(current)</span></a>
            </li>

        </ul>
        <div class="input-group-prepend">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</button>
            <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
            <div role="separator" class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Separated link</a>
            </div>
        </div>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <ul class="nav navbar navbar-rigth user-options">
            <?php if ($this->session->userdata("id") != NULL):  ?>
                <li title="Perfil">
                    <a href="<?php echo base_url() . 'app/profile' ?>">
                        <span class="fa fa-user"></span>
                    </a>
                </li>
                <li title="Favoritos">
                    <a href="#">
                        <span class="fa fa-user"></span>
                    </a>
                </li>
                <li title="Cerrar Sesion">
                    <a href="<?php echo base_url() . 'app/logout' ?>">
                        <span class="fa fa-sing-out"></span>
                    </a>
                </li>

                <?php else: ?>
                    <li title="Login">
                        <a href="login">
                            <span class="fa fa-sing-in"></span>
                        </a>
                    </li>
                <?php endif; ?>
        </ul>
    </div>
</nav>