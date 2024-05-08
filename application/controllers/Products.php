<?php

class Products extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('Form_validation');
        $this->load->library('grocery_CRUD');

        $this->load->helper(array('form', 'Product_helper'));
        $this->load->helper('Breadcrumb_helper');

        $this->load->model(array('Product', 'Product_category', 'Product_image'));

        /* $this->init_session_auto(6); */
    }

    public function index() {
        redirect('products/product_list');
    }

    /*
     * CRUD PARA LOS PRODUCT
     */

    public function product_list() {
        // $data["products"] = $this->Product->findAll();
        //$view["body"] = $this->load->view("products/product/list", $data, TRUE);

        $crud = new grocery_CRUD();

        /* if ($this->session->userdata("auth_level") == 6) {
            $crud->where('user_id', $this->session->userdata("id"));
        } */

        $crud->set_table('products');
        $crud->set_subject('Product');
        $crud->columns('title', 'description', 'created_at', 'price');

        $crud->callback_before_insert(array($this, 'category_iu_before_callback'));
        $crud->callback_before_update(array($this, 'category_iu_before_callback'));

        $crud->set_rules('name', 'Nombre', 'required|min_length[10]|max_length[100]');

        $crud->unset_jquery();
        $crud->unset_add();
        $crud->unset_clone();
        $crud->unset_read();
        $crud->unset_edit();

        $crud->add_action('Editar', '', 'products/product_save', 'edit-icon');
        $crud->add_action('Images', '', 'products/product_image', 'edit-icon');

        $output = $crud->render();
        $view["grocery_crud"] = json_encode($output);
        $view['breadcrumb'] = breadcrumb_products("products");
        $view["title"] = "Products";
        $this->parser->parse("products/template/body", $view);
    }

    public function product_image($product_id = null) {

        if (!isset($product_id)) {
            show_404();
        }

        $data['product'] = $product = $this->Product->find($product_id);
        $data['images'] = $this->Product_image->getByProductId($product_id);
        
        foreach ($data['images'] as $key => $image) {
            $image->size = filesize("uploads/product/".$image->image);
        }

        if (!isset($product)) {
            show_404();
        }

        $view["body"] = $this->load->view("products/products/image", $data, TRUE);
        $view["title"] = $product->title;
        $this->parser->parse("products/template/body", $view);
    }

    public function product_save($product_id = null) {

        $data["product_id"] = $product_id;

        if ($product_id == null) {
            // crear product
            $data['category_id'] = $data['title'] = $data['price'] = $data['content'] = $data['description'] = $data['url_clean'] = "";
            $view["title"] = "Crear Producto";
        } else {
            // edicion product
            $product = $this->Product->find($product_id, null);

            if (!isset($product)) {
                show_404();
            }

            /* if ($this->session->userdata("auth_level") == 6 && $this->session->userdata("id") != $product->user_id) {
                show_404();
            } */

            $data['title'] = $product->title;
            $data['content'] = $product->content;
            $data['description'] = $product->description;
            $data['url_clean'] = $product->url_clean;
            $data['price'] = $product->price;
            $data['category_id'] = $product->product_category_id;
            $view["title"] = "Actualizar Producto";
        }

        // para el listado de categorias
        $data['categories'] = product_categories_to_form($this->Product_category->findAll());

        if ($this->input->server('REQUEST_METHOD') == "POST") {

            $this->form_validation->set_rules('title', 'Título', 'required|min_length[10]|max_length[65]');
            $this->form_validation->set_rules('content', 'Contenido', 'required|min_length[10]');
            $this->form_validation->set_rules('description', 'Descripción', 'max_length[100]');
            $this->form_validation->set_rules('price', 'Precio', 'required');

            $data['title'] = $this->input->post("title");
            $data['content'] = $this->input->post("content");
            $data['description'] = $this->input->post("description");
            $data['price'] = $this->input->post("price");
            $data['url_clean'] = $this->input->post("url_clean");

            if ($this->form_validation->run()) {
                // nuestro form es valido

                $url_clean = $this->input->post("url_clean");

                if ($url_clean == "") {
                    $url_clean = clean_name($this->input->post("title"));
                }

                $save = array(
                    'price' => $this->input->post("price"),
                    'title' => $this->input->post("title"),
                    'content' => $this->input->post("content"),
                    'description' => $this->input->post("description"),
                    'product_category_id' => $this->input->post("category_id"),
                    'url_clean' => $url_clean
                );

                if ($product_id == null) {
                    $save['user_id'] = $this->session->userdata("id");
                    $product_id = $this->Product->insert($save);
                    $this->insert_product();
                } else {
                    $this->Product->update($product_id, $save);
                    $this->insert_product();
                }

                $product = $this->Product->find($product_id, null);

                //$this->upload($product_id, $this->input->post("title"));

                redirect("products/product_save/$product_id");
            }
        }

        $view['breadcrumb'] = breadcrumb_products("products");
        $view["body"] = $this->load->view("products/products/save", $data, TRUE);

        $this->parser->parse("products/template/body", $view);
    }

    public function image_delete() {
        
        $product_image = $this->Product_image->getByImageName(
                $this->input->post('image'));
        
        if(isset($product_image)){
            unlink("uploads/product/".$product_image->image);
            $this->Product_image->delete($product_image->product_image_id);
        }
    }

    /*
     * CRUD PARA LOS CATEGORY
     */

    public function category_list() {
//        $data["categories"] = $this->Category->findAll();
//        $view["body"] = $this->load->view("products/category/list", $data, TRUE);
        $crud = new grocery_CRUD();

        //if ($this->auth_data->auth_level == 6) {
            $crud->unset_add();
            $crud->unset_delete();
        //}

//        $crud->set_theme('datatables');
        $crud->set_table('product_categories');
        $crud->set_subject('Categoria');
        $crud->columns('product_category_id', 'name');

        $crud->callback_before_insert(array($this, 'category_iu_before_callback'));
        $crud->callback_before_update(array($this, 'category_iu_before_callback'));

        $crud->set_rules('name', 'Nombre', 'required|min_length[10]|max_length[100]');

        $crud->unset_jquery();
        $crud->unset_clone();
        $crud->unset_read();

        $output = $crud->render();
        $view["grocery_crud"] = json_encode($output);
        $view['breadcrumb'] = breadcrumb_products("categories");
        $view["title"] = "Categories";
        $this->parser->parse("products/template/body", $view);
    }

    function upload_image($product_id = null) {
        if (!isset($product_id)) {
            $this->output->set_header('HTTP/1.0 500 Internal Server Error');
            $this->output->set_header('HTTP/1.1 500 Internal Server Error');
            echo "Producto no definido";
            return;
        }

        $product = $this->Product->find($product_id);

        if (!isset($product)) {
            $this->output->set_header('HTTP/1.0 500 Internal Server Error');
            $this->output->set_header('HTTP/1.1 500 Internal Server Error');
            echo "Producto no definido";
            return;
        }

        $this->upload($product_id);
    }

    private function upload($product_id = null) {

        $image = "image";
        $name = time();

        // configuraciones de carga
        $config['upload_path'] = 'uploads/product';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 5000;
        $config['file_name'] = $name;
        $config['overwrite'] = TRUE;

        //cargamos la libreria
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($image)) {
            // se cargo la imagen
            // datos del upload
            $data = $this->upload->data();

            $save = array(
                'image' => $name . $data["file_ext"],
                'product_id' => $product_id
            );

            $this->Product_image->insert($save);

            $this->resize_image($data['full_path']);
        } else if (!empty($_FILES[$image]['name'])) {
            $this->output->set_header('HTTP/1.0 500 Internal Server Error');
            $this->output->set_header('HTTP/1.1 500 Internal Server Error');
            echo $this->upload->display_errors();
            return;
        }
    }

    function resize_image($path_image) {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $path_image;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 500;
        $config['height'] = 500;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();
    }

    /*     * *************
      Calback
     * */

    function category_iu_before_callback($product_array, $pk = null) {
        if ($product_array['url_clean'] == "") {
            $product_array['url_clean'] = clean_name($product_array["name"]);
        }

        return $product_array;
    }

    function user_before_insert_callback($product_array) {
        $product_array['passwd'] = $this->authentication->hash_passwd($product_array['passwd']);
        $product_array['user_id'] = $this->User->get_unused_id();
        $product_array['created_at'] = date('Y-m-d H:i:s');

        if ($this->auth_data->auth_level == 6 && $product_array['auth_level'] > 6) {
            $product_array['auth_level'] = 1;
        }

        return $product_array;
    }

    function user_after_upload_callback($uploader_response, $field_info, $files_to_upload) {
        $this->load->library('Image_moo');
        //Is only one file uploaded so it ok to use it with $uploader_response[0].
        $file_uploaded = $field_info->upload_path . '/' . $uploader_response[0]->name;
        $this->image_moo->load($file_uploaded)->resize(500, 500)->save($file_uploaded, true);

        return true;
    }

}
