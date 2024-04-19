<?php

class Errores extends MY_Controller {

    public function logs() {
        log_message('error', 'Some variable did not contain a value.');
        log_message('debug', 'Some variable was correctly set');
        log_message('info', 'The purpose of some variable is to provide some value.');
    }

    public function show404() {
        redirect("/errores/error404");
       // show_404('', FALSE);
    }

    public function error404() {
        $this->output->set_status_header('404');
        $this->load->view('custom/error_404');
    }
    
    public function error500(){
        show_error("Mensaje de error",501,"Titulo de nuestro error");
    }

}
