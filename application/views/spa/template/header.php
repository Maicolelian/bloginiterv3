<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo base_url() . 'blog' ?>">
        <img class="logo" src="<?php echo base_url() . 'assets/img/logo.png' ?>">
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

        </ul>
        <div class="form-inline my-2 my-lg-0" id="search-results">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <select v-model="search_category">
                        <option value="">Categoría</option>
                        <?php $this->load->view("spa/utils/category_list", array("categories" => get_all_categories())) ?>
                    </select>
                </div>
                <input v-model="search" type="text" class="form-control" placeholder="Buscar...">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary btn-search-post" @click="search_post" type="button"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>
        <ul class="nav navbar-nav navbar-right user-options">
            <?php if ($this->session->userdata("id") != NULL): ?>
                <li title="Perfil">
                    <a  href="<?php echo base_url() . 'app/profile' ?>">
                        <span class="fa fa-user"></span>
                    </a>
                </li>
                <li title="Favoritos">
                    <a  href="<?php echo base_url() . 'blog/favorite_list' ?>">
                        <span class="fa fa-heart"></span>
                    </a>
                </li>
                <li title="Cerrar Sesión">
                    <a href="<?php echo base_url() . 'app/logout' ?>">
                        <span class="fa fa-sign-out"></span>
                    </a>
                </li>
            <?php else: ?>
                <li title="Login">
                    <a href="<?php echo base_url() ?>login">
                        <span class="fa fa-sign-in"></span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>