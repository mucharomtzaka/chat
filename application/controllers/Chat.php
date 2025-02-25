<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('pusher_lib');
        $this->load->model(array('Chat_model','User_model'));
		if (!$this->session->userdata('logged_in')) {
			redirect('auth/login');
		}
    }

    public function send_message() {
        $sender_id = $this->session->userdata('user_id');
        $receiver_id = $this->input->post('receiver_id');
        $message = $this->input->post('message');

        $data = [
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'message' => $message,
			'created_at'  => date('Y-m-d H:i:s'),
			'is_read' => 0
        ];

        $this->Chat_model->save_message($data);

        $this->pusher_lib->trigger('private-chat-' . $receiver_id, 'new_message', $data);

        echo json_encode(['status' => 'success']);
    }

	public function get_messages() {
		$sender_id = $this->session->userdata('user_id');
		$receiver_id = $this->input->post('receiver_id');
	
		$messages = $this->Chat_model->get_messages($sender_id,$receiver_id);
	
		echo json_encode($messages);
	}

	public function get_unread_notifications() {
		$user_id = $this->session->userdata('user_id');
		$this->load->model('Chat_model');
		$unread_messages = $this->Chat_model->get_unread_count($user_id);
	
		echo json_encode($unread_messages);
	}
	
	public function mark_as_read() {
		$user_id = $this->session->userdata('user_id');
		$sender_id = $this->input->post('sender_id');
	
		$this->Chat_model->mark_read_chat($sender_id,$user_id);
	
		echo json_encode(['status' => 'success']);
	}
	

	public function check_session() {
		echo json_encode(['logged_in' => $this->session->userdata('logged_in')]);
	}

	public function index() {
		$data['users'] = $this->User_model->get_users($this->session->userdata('user_id'));
        $this->load->view('chat',$data);
    }
}
