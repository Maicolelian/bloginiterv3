<?php

class Spa extends MY_Controller {

    public function __construct() {
        parent::__construct();
        /* $this->optional_session_auto(1); */
    }

    public function index($num_page = 1) {

        $num_page--;
        $num_post = $this->Post->count();
        $last_page = ceil($num_post / PAGE_SIZE);

        if ($num_page < 0) {
            $num_page = 0;
        } elseif ($num_page > $last_page) {
            // TODO
            $num_page = 0;
        }

        $offset = $num_page * PAGE_SIZE;

        $data = $this->build_header('', '', '', base_url() . 'blog');

        $data['last_page'] = $last_page;
        $data['current_page'] = $num_page;
        $data['token_url'] = 'spa/';
        $data['posts'] = $this->Post->get_pagination($offset, $this->session->userdata("id"));
        $data['last_page'] = $last_page;
        $data['pagination'] = true;
        $view['body'] = $this->load->view("spa/utils/post_list", $data, TRUE);
        $this->parser->parse("spa/template/body", $view);
    }

    public function jpost_list($num_page = 1) {

        $num_page--;
        $num_post = $this->Post->count();
        $last_page = ceil($num_post / PAGE_SIZE);

        if ($num_page < 0) {
            $num_page = 0;
        } elseif ($num_page > $last_page) {
            // TODO
            $num_page = 0;
        }

        $offset = $num_page * PAGE_SIZE;

        $data = $this->build_header('', '', '', base_url() . 'blog');

        $data['last_page'] = $last_page;
        $data['current_page'] = $num_page;
        $data['token_url'] = 'spa/';
        $data['posts'] = $this->Post->get_pagination($offset, $this->session->userdata("id"));
        $data['last_page'] = $last_page;
        $data['pagination'] = true;
        echo json_encode($data);
//        $view['body'] = $this->load->view("spa/utils/post_list", $data, TRUE);
//        $this->parser->parse("spa/template/body", $view);
    }

    public function jpost_list_count() {

        $num_post = $this->Post->count();
        $last_page = ceil($num_post / PAGE_SIZE);

        echo json_encode($last_page);
//        $view['body'] = $this->load->view("spa/utils/post_list", $data, TRUE);
//        $this->parser->parse("spa/template/body", $view);
    }

    public function category($c_clean_url, $num_page = 1) {

        $category = $this->Category->GetByUrlClean($c_clean_url);

        if (!isset($category)) {
            show_404();
        }

        $num_page--;
        $num_post = $this->Post->countByCUrlClean($c_clean_url);
        $last_page = ceil($num_post / PAGE_SIZE);

        if ($num_page < 0 || $num_page > $last_page) {
            redirect('/spa/category' . $c_clean_url);
        }

        $offset = $num_page * PAGE_SIZE;

        $data = $this->build_header('', '', '', base_url() . 'spa/category');

        $data['last_page'] = $last_page;
        $data['current_page'] = $num_page;
        $data['token_url'] = 'spa/category/' . $c_clean_url . '/';
        $data['posts'] = $this->Post->get_pagination($offset, $this->session->userdata("id"), 'Si', 'desc', $c_clean_url);
        $data['last_page'] = $last_page;
        $data['pagination'] = true;
        $view['body'] = $this->load->view("spa/utils/post_list", $data, TRUE);
        $this->parser->parse("spa/template/body", $view);
    }

    public function j_post_list_category($c_clean_url, $num_page = 1) {

        $category = $this->Category->GetByUrlClean($c_clean_url);

        if (!isset($category)) {
            show_404();
        }

        $num_page--;
        $num_post = $this->Post->countByCUrlClean($c_clean_url);
        $last_page = ceil($num_post / PAGE_SIZE);

        if ($num_page < 0 || $num_page > $last_page) {
            redirect('/spa/category' . $c_clean_url);
        }

        $offset = $num_page * PAGE_SIZE;

        $data = $this->build_header('', '', '', base_url() . 'spa/category');

        $data['last_page'] = $last_page;
        $data['current_page'] = $num_page;
        $data['title'] = $category->name;
        $data['token_url'] = 'spa/category/' . $c_clean_url . '/';
        $data['posts'] = $this->Post->get_pagination($offset, $this->session->userdata("id"), 'Si', 'desc', $c_clean_url);
        $data['last_page'] = $last_page;
        $data['pagination'] = true;
        echo json_encode($data);
//        $view['body'] = $this->load->view("spa/utils/post_list", $data, TRUE);
//        $this->parser->parse("spa/template/body", $view);
    }

