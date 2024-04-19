<?php

class App extends MY_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->load->database();

		$this->load->library('parser');
		$this->load->library("Form_validation");

		$this->load->helper("url");
		$this->load->helper("form");
		$this->load->helper("text");

		$this->load->helper("Post_helper");
		$this->load->helper("Date_helper");

		$this->load->model("Post");
		$this->load->model("Category");
	}

	public function login()
	{
		if ($this->uri->uri_string() == 'app/login')
			show_404();

		$view["body"]  = $this->load->view("app/login", NULL, TRUE);
		$this->parser->parse("admin/template/body_format_2", $view);
	}

	public function ajax_attempt_login()
	{
		if( $this->input->is_ajax_request() )
		{
			// Allow this page to be an accepted login page
			$this->config->set_item('allowed_pages_for_login', ['app/ajax_attempt_login'] );

			// Make sure we aren't redirecting after a successful login
			$this->authentication->redirect_after_login = FALSE;

			// Do the login attempt
			$this->auth_data = $this->authentication->user_status( 0 );

			// Set user variables if successful login
			if( $this->auth_data )
				$this->_set_user_variables();

			// Call the post auth hook
			$this->post_auth_hook();

			// Login attempt was successful
			if( $this->auth_data )
			{
				echo json_encode([
					'status'   => 1,
					'user_id'  => $this->auth_user_id,
					'username' => $this->auth_username,
					'level'    => $this->auth_level,
					'role'     => $this->auth_role,
					'email'    => $this->auth_email
				]);
			}

			// Login attempt not successful
			else
			{
				$this->tokens->name = config_item('login_token_name');

				$on_hold = ( 
					$this->authentication->on_hold === TRUE OR 
					$this->authentication->current_hold_status()
				)
				? 1 : 0;

				echo json_encode([
					'status'  => 0,
					'count'   => $this->authentication->login_errors_count,
					'on_hold' => $on_hold, 
					'token'   => $this->tokens->token()
				]);
			}
		}

		// Show 404 if not AJAX
		else
		{
			show_404();
		}
	}

	public function logout()
	{
		$this->authentication->logout();

		// Set redirect protocol
		$redirect_protocol = USE_SSL ? 'https' : NULL;

		redirect( site_url( LOGIN_PAGE . '?' . AUTH_LOGOUT_PARAM . '=1', $redirect_protocol ) );
	}

	public function register()
	{
		if ($this->uri->uri_string() == 'app/register')
			show_404();

		$data["name"] = $data["surname"] = $data["username"] = $data["email"] = "";

		if ($this->input->server('REQUEST_METHOD') == "POST")
		{
			$this->form_validation->set_rules('username', 'usuario', 'max_length[100]|is_unique[' . config_item('user_table') . '.username]|required');
			$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|is_unique[' . config_item('user_table') . '.email]');
			$this->form_validation->set_rules('passwd','contraseña','min_length[8]|trim|required|max_length[72]|callback_validate_passwd');
			$this->form_validation->set_rules('name','nombre','max_length[100]|required');
			$this->form_validation->set_rules('surname','apellido','max_length[100]|required');
			$this->form_validation->set_rules('is_unique','El %s ya esta registrado');

			$data['name']     = $this->input->post("name");
			$data['surname']  = $this->input->post("surname");
			$data['username'] = $this->input->post("username");
			$data['email']    = $this->input->post("email");

			if($this->form_validation->run()) {
				$save = array(
					'name'       => $this->input->post("name"),
					'surname'     => $this->input->post("surname"),
					'username' => $this->input->post("username"),
					'email'      => $this->input->post("email"),
					'passwd' => $this->authentication->hash_passwd($this->input->post("passwd")),
					'user_id' => $this->User->get_unused_id(),
					'created_at'   => date('Y-m-d H:i:s'),
					'auth_level'   => 1
				);
				
				$this->User->insert($save);

				// TODO enviar email

				$this->session->set_flashdata('text', 'Registro exitoso');
				$this->session->set_flashdata('text', 'success');
				redirect("/login");
			}
		}
		$view["body"]  = $this->load->view("app/register", $data, TRUE);
		$this->parser->parse("admin/template/body_format_2", $view);
	}

	/* Perfil */

	public function profile()
	{
		$this->load->helper("Breadcrumb_helper");

		$data['user'] = $this->User->find($this->session->userdata('id'));

		$this->form_validation->set_rules('old_pass','Contraseña actual','required|callback_same_passwd');
		$this->form_validation->set_rules('new_pass','Contraseña nueva','required|min_length[8]|max_length[72]|callback_validate_passwd');
		$this->form_validation->set_rules('new_pass','Contraseña nueva','required|matches[new_pass]');

		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			if($this->form_validation->run()) {
				// formulario valido

				$save = array(
					'passwd' => $this->input->post('new_pass')
				);

				$this->User->update($this->session->userdata('id'), $save);
				$this->session->sess_destroy();
				$this->session->set_flashdata('text', 'Contraseña actualizada');
            	$this->session->set_flashdata('type', 'error');
				redirect('/login');
			}
		}
		
		$view["body"]  = $this->load->view("app/profile", $data, TRUE);
		$view["title"]  = 'Perfil';
		$view["breadcrumb"]  = breadcrumb_admin("profile");
		$this->parser->parse("admin/template/body", $view);

	}

}