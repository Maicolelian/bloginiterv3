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

	
    /* recuperacion credenciales */

    /**
     * User recovery form
     */
    public function recover() {

        /// If IP or posted email is on hold, display message
        if ($on_hold = $this->authentication->current_hold_status(TRUE)) {
            $view_data['disabled'] = 1;
        } else {
            // If the form post looks good
            if ($this->tokens->match && $this->input->post('email')) {
                if ($user_data = $this->User->get_recovery_data($this->input->post('email'))) {
                    // Check if user is banned
                    if ($user_data->banned == '1') {
                        // Log an error if banned
                        $this->authentication->log_error($this->input->post('email', TRUE));

                        // Show special message for banned user
                        $view_data['banned'] = 1;
                    } else {
                        /**
                         * Use the authentication libraries salt generator for a random string
                         * that will be hashed and stored as the password recovery key.
                         * Method is called 4 times for a 88 character string, and then
                         * trimmed to 72 characters
                         */
                        $recovery_code = substr($this->authentication->random_salt()
                                . $this->authentication->random_salt()
                                . $this->authentication->random_salt()
                                . $this->authentication->random_salt(), 0, 72);

                        // Update user record with recovery code and time
                        $this->User->update_user_raw_data(
                                $user_data->user_id, [
                            'passwd_recovery_code' => $this->authentication->hash_passwd($recovery_code),
                            'passwd_recovery_date' => date('Y-m-d H:i:s')
                                ]
                        );

                        // Set the link protocol
                        $link_protocol = USE_SSL ? 'https' : NULL;

                        // Set URI of link
                        $link_uri = 'app/recovery_verification/' . $user_data->user_id . '/' . $recovery_code;

                        $view_data['special_link'] = anchor(
                                site_url($link_uri, $link_protocol), site_url($link_uri, $link_protocol), 'target ="_blank"'
                        );

                        $this->emails->recover_account($link_uri, $this->input->post('email'));

                        $view_data['confirmation'] = 1;
                    }
                }

                // There was no match, log an error, and display a message
                else {
                    // Log the error
                    $this->authentication->log_error($this->input->post('email', TRUE));

                    $view_data['no_match'] = 1;
                }
            }
        }

        $view['body'] = $this->load->view("app/recover_form", ( isset($view_data) ) ? $view_data : '', TRUE);
        $this->parser->parse("admin/template/body_format_2", $view);
    }

    // --------------------------------------------------------------

    /**
     * Verification of a user by email for recovery
     * 
     * @param  int     the user ID
     * @param  string  the passwd recovery code
     */
    public function recovery_verification($user_id = '', $recovery_code = '') {
        /// If IP is on hold, display message
        if ($on_hold = $this->authentication->current_hold_status(TRUE)) {
            $view_data['disabled'] = 1;
        } else {

            if (
            /**
             * Make sure that $user_id is a number and less 
             * than or equal to 10 characters long
             */
                    is_numeric($user_id) && strlen($user_id) <= 10 &&
                    /**
                     * Make sure that $recovery code is exactly 72 characters long
                     */
                    strlen($recovery_code) == 72 &&
                    /**
                     * Try to get a hashed password recovery 
                     * code and user salt for the user.
                     */
                    $recovery_data = $this->User->get_recovery_verification_data($user_id)) {
                /**
                 * Check that the recovery code from the 
                 * email matches the hashed recovery code.
                 */
                if ($recovery_data->passwd_recovery_code == $this->authentication->check_passwd($recovery_data->passwd_recovery_code, $recovery_code)) {
                    $view_data['user_id'] = $user_id;
                    $view_data['username'] = $recovery_data->username;
                    $view_data['recovery_code'] = $recovery_data->passwd_recovery_code;
                }

                // Link is bad so show message
                else {
                    $view_data['recovery_error'] = 1;

                    // Log an error
                    $this->authentication->log_error('');
                }
            }

            // Link is bad so show message
            else {
                $view_data['recovery_error'] = 1;

                // Log an error
                $this->authentication->log_error('');
            }

            /**
             * If form submission is attempting to change password 
             */
            if ($this->tokens->match) {
                $this->User->recovery_password_change();
            }
        }

        $view['body'] = $this->load->view("app/choose_password_form", ( isset($view_data) ) ? $view_data : '', TRUE);
        $this->parser->parse("admin/template/body_format_2", $view);
    }

    /* Upload Perfil */

    public function load_avatar() {

        $this->avatar_upload();
        $this->session->set_flashdata('type', 'success');
        $this->session->set_flashdata('text', 'Avatar cambiado con exito.');
        redirect('/app/profile');
    }

    /* Subida del avatar */

    private function avatar_upload() {

        $id = $this->session->userdata('id');

        $image = 'image';
        $config['upload_path'] = 'uploads/user/';
        $config['file_name'] = 'imagen_' . $id;
        $config['allowed_types'] = "jpg|jpeg|png";
        $config['overwrite'] = TRUE;

        $this->load->library('upload', $config);

        // ocurrio un error
        if (!$this->upload->do_upload($image)) {
            $this->session->set_flashdata('type', 'danger');
            $this->session->set_flashdata('text', $this->upload->display_errors());
            return;
        }

        // informacion hacerca de la subida
        $data = $this->upload->data();
        $save = array('avatar' => 'imagen_' . $id . $data['file_ext']);
        // actualizo la url
        $this->User->update($id, $save);
        $this->session->set_userdata('avatar', $save['avatar']);
        $this->resize_avatar($data['full_path'], $save['avatar']);
    }

    private function resize_avatar($ruta, $nombre) {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $ruta;
        $config['new_image'] = 'uploads/avatar/user/' . $nombre;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 300;
        $config['height'] = 300;

        $this->load->library('image_lib', $config);

        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
    }

}