<?php defined('BASEPATH') or exit('No direct script access allowed');

class Message_model extends MY_Model {
	
	public function get_messages($id = NULL, $location = 'in') 
	{
		if(isset($id))
		{
			$messages = $this->db->select('*')
							->from('messages')
							->where('receiver', $id)
							->where('location', $location)
							->order_by('added', 'DESC')
							->get();
							
			if($messages->num_rows() > 0 )
			{
			return  $messages;
			}else{
				return NULL;
			}
		}else{
			$messages = $this->db->select('*')
							->from('messages')
							->where('receiver', $this->session->userdata('user_id'))
							->where('location', $location)
							->order_by('added', 'DESC')
							->get();
							
			if($messages->num_rows() > 0 )
			{
			return  $messages;
			}else{
				return NULL;
			}
			
		}
	}
	
	public function get_sjabloon()
	{
		return $this->db->query('SELECT * FROM messages_sjabloon WHERE userid='. $this->session->userdata('user_id') .'');
	}
	
	public function get_messages_user($id)
	{
		return $this->db->select('*')
						->from('messages')
						->where('id', $id)
						->get();
	}
	
}































