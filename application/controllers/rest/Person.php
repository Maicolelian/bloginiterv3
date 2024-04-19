<?php

use Restserver\Libraries\REST_Controller;

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/Format.php';

class Person extends REST_Controller {

   /* use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }*/

    public function authenticate_get() {
        
        $name = $this->session->userdata("name") == null ? "" : $this->session->userdata("name");
        $id = $this->session->userdata("id") == null ? 0 : $this->session->userdata("id");
        
        $this->response(
                array(
                    "name" => $name,
                    "id" => $id
                )
        );
    }

}
