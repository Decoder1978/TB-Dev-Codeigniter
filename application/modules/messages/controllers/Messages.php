<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Messages extends MY_Controller {


	function __construct() {
        parent::__construct();
		
		$this->load->language('messages/messages_msg');
	}
	
	
	public function index($id = NULL, $location = 'in')
	{
		
		$this->load->model('message_model');
		
		$data['username'] = 'naam aanpassen in controller!!';
		$data['get_messages'] = $this->message_model->get_messages();
		
		$this->breadcrumb->append('Messages', 'messages');
		
		$this->template('overview', $data);
	}
	

	private function get_sjabloon()
	{
		$this->load->model('message_model');

		return $this->message_model->get_sjabloon();
	}
	
	
	public function details($id)
	{
		
		if(!$id)
		{
			redirect('messages');
		}
		
		$this->load->model('message_model');
		
		$query = $this->message_model->get_messages_user($id);
		$row = $query->row();

		$query1 = $this->db->query('SELECT * FROM users WHERE id='.$row->sender.'');
		$sender = $query1->row();
		
		//set up a flag if message is new
		if ($row->unread == 'yes')
				{
				$data['new_message'] = '<span class="text-danger">Nieuw bericht</span>';
				// update message here if read
				}else{
				$data['new_message'] = '';
				}
		
		// create replay en delete buttons 
		if ($row->sender != 0)
			{
				/*if($sender->avatar)
				{
				$data['avatar'] = "<img class='img-responsive thumbnail' src=".$sender['avatar'].">";
				}else{
				$data['avatar'] = "<img class='img-responsive thumbnail' src='http://placehold.it/165x220' alt='Avatar'>";
				}*/
				
			$data['avatar'] = $this->member->get_user_avatar($sender->id);
				
			$message_link = "sendmessage.php?receiver=".$row->sender."&replyto=".$row->id."";
			$button_state = "";
			$data['btn_replay']	= "<a class='btn btn-primary' href='$message_link' $button_state><i class='icon-pencil  icon-white'></i> Beandwoorden</a>";
			$data['ratio'] = $this->member->get_userratio($row->sender);
			$data['uploaded'] = byte_format($sender->uploaded);
			$data['downloaded'] = byte_format($sender->downloaded);
			$data['username'] = $sender->username;
			$data['subject'] = $row->subject;
			$data['message'] = $row->msg;
			$data['forward'] = 'nog niks';		
			$data['added'] = $this->convertdatum($row->added);
			}
			else
			{

			$data['avatar'] = "<img class='img-responsive thumbnail' src='http://placehold.it/165x220' alt='Avatar'>";

			$message_link = "#";
			$button_state = "disabled";
			$data['btn_replay']	= "<a class='btn btn-primary' href='$message_link' $button_state><i class='icon-lock'></i> Beandwoorden</a>";
			$data['ratio'] = 'geen ratio';
			$data['uploaded'] = '0';
			$data['downloaded'] = '0';
			$data['username'] = '**SYSTEEM**';
			$data['subject'] = $row->subject;
			$data['message'] = $row->msg;
			$data['forward'] = 'nog niks';		
			$data['added'] = $this->convertdatum($row->added);
			}
		$this->breadcrumb->append('Messages', 'messages');
		$this->db->query("UPDATE messages SET unread = 'no' WHERE id = $id");
		$this->template('message_details', $data);
	}
	
	
	
	public function sendmessage()
	{
		$name = $this->uri->segment(3);
		
		$res = $this->db->where(array('username' => $name))->get('users')->row();
		$data['receiver'] = $this->db->where(array('username' => $name))->get('users')->row();
		
		if(!$res)
		{
		$this->session->set_flashdata('danger', 'Wij hebben niemand gevonden die de naam <strong>'. $name .'</strong> Gebruikt');
 		redirect();			
		}
		
		add_css('summernote/summernote.css');
		add_js('summernote/summernote.min.js');	
		
		$this->breadcrumb->append('Messages', 'messages');
        $this->breadcrumb->append('sendmessage');
        $this->breadcrumb->append($name);
		
		$this->template('sendmessage', $data);
		
	}	
	
	
	public function takemessage()
	{
	    
	$sender_id = ($this->input->post('sender') == 'system' ? 0 : $this->session->userdata('user_id'));
	$from_is = $this->input->post('pmees');
	$msg = $this->input->post('msg');
	//die($msg);
	
	
	$data = array(
		'sender' => $sender_id,
		'receiver' => $this->input->post('receiver'),
		'added' => get_date_time(),
		'msg' => $msg,
		'subject' => $this->input->post('subject')
	);
	$this->db->insert('messages', $data);
	redirect($this->input->post('returnto'));
	}
	
	public function test()
	{
		add_css('test.css');
		$this->load->view('test');
	}
	
}
