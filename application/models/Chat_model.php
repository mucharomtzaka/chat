<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model {
    public function save_message($data) {
        return $this->db->insert('chat_messages', $data);
    }

    public function get_messages($user_id, $receiver_id) {
        $this->db->select('chat_messages.*, 
                       sender.username AS sender_name, 
                       receiver.username AS receiver_name');
		$this->db->from('chat_messages');
		$this->db->join('users AS sender', 'chat_messages.sender_id = sender.id', 'left');
		$this->db->join('users AS receiver', 'chat_messages.receiver_id = receiver.id', 'left');
		$this->db->where("(chat_messages.sender_id = $user_id AND chat_messages.receiver_id = $receiver_id) 
						OR (chat_messages.sender_id = $receiver_id AND chat_messages.receiver_id = $user_id)");
		$this->db->order_by('chat_messages.created_at', 'ASC');

		return $this->db->get()->result();
    }

	public function get_unread_count($user_id) {
		$this->db->select('sender_id, COUNT(*) as unread_count');
		$this->db->where('receiver_id', $user_id);
		$this->db->where('is_read', 0);
		$this->db->group_by('sender_id');
	
		return $this->db->get('chat_messages')->result();
	}

	public function mark_read_chat($sender_id,$user_id){
		$this->db->where('sender_id', $sender_id);
		$this->db->where('receiver_id', $user_id);
		$this->db->where('is_read', 0);
		return $this->db->update('chat_messages', ['is_read' => 1]);
	}

	public function clear_chat($user_id, $receiver_id) {
		$this->db->where("(sender_id = $user_id AND receiver_id = $receiver_id) OR (sender_id = $receiver_id AND receiver_id = $user_id)");
		$this->db->delete('chat_messages'); // Replace with your table name
	}
	
}