    public function j_post_list_category_count($c_clean_url) {

        $category = $this->Category->GetByUrlClean($c_clean_url);

        if (!isset($category)) {
            echo json_encode(0);
            return;
        }

        $num_post = $this->Post->countByCUrlClean($c_clean_url);
        $last_page = ceil($num_post / PAGE_SIZE);

        echo json_encode($last_page);
    }

    public function post_view($c_clean_url, $clean_url = null) {

        if (ENVIRONMENT === 'production')
            $this->output->cache(PAGE_CACHE);

        if (strpos($this->uri->uri_string(), 'spa/post_view') !== false)
            show_404();

        if (!isset($clean_url)) {
            show_404();
        }

        $post = $this->Post->GetByUrlClean($clean_url);

        if (!isset($post)) {
            show_404();
        }

        $category = $this->Category->GetByUrlClean($c_clean_url);

        if (!isset($category)) {
            show_404();
        }

        $data = $this->build_header(APP_NAME . ' - ' . $post->title, $post->description, image_post($post->post_id), base_url() . $post->url_clean);

        $data['post'] = $post;
        $view['body'] = $this->load->view("spa/utils/post_detail", $data, TRUE);
        $this->parser->parse("spa/template/body", $view);
    }

    public function jpost_view($c_clean_url, $clean_url = null) {

        if (ENVIRONMENT === 'production')
            $this->output->cache(PAGE_CACHE);

        if (strpos($this->uri->uri_string(), 'spa/post_view') !== false)
            show_404();

        if (!isset($clean_url)) {
            show_404();
        }

        $post = $this->Post->GetByUrlClean($clean_url);

        if (!isset($post)) {
            show_404();
        }

        $category = $this->Category->GetByUrlClean($c_clean_url);

        if (!isset($category)) {
            show_404();
        }

        $data = $this->build_header(APP_NAME . ' - ' . $post->title, $post->description, image_post($post->post_id), base_url() . $post->url_clean);

        $data['post'] = $post;
        echo json_encode($data);
//        $view['body'] = $this->load->view("spa/utils/post_detail", $data, TRUE);
//        $this->parser->parse("spa/template/body", $view);
    }

    public function search() {

        $search = $this->input->get_post("search");
        $category_id = $this->input->get_post("category_id");

        if ($search == "") {
            return "";
        }

        $searchs = explode(" ", $search);
        $posts = $this->Post->getBySearch($searchs, $category_id);
        $data['posts'] = $posts;
        $data['pagination'] = false;

        echo json_encode($this->load->view("spa/utils/post_list", $data, TRUE));
    }

    /* Favorite */

    public function favorite($post_id) {

        $this->load->model('Group_user_post');

        $res = 0;
        if ($this->session->userdata("id") != null) {

            $group_user_post = $this->Group_user_post->findByPostIdAndUserId($post_id, $this->session->userdata("id"));

            if (isset($group_user_post)) {
                // vamos a borrar
                $this->Group_user_post->deleteByPostIdAndUserId($post_id, $this->session->userdata("id"));
            } else {
                // nuevo favorito
                $save = array('user_id' => $this->session->userdata("id"), 'post_id' => $post_id);
                $res = $this->Group_user_post->insert($save);
            }
        }

        echo $res;
    }

    public function favorite_list() {
        $this->load->model('Group_user_post');

        if ($this->session->userdata("id") == null) {
            show_404();
        }

        $posts = $this->Post->getGUP($this->session->userdata("id"));

        $data = $this->build_header('', '', '', base_url() . 'spa/favorite_list');

        $data['posts'] = $posts;
        $data['pagination'] = false;
        $view['body'] = $this->load->view("spa/utils/post_list", $data, TRUE);
        $this->parser->parse("spa/template/body", $view);
    }

    /* funciones privada */

    private function build_header($title = '', $desc = '', $imgurl = '', $url = '') {
        // meta SEO
        $data['title'] = $title;
        $data['desc'] = $desc;
        $data['imgurl'] = $imgurl;
        $data['url'] = $url;

        return $data;
    }

}
