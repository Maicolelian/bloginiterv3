<nav class="navbar navbar-expand-lg navbar-light border-red">
    <a class="navbar-brand" href="<?php echo base_url() . 'blog' ?>">
        <img class="logo" src="<?php echo base_url() . 'assets/img/astro_space.jpg' ?>">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
            <router-link class="nav-link" to="/">
                <?php echo APP_NAME ?> <span class="sr-only">(current)</span>
            </router-link>
            </li>

            <li v-if="ifAuth()" class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Opciones
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <router-link class="nav-link" to="requests">
                        Pedidos
                    </router-link>
                </div>
            </li>

        </ul>

        <ul v-if="ifAuth()" class="nav navbar-nav navbar-right user-options">
            <li>
                {{ hi() }}
            </li>
            <li title="Cerrar Sesión" class="ml-3">
                <a href="<?php echo base_url() . 'app/logout' ?>">
                    <span class="fa fa-sign-out text-danger"></span>
                </a>
            </li>
        </ul>
        <ul v-else class="nav navbar-nav navbar-right user-options">
            <li title="Login">
                <a href="<?php echo base_url() . 'login' ?>">
                    <span class="fa fa-sign-in"></span>
                </a>
            </li>
        </ul>
    </div>

</nav>