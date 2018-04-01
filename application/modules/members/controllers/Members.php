<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends MY_Controller {


	function __construct() {
        parent::__construct();
		
	$this->load->language('members/members_msg');
	//$this->lang->load('members');
    }

	
	public function index()
	{
		$user = $this->ion_auth->user()->row();
		
		$data['title'] = 'Berichten pagina voor: <strong>'. $user->username .'</strong>';
		$data['comment'] = 'Hier komen alle berichten van de gebruiker';
		$this->template('list_users', $data);
	}	
	
	

		public function user_down_up()
		{
		if ($this->member->get_user_class() < UC_ADMINISTRATOR)
		{
		$this->session->set_flashdata('danger', 'Foutmelding...U ben niet bevoegd om deze pagina te bekijken.');
		redirect('members/details/'. $userid .'');	
		}
		
			$userid = $this->input->post('userid');
			if (!$userid)
			{
			$this->session->set_flashdata('danger', 'Foutmelding...geen gebruikers ID ontvangen.');
			redirect('members/details/'. $userid .'');	
			}

			$torrentid = $this->input->post('torrentid');
			if (!$torrentid)
			{
			$this->session->set_flashdata('danger', 'Foutmelding...geen torrent ID ontvangen.');
			redirect('members/details/'. $userid .'');	
			}

			$action = $this->input->post('action');
			if (!$action)
			{
			$this->session->set_flashdata('danger', 'Foutmelding...geen opdracht ontvangen.');
			redirect('members/details/'. $userid .'');	
			}

			
			$row = $this->db->query("SELECT * FROM users WHERE id=$userid")->row_array();
			
			if (!$row)
				site_error_message("Foutmelding", "Geen gebruiker gevonden.");

			$defs = $this->db->query("SELECT * FROM downup WHERE user=$userid AND torrent=$torrentid")->row_array();
			
			$add = rand(1000,1100);

			$downloaded = $defs['downloaded'];

			$upthis = $downloaded / 1000 * $add;

			$this->db->query("UPDATE downup SET uploaded = $upthis WHERE user=$userid AND torrent=$torrentid");

			$returnto = $this->input->post('returnto');
			
			//if (!$returnto)
			//{
			$this->session->set_flashdata('info', 'Torrent ratio is aangepast.');
			redirect($returnto);	
			//}else{
			//redirect();	
			//}
		}

		
	/*
	get the user details 
	
	*/
	
	public function details($id = NULL)
	{
		$this->load->model('member_model');
		$this->load->library('members');
		
		

		/* get the id of the user....if no id is given fetch items from current user: Decoder*/
		if($id)
		{
			$user = $this->ion_auth->user($id)->row();  // get user
		}else{
			$user = $this->ion_auth->user()->row();		// get current user
		}
		
		if(!$user)// could not find a user with this id......exit
		{
			redirect();
		}
		
		// set breadcrumbs
		$this->breadcrumb->append('Members', 'members');		
		$this->breadcrumb->append('Details', 'members/details');		
		$this->breadcrumb->append($user->username, 'members/details/'. $id.'');

		if ($user->warned == 'yes')
		{
		if ($user->warnedby > 0)
		$data['warned'] = "<div class='alert alert-danger'><h4>" . $user->username . " is gewaarschuwd door " . $this->member->get_username($user->warnedby) . ".</h4></div>";
		else
		$data['warned'] = "<div class='alert alert-danger'><h4>" . $user->username . " is gewaarschuwd door het systeem.</h4></div>";
		}

		if ($user->blocked == 'yes')
		{
		$block_text = "<div class='alert alert-danger'><h2>";
		$block_text .= "ACCOUNT IS GEBLOKKEERD OP: " . $this->convertdatum($user->blocked_date) . "<br>";
		$block_text .= "DOOR: " . $this->member->get_username($user->blocked_by) . "<br>";
		$block_text .= "REDEN: " . htmlspecialchars($user->blocked_reason) . "<br></h2></div>";
		$data['block_text'] = $block_text;
		}
		
	
		$data['ip_control'] = "";// set empty value for non sysop...
		
		if ($this->member->get_user_class() >= UC_BEHEERDER)
			{
			$ip_nummers 	= $this->db->where('userid', $user->id)->get('user_ip')->num_rows();
			//die($this->db->last_query());			

			$ip_users 		= $this->db->where('ip', $user->ip_address)->get('user_ip')->num_rows();
				
			
			$data['ip_control'] = "";
			if(isset($ip_nummers))
				{
				if ($ip_nummers > 1)
					{
					$data['ip_control'] .= "<div class='btn-group'>";
					$data['ip_control'] .= "<a class='btn btn-default' href='user_ip_overzicht.php?id=". $user->id ."'>" . $ip_nummers . "&nbsp;verschillende&nbsp;ip-nummers.</a>";

					if ($ip_users > 1)
						$data['ip_control'] .= "<a class='btn btn-default' href='user_ip_overzicht.php?ip=". $user->ip_address ."&return_id=". $user->id ."'>" . $ip_users . "&nbsp;gebruikers&nbsp;met&nbsp;dit&nbsp;ip</a>";
					else
						$data['ip_control'] .= "<a class='btn btn-default'  href='user_ip_overzicht.php?ip=". $user->ip_address ."&return_id=". $user->id ."'>" . $ip_users . "&nbsp;gebruiker&nbsp;met&nbsp;dit&nbsp;ip</a>";
						$data['ip_control'] .= "";
					}
				else
					{
					$data['ip_control'] .= "<div class='btn-group'>";
					$data['ip_control'] .= "<a class='btn btn-default' href='". base_url('moderator/user_ip_control/'. $user->id .'') ."'>" . $ip_nummers . "&nbsp;ip-nummer.</a>";

					if ($ip_users > 1)
						$data['ip_control'] .= "<a class='btn btn-default' href='user_ip_overzicht.php?ip=". $user->ip_address ."&return_id=". $user->id ."'>" . $ip_users . "&nbsp;gebruikers&nbsp;met&nbsp;dit&nbsp;ip</a>";
					else
						$data['ip_control'] .= "<a class='btn btn-default'  href='user_ip_overzicht.php?ip=". $user->ip_address ."&return_id=". $user->id ."'>" . $ip_users . "&nbsp;gebruiker&nbsp;met&nbsp;dit&nbsp;ip</a>";
					}
				$data['ip_control'] .= "</div><br /><br />";
				}
			}			
		
	
	if ($this->member->get_user_class() >= UC_BEHEERDER)
		{
		$dubbelip = '';
		$ip = $user->ip_address;
		$def = $this->db->query("SELECT id, username FROM users WHERE ip_address='$ip' AND ip_address!='000.000.000.000'");	
			
			if($def->num_rows() > 1) 
			{
			$data['dubbelip'] = $def;	
			}
		
		}
		
		// get the buttons for friend invite and modoptions
		$button_block 	= '';
		$button_mod 	= '';
		
		if ($this->session->userdata('user_id') <> $user->id)
			{
			$friend = $this->db->select('id')->from('friends')->where(array('userid' => $this->session->userdata('user_id'), 'friendid' => $id))->get()->num_rows();
			$block = $this->db->select('id')->from('blocks')->where(array('userid' => $this->session->userdata('user_id'), 'blockid' => $id))->get()->num_rows();

			//$button_block = "<table><tr>";
			if ($friend)
				{
					//$button_block .= "<td class=embedded><div align=center>";
					$button_block  = "<p><form method='post' action=". base_url('friends/delete') .">";
					//$button_block .= "<input type=hidden name=action value=delete>";
					$button_block .= "<input type=hidden name=sure value=1>";
					$button_block .= "<input type=hidden name=type value=friend>";
					$button_block .= "<input type=hidden name=targetid value=" . $user->id . ">";
					$button_block .= "<input type=submit class='btn btn-default btn-block' value='Verwijderen van vrienden'>";
					$button_block .= "</form></p>";
				}
			elseif($block)
				{
					//$button_block .= "<tr<td class=embedded><div align=center>";			
					$button_block .= "<p><form method=get action=". base_url('friends/delete') .">";
					//$button_block .= "<input type=hidden name=action value=delete>";
					$button_block .= "<input type=hidden name=type value=block>";
					$button_block .= "<input type=hidden name=sure value=1>";
					$button_block .= "<input type=hidden name=targetid value=" . $user['id'] . ">";
					$button_block .= "<input type=submit class='btn btn-default btn-block' value='Blokkering opheffen'>";
					$button_block .= "</form></p>";
				}
			else
				{
				//$button_block .= "<tr><td class=embedded><div align=center>";
				$button_block  = "<p><form method=post action=". base_url('members/add_friend') .">";
				//$button_block .= "<input type=hidden name=action value=add>";
				$button_block .= "<input type=hidden name=type value=friend>";
				$button_block .= "<input type=hidden name=targetid value=" . $user->id . ">";
				$button_block .= "<input type=submit class='btn btn-default btn-block' value='Toevoegen aan vrienden'>";
				$button_block .= "</form></p>";
				//$button_block .= "<tr><td class=embedded><div align=center>";			
				$button_block .= "<p><form method=post action=". base_url('friends/add') .">";
				//$button_block .= "<input type=hidden name=action value=add>";
				$button_block .= "<input type=hidden name=type value=block>";
				$button_block .= "<input type=hidden name=targetid value=" . $user->id . ">";
				$button_block .= "<input type=submit class='btn btn-default btn-block' value='Blokkeren'>";
				$button_block .= "</form></p>";
				}

			//$button_block .= "</tr></table>";
			}

		if($this->session->userdata('user_id') <> $user->id)
		{
		if ($this->member->get_user_class() >= UC_MODERATOR)
			{
			$button_mod = '<a class="btn btn-danger btn-block" href="'. base_url('moderator/users_modtask/'. $user->id .'') .'"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Moderator opties</a>';
			}			
		}		

			
		$data['button_block'] 	= $button_block;	
		$data['button_mod'] 	= $button_mod;	
		$data['class'] 			= $user->class ;
		
		if ($this->member->get_user_class() >= UC_MODERATOR && $user->class < $this->member->get_user_class())
		{
		$data['mod_comment'] = $this->member_model->mod_comment($user);
		}

		$res = $this->db->query("SELECT userid AS user,torrent,uploaded,downloaded FROM peers WHERE userid=$user->id AND seeder='no'");
		if ($res->num_rows() > 0){
		$data['user_torrent_leeching'] = $this->member_model->maketable($res);
		}else{
		$data['user_torrent_leeching'] = 'Geen actieve downloads op dit moment';	
		}
	
		$res = $this->db->query("SELECT userid AS user,torrent,uploaded,downloaded FROM peers WHERE userid='$user->id' AND seeder='yes'");

		if ($res->num_rows() > 0)
		{
		$data['user_torrent_seeding'] 	= $this->member_model->maketable_seeding($res);	
		}else{$data['user_torrent_seeding'] 	= 'Geen data...';}
		
	
		$res = $this->db->query("SELECT torrent, user, added, uploaded, downloaded FROM downloaded WHERE user='$user->id' ORDER BY added DESC");
		
		if ($res->num_rows() > 0)
		{
		$data['user_torrent_downloaded'] = $this->member_model->maketable_downloaded($res);	
		}else{
			$data['user_torrent_downloaded'] = 'Geen torrents gedownload.';
		}
		
		if($user->avatar)
		{
		$data['avatar_button'] 			= '<a class="btn btn-danger btn-block" href="#" rel="popover" data-popover-content="#myPopover">Avatar aanpassen</a>'; 
		}else{
		$data['avatar_button'] 			= '<a class="btn btn-success btn-block" href="#" rel="popover" data-popover-content="#myPopover">Avatar toevoegen</a>'; 
		}

		$data['user_torrent_table'] 	= $this->member_model->torrent_table_user($user->id);		
		$data['user_id'] 				= $user->id ; 
		$data['user_name'] 				= $user->username ; 
		$data['user_avatar'] 			= $this->member->get_user_avatar($user->id); 
		$data['user_email'] 			= $user->email ;		
		//$data['user_ip'] 				= $user->ip_address ;	
		$data['user_kliks'] 			= $user->kliks ;	
		$data['user_max_torrents'] 		= $user->maxtorrents ;	
		$data['user_ratio'] 			= $this->member->get_userratio($user->id) ;	
		$data['user_ip'] 				= $this->member_model->get_user_ip($user->ip_address, $user->id);	
		$data['user_added'] 			= $this->convertdatum(unix_to_human($user->created_on));	
		$data['user_last_login'] 		= $this->convertdatum(unix_to_human($user->last_login));	
		$data['user_rang'] 				= $this->member->get_user_class_name($user->class);
		$data['user_uploaded'] 			= byte_format($user->uploaded) ;		
		$data['user_downloaded'] 		= byte_format($user->downloaded) ;		
		$data['user_class'] 			= $this->session->userdata('class');
		$data['user_tor_comment'] 		= $this->db->where('user', $user->id)->get('comments')->num_rows();
		$data['user_forum_comment'] 	= $this->db->where('userid', $user->id)->get('posts')->num_rows();
		
		
		// all data collected.....push it to the view 
		$this->template('userdetails', $data);
	}




	public function add_friend()
	{
		$this->site_message('info','Werkt nog niet !! oprotten !!!@#');
		redirect();
	}	
	
	
		public function avatar_upload()
		{
			$user_id = $this->uri->segment(3);
			
			$config['upload_path']          = 'uploads/avatars';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['file_name']            = $user_id;
			$config['overwrite']            = TRUE;
			$config['max_size']             = 300;
			$config['max_width']            = 1000;
			$config['max_height']           = 1300;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload())
			{
			$this->session->set_flashdata('danger', $this->upload->display_errors());
			redirect('members/details/'. $user_id .'');
			}
			else
			{
				$img = $this->upload->data();
				//---- lets resize this image..
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'uploads/avatars/'. $img['file_name'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = FALSE;
				$config['width']         = 300;
				$config['height']       = 400;

				$this->load->library('image_lib', $config);

				if ( ! $this->image_lib->resize() )
				{
				
					$error = array('error' => $this->image_lib->diplay_errors(), 'id' => $id);

					$this->template('cover_upload', $error);				
				}
				else
				{
				$data = array('avatar' => $img['file_name']);
				//----	
				$this->db->where(array('id' => $user_id));
				$this->db->update('users', $data);
				
				$this->session->set_flashdata('info', 'Uw avatar is successvol geupload');
				redirect('members/details/'. $user_id .'', 'refresh');
				}
			}
		}
}






