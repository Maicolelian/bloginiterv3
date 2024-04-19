<?php

class Request_store extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('Form_validation');
        $this->load->library('grocery_CRUD');

        $this->load->helper(array('form', 'Product_helper'));
        $this->load->helper('Breadcrumb_helper');

        $this->init_session_auto(6);
    }

    public function index() {
        redirect('request_store/request_list');
    }

    /*
     * CRUD PARA LOS Request
     */

    public function request_list() {
        $crud = new grocery_CRUD();

        if ($this->session->userdata("auth_level") == 6) {
            $crud->where('user_id', $this->session->userdata("id"));
        }

        $crud->set_table('requests');
        $crud->set_subject('Requets');
        $crud->columns('request_id', 'phone', 'location_id', 'user_id', 'created_at');

        $crud->unset_jquery();
        $crud->unset_add();
        $crud->unset_clone();
        $crud->unset_read();
        $crud->unset_edit();

        $crud->set_relation('user_id', 'users', 'name');
        $crud->set_relation('location_id', 'locations', 'name');

        $crud->add_action('Detalle', '', 'request_store/detail', 'edit-icon');

        $output = $crud->render();
        $view["grocery_crud"] = json_encode($output);
        $view["body"] = $this->load->view("request_store/request_list_header", NULL, TRUE);
        $view['breadcrumb'] = breadcrumb_products("request");
        $view["title"] = "Requests";
        $this->parser->parse("products/template/body", $view);
    }

    public function detail($request_id = null) {

        if (!isset($request_id))
            show_404();

        $request = $this->Request->find($request_id);

        if (!isset($request))
            show_404();

        $view_select_state = $this->load->view('request_store/select_state', array(
            'states' => $this->Request_state->findAll(),
            'request' => $request
                ), true);

        $view_traces_request = $this->load->view('request_store/traces_request', array(
            'traces' => $this->Request_trace->findByRequest($request_id),
            'request' => $request
                ), true);

        $view["title"] = "Pedido #" . $request_id;
        $view['body'] = $view_select_state . $view_traces_request . view_detail_request($request_id);
        $this->parser->parse("products/template/body", $view);
    }

    public function change_state_request($request_id = null, $request_state_id = null) {

        if (!isset($request_id))
            return;

        $request = $this->Request->find($request_id);

        if (!isset($request))
            return;

        if (!isset($request_state_id))
            return;

        $request_state = $this->Request_state->find($request_state_id);

        if (!isset($request_state))
            return;

        if ($request->request_state_id >= $request_state_id)
            return;

        $save = array(
            'request_state_id' => $request_state_id
        );

        $this->Request->update($request_id, $save);

        $save = array(
            'request_id' => $request_id,
            'request_state_id' => $request_state_id,
            'comment' => $this->input->post('comment')
        );

        $id = $this->Request_trace->insert($save);

        $trace = $this->Request_trace->find($id);

        $this->load->view('request_store/trace_request', array('t' => $trace));
    }

    public function sales_quantity() {

        $view["title"] = "Cantidad de ventas";

        $data['quantity'] = $this->Request->getByQuantity($this->input->get('begin'), $this->input->get('end'), $this->input->get('count'));
        $data['begin'] = $this->input->get('begin');
        $data['end'] = $this->input->get('end');
        $data['count'] = $this->input->get('count');

        $view['body'] = $this->load->view('request_store/sales_quantity', $data, TRUE);
        $this->parser->parse("products/template/body", $view);
    }

    public function sales_money() {

        $view["title"] = "Ventas";

        $data['total'] = $this->Request->getByMoney($this->input->get('begin'), $this->input->get('end'), $this->input->get('count'));
        $data['begin'] = $this->input->get('begin');
        $data['end'] = $this->input->get('end');
        $data['count'] = $this->input->get('count');

        $view['body'] = $this->load->view('request_store/sales_money', $data, TRUE);
        $this->parser->parse("products/template/body", $view);
    }

}
