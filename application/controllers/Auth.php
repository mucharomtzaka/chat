<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function register() {
        

        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
        } else {
            $data = [
                'username' => $this->input->post('username'),
                'email'    => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT)
            ];
            $this->User_model->register($data);
            echo json_encode(['status' => 'success', 'message' => 'Registration successful!']);
        }
    }

	public function login_view() {
        $this->load->view('auth/login');
    }

	public function register_view() {
		$this->load->view('auth/register');
	}

    public function login() {

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'message' => validation_errors()]);
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->User_model->get_user_by_email($email);

            if ($user && password_verify($password, $user->password)) {
                $this->session->set_userdata([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'logged_in' => TRUE
                ]);
                echo json_encode(['status' => 'success', 'message' => 'Login successful!', 'user' => $user]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
            }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login_view');
    }
}
