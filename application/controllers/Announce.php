<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announce extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
		
	}


	public function index() 
	{
	
			$info_hash = strtolower(urlencode(bin2hex($this->input->get('info_hash')))) ;
			echo '<p>info hash: '.$info_hash.'</p>';
			echo '<p>peer ID: '.$this->input->get('peer_id').'</p>';
			echo '<p>Port: '. $this->input->get('port') .'</p>';
			echo '<p>Passkey: '. $this->input->get('passkey') .'</p>';
			echo '<p>Event: '. $this->input->get('event') .'</p>';
			echo '<p>Numwant: '. $this->input->get('numwant') .'</p>';
			echo '<p>Uploaded: '. $this->input->get('uploaded') .'</p>';
			echo '<p>downloaded: '. $this->input->get('downloaded') .'</p>';
			echo '<p>left: '. $this->input->get('left') .'</p>';
			echo '<p>corrupt: '. $this->input->get('corrupt') .'</p>';
			echo '<p>key: '. $this->input->get('key') .'</p>';
			echo '<p>compact: '. $this->input->get('compact') .'</p>';
			echo '<p>No peer ID: '. $this->input->get('no_peer_id') .'</p>';

			
		switch ($this->input->get('event'))
		  {
		case 'started':
			echo '<div style=" background: rgba(0, 255, 0, 0.6); padding: 20px;">Started</div>';
			break;
			
		case 'stopped':
			echo '<div style=" background: rgba(255, 0, 0, 0.6); padding: 20px;">Stopped</div>';
			break;
		
		case 'completed':
			echo '<div style=" background: rgba(0, 0, 255, 0.6); padding: 20px;">Completed</div>';
			break;
		default: 

			break;			
		  }	
			
	}



	

}
