<?php

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

class Store extends REST_Controller {

   /* use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }*/

    public function index_get() {
        $this->response(array("id" => "Hola Mundo"));
    }

//    public function stripe_form_get() {
//        $this->response($this->load->view("/store/utils/stripe_form", NULL, TRUE));
//    }

    public function product_get($id = null) {
        $this->response($this->Product->find($id));
    }

    public function product_by_url_clean_get($url_clean) {
        $this->response($this->Product->getByUrlClean($url_clean));
    }

    public function products_get($offset = 0, $category_id = "") {

        $offset--;

        //$category_id = $this->input->get("category_id");

        $offset *= PAGE_SIZE; // $offset=$offset * PAGE_SIZE;

        $this->response($this->Product->getPagination($offset, $category_id));
    }

    public function products_by_group_get() {

        $products_id = explode(",", $this->input->get("products_id"));

        $this->response($this->Product->getByProductsGroup($products_id));
    }

    public function categories_get() {
        $this->response($this->Product_category->findAll());
    }

    public function locations_get() {
        $this->response($this->Location->findAll());
    }

    public function product_count_get($category_id = "") {
        $count = $this->Product->count($category_id);
        $last_page = ceil($count / PAGE_SIZE);

        $this->response($last_page);
    }

    public function request_post() {
        $post_id = 0;

        $res = array("status" => "no", "msj" => "");

        if ($this->input->server('REQUEST_METHOD') == "POST") {

            $this->form_validation->set_rules('phone', 'Teléfono', 'required|min_length[8]|max_length[8]');
            $this->form_validation->set_rules('address', 'Dirección', 'required|min_length[10]|max_length[100]');
            $this->form_validation->set_rules('location_id', 'Localización', 'required');

            $total = 0;
            if ($this->form_validation->run()) {

                $products_count = explode(",", $this->input->post("products_count"));
                $products_id = explode(",", $this->input->post("products_id"));

                $products = $this->Product->getByProductsGroup($products_id);

                if (sizeof($products) > 0 && sizeof($products) == sizeof($products_count)) {

                    foreach ($products as $key => $product) {
                        $total += $product->price * $products_count[$key];
                    }

                    $request = array(
                        'phone' => $this->input->post("phone"),
                        'address' => $this->input->post("address"),
                        'location_id' => $this->input->post("location_id"),
                        'user_id' => $this->session->userdata("id"),
                        'products_id' => $this->input->post("products_id"),
                        'products_count' => $this->input->post("products_count"),
                        'total' => $total,
                        'total_stripe' => intval($total) * 100
                    );

                    $this->session->set_userdata("request", $request);

                    $res["status"] = "yes";
                    $res["data"] = '<div class="alert alert-success" role="alert">Datos validados con éxito</div>';
                } else {
                    $res["data"] = '<div class="alert alert-success" role="alert">Ocurrio un error con el carrito</div>';
                }
            } else {
                $res["data"] = validation_errors('<div class="alert alert-danger" role="alert">', '</div>');
            }
        }

        $this->response($res);
    }

    function my_requests_get() {

        if ($this->session->userdata("id") == null) {
            return $this->response(array());
        }

        $this->response($this->Request->getByUserId($this->session->userdata("id")));
    }

    function my_request_detail_get($request_id = null) {

        if ($this->session->userdata("id") == null) {
            return $this->response(array());
        }

        if (!isset($request_id)) {
            return $this->response(array());
        }

        $request = $this->Request->find($request_id);

        if (!isset($request)) {
            return $this->response(array());
        }

        if ($request->user_id != $this->session->userdata("id")) {
            return $this->response(array());
        }

        $this->response(view_detail_request($request_id));
    }

}
