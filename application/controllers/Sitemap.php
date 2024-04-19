<?php

class Sitemap extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['posts'] = $this->Post->GetAllPost();
        $this->load->view("sitemap", $data);
    }

}
