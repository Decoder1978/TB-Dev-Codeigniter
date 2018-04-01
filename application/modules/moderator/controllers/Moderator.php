<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Moderator extends MY_Controller 
	{
	
		function __construct() 
		{
			parent::__construct();
			
			if (!$this->ion_auth->logged_in())
			{
				redirect('auth/login');
			}
			
			if (!$this->member->get_user_class() >= UC_MODERATOR)
			{
			$this->session->set_flashdata('danger', '<center><h2>Wegwezen '. $this->member->get_username($this->session->userdata('user_id')) .' !!@</h2>Deze pagina is alleen toegankelijk voor Moderators of hoger!!</center>');
			redirect();	
			}
			
			$this->load->language('moderator/moderator_msg');
		}
		
		
		
		
		public function index()
		{
		$this->template('index');
		}
		
		
		
		public function uploaders()
		{
			$action = '';
			
			$action = $this->input->post('action');

			if ($action == "uploader_status")
				{
				$user_id = (int)$_POST['user_id'];
				$res = mysql_query("SELECT * FROM users WHERE id=" . $user_id) or sqlerr(__FILE__, __LINE__);	
				$row = mysql_fetch_array($res);
				if (!$row)
					site_error_message("Foutmelding", "Geen gebruiker gevonden met ID=".htmlspecialchars($user_id).".");
					
				$message = "Hallo " . get_username($user_id) . "\n\n";
				$message .= "Aangezien u als uploader de laatste drie weken niets heeft geplaatst, is uw de mogelijkheid om te uploaden op ".$SITE_NAME." ontnomen.\n\n";
				$message .= "Wij danken u natuurlijk voor de uploads die u in het verleden geplaatst heeft.\n\n";
				$message .= "En deze regel is voor iedere uploader die drie weken niets geplaatst heeft, dus natuurlijk niet alleen voor u.\n\n";
				$message .= "Indien u wenst weer te gaan uploaden dan kunt u altijd contact opnemen met een Administrator.\n\n";
				$message .= "Met vriendelijke groet,\n";
				$message .= get_username($CURUSER['id']);
				$message =	sqlesc($message);

				$to = $user_id;
				$from = $CURUSER['id'];
				$added = sqlesc(get_date_time());
				if ($row['donor'] == "yes")
					$new_class = 2;
				else
					$new_class = 1;

				$descr = "Uploader status ontnomen vanwege inactiviteit van meer dan 3 weken. Door: " . get_username($CURUSER['id']);
				$modcomment = sqlesc(convertdatum(get_date_time()) . " - " . $descr . "\n" . $row['modcomment']);

				mysql_query("UPDATE users SET class = $new_class, modcomment = $modcomment WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
				mysql_query("INSERT INTO messages (sender, receiver, msg, added) VALUES ($from, $to, $message, $added)") or sqlerr(__FILE__, __LINE__);
				}
				
			$data['res'] = $this->db->query("SELECT * FROM users WHERE class=3 ORDER BY class DESC");	

		$this->template('template/uploaders_overview', $data);
		}		
		
		public function checkpasskey()
		{
			$passkey = $this->input->post('passkey');

			$data = array();
			
			if ($passkey)
				{
					
					$row = $this->db->where('passkey', $passkey)->get('users')->row_array();
					//$row = $this->db->query("SELECT * FROM users WHERE passkey='$passkey'")->row_array();	

					if (!$row)
					{
						$this->session->set_flashdata('danger', '<h4>Foutmelding</h4>Geen gebruiker gevonden met deze passkey: '. $passkey.'.');
						redirect('moderator/checkpasskey');	
					}
					else
					{
						$data['passkey'] 	= $passkey;
						$data['name'] 		= $this->member->get_username($row['id']);
						$data['result'] 	= TRUE;
					}
				}
			$this->template('template/checkpasskey', $data);
		}
		
		
		public function site_message()
		{
		$action = '';	
		
		$action = $this->input->post('action');

		if ($action == 'onderhoud_aan')
		{
			$this->db->query("UPDATE site_message SET active = 'yes'");
		}

		if ($action == 'onderhoud_uit')
		{
			$this->db->query("UPDATE site_message SET active = 'no'");			
		}

		if ($action == 'onderhoud_tekst')
			{
			$service_text = $this->input->post('service_text');
			
			if (!$service_text)
			{
			$this->session->set_flashdata('danger', '<h4>Foutmelding</h4>Niets ontvangen om te verwerken.!');
			redirect('moderator/site_message');					
			}
				
			
			$data = array(
			'text' => $service_text,
			'added' => time()
			);
			$this->db->update('site_message', $data);
			}
			
			$data['SV'] = $this->db->get('site_message')->row_array();

		$this->template('site-message', $data);
		}
		
		
		
		
		
		
		
		public function staff_page()
		{
		$this->template('template/staff_page');
		}
		
		
		
		public function testpage()
		{
				$this->template('template/testpage');
		}
		
		
		public function new_page()
		{
			
			$data['pagetitle']			= 'Nieuwe pagina toevoegen';
			$data['pagedescription']	= 'Pagina voor moderators en of hoger toevoegen.';
			
			
			//$data['select'] = "<tr><td><strong>Selecteer een class:</strong></td><td>";
			$classes = "";

			$maxclass = 7;

			for ($i = 0; $i <= $maxclass; ++$i)
			$classes .= "<option value=$i" . ($this->session->userdata('class') == $i ? " selected" : "") . ">" . $this->get_user_class_name($i) . "";

			$data['select'] = '<select class="form-control" name=class>'. $classes .'</select>';
			 
			
			$this->template('new_page', $data);
		}

		
		
		
		
		
		
		public function add_new_page()
		{
			
			if ($this->member->get_user_class() < UC_BEHEERDER)
			{
			$this->session->set_flashdata('danger', 'Hackpoging gedetecteerd !');
			redirect('moderator');			
			}


			$query = array(
			
				'name'		=> $this->input->post('name'),
				'url'		=> $this->input->post('url'),
				'img'		=> $this->input->post('img'),
				'class'		=> $this->input->post('class')
			
			);

			$this->db->insert('admin_pages', $query);
			$this->session->set_flashdata('info', 'Pagina successvol toegevoegd !');
		redirect('moderator');	
		}		
		
	
		public function edit_new_page()
		{
			
			$this->template('edit_new_page');
		}
		
		
		
		
		/* 
		TODO: recreate a totaly different warning system....this one sucks big time....
		TODO: Need to add message templates here....could be static or from database
		*/
		
		public function modtask() 
		{

		$userid 		= 0 + $this->input->post('userid');
		$warned 		= $this->input->post('warned');
		$warnlength 	= 0 + $this->input->post('warnlength');
		$warnreason 	= $this->input->post('warnreason');
		$warnpm 		= $this->input->post('warnpm');
		$donor 			= $this->input->post('donor');
	  
		$res = $this->db->query("SELECT * FROM users WHERE id=$userid");
		$row = $res->row_array();
		

		if ($row['donor'] == 'yes' && $warnlength > 0)
			site_error_message("Foutmelding", "Donateurs kunnen niet gewaarschuwd worden.");
	  
		if ($warnreason == 0)
			{
			$warnreason = "Hallo " . $this->member->get_username($userid) . ",\n\n";
			$warnreason .= "U heeft een waarschuwing gehad voor 'Pakken en wegwezen' (Hit & Run).\n";
			$warnreason .= "Hetgeen inhoud dat u een torrent heeft gedownload en niet de moeite heeft genomen om te blijven delen voor andere gebruikers.\n";
			$warnreason .= "Bij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\n";
			$warnreason .= "Tevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\n";
			$warnreason .= "Met vriendelijke groet,\n";
			$warnreason .= "Staff van Veranderen\n";
			$warnmod = "Pakken en wegwezen.";
			}
		if ($warnreason == 1)
			{
			$warnreason = "Hallo " . $this->member->get_username($userid) . ",\n\n";
			$warnreason .= "U heeft een waarschuwing gehad voor 'Lage Ratio' (Hit & Run).\n";
			$warnreason .= "Hetgeen inhoud dat u een meer Gb ontvangt als wenst te delen aan andere gebruikers.\n";
			$warnreason .= "Ratio is de deling van hetgeen u heeft verzonden door hetgeen u heeft ontvangen.\n";
			$warnreason .= "U kunt dit verbeteren doormiddel van te blijven delen (seeden) na het downloaden totdat uw ratio weer goed is.\n";
			$warnreason .= "Een lage ratio betekend ook dat u minder torrents tergelijkertijd mag gebruiken.\n";
			$warnreason .= "Bij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\n";
			$warnreason .= "Tevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\n";
			$warnreason .= "Met vriendelijke groet,\n";
			$warnreason .= "Staff van Veranderen\n";
			$warnmod = "Lage ratio.";
			}
		if ($warnreason == 2)
			{
			$warnreason = "Hallo " . get_username($userid) . ",\n\n";
			$warnreason .= "U heeft een waarschuwing gehad voor 'Overseeden'.\n";
			$warnreason .= "Hetgeen betekend dat u blijt delen (seeden) op een of meerdere torrents waardoor u het voor de gebruikers met.\n";
			$warnreason .= "een slechte ratio moeilijk of onmogelijk wordt hun ratio te verbeteren.\n";
			$warnreason .= "Bij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\n";
			$warnreason .= "Tevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\n";
			$warnreason .= "Met vriendelijke groet,\n";
			$warnreason .= "Staff van ".$SITE_NAME."\n";
			$warnmod = "Overseeden.";
			}
		if ($warnreason == 3)
			{
			$warnreason = "Hallo " . get_username($userid) . ",\n\n";
			$warnreason .= "U heeft een waarschuwing gehad voor 'Gb verschil'.\n";
			$warnreason .= "Hetgeen betekend dat u meer wenst te ontvangen als te delen aan andere gebruikers.\n";
			$warnreason .= "Dit staat los van het door u opgebouwde ratio.\n";
			$warnreason .= "Ratio is de deling van hetgeen u heeft verzonden door hetgeen u heeft ontvangen.\n";
			$warnreason .= "Bij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\n";
			$warnreason .= "Tevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\n";
			$warnreason .= "Met vriendelijke groet,\n";
			$warnreason .= "Staff van ".$SITE_NAME."\n";
			$warnmod = "Gb verschil.";
			}
		if ($warnreason == 4)
			{
			$warnreason = "Hallo " . get_username($userid) . ",\n\n";
			$warnreason .= "U heeft een waarschuwing gehad voor 'Gedrag'.\n";
			$warnreason .= "Deze algemene waarschuwing is voor taal gebruik tegen staff leden en of andere gebruikers in torrentcommentaar, forum, pm berichten of de chat.\n";
			$warnreason .= "Bij geen zichtbare verbetering wordt u uit ons systeem verwijderd.\n";
			$warnreason .= "Tevens houd dit in dat u een rode balk in beeld zal blijven zien totdat de waarschuwing verwijderd wordt.\n\n";
			$warnreason .= "Met vriendelijke groet,\n";
			$warnreason .= "Staff van ".$SITE_NAME."\n";
			$warnmod = "Gedrag.";
			}

		$modcomment = $this->input->post('modcomment');//$_POST["modcomment"];

		if (!$this->is_valid_id($userid))
			site_error_message("Foutmelding", "Foutief gebruiker ID.");

		$arr = $this->db->query("SELECT warned, username, class, uploaded, downloaded FROM users WHERE id=$userid")->row_array();

		$curclass 		= $arr["class"];
		$curwarned 		= $arr["warned"];
		$uploaded 		= $arr["uploaded"];
		$downloaded 	= $arr["downloaded"];
		$dur 			= '';
		$senderid 		= '0';

		//if ($curclass >= $this->member->get_user_class())
			//die('oeps ff aanpassen in moderator regel 166');

		//die('hierzo');
		
		if ($warned && $curwarned != $warned)
			{
				
			$updateset[] = "warned = '". $warned ."' ";
			$updateset[] = "warneduntil = '0000-00-00 00:00:00'";
			
			if ($warned == 'no')
				{
				$modcomment 	= $this->convertdatum(get_date_time()) . " - Waarschuwing verwijderd door " . $this->session->userdata('username') . ".\nMomentopname: Ontvangen: " . byte_format($downloaded) . " - Verzonden: " . byte_format($uploaded) . " - Ratio: "	 . $this->member->get_ratio($userid) . "\n\n". $modcomment;
				$msg 			= "Uw waarschuwing is verwijderd door " . $this->session->userdata('username') . ".";
				$subject 		= 'Uw waarschuwing is verwijderd.'; 
				$logmsg 		= "De waarschuwing van <a href=userdetails.php?id=" . $userid . ">" . $this->member->get_username($userid) . "</a> is verwijderd door <a href=userdetails.php?id=" . $this->session->userdata('user_id') . ">" . $this->session->userdata('username') . "</a>.";
				}
				
			$added = get_date_time();
			$this->db->query("INSERT INTO messages (sender, receiver, subject, msg, added) VALUES (0, '$userid', '$subject', '$msg', '$added')");
			$updateset[] = "warnedby = '0'";
			$updateset[] = "warned = 'no'";
			//write_log_warning($logmsg);
			}
		elseif ($warnlength)
			{
				
			$warneduntil 	= get_date_time(time() + $warnlength * 3600);
			$dur 			= $warnlength . " uur";
			$modcomment 	= $this->convertdatum(date("Y-m-d H:i:s")) . " - Gewaarschuwd voor $dur door " . $this->session->userdata('username') .	 ".\nReden waarschuwing: $warnmod $warnpm \nMomentopname: Ontvangen: " . byte_format($downloaded) . " - Verzonden: " . byte_format($uploaded) . " - Ratio: "  . $this->member->get_ratio($userid) . "\n\n" . $modcomment;
			$logmsg 		= "<a href=userdetails.php?id=" . $userid . ">" . $this->member->get_username($userid) . "</a> is gewaarschuwd door <a href=userdetails.php?id=" . $this->session->userdata('user_id') . ">" . $this->session->userdata('username') . "</a> voor " . $warnmod;
			$subject 		= 'U heeft een waarschuwing gekregen!';
			$msg 			= "$warnreason $warnpm";
			$updateset[] 	= "warneduntil = '$warneduntil'";
			$updateset[] 	= "warnedby = '" . $this->session->userdata('user_id')."'";
			
			
			//write_log_warning($logmsg);
			$added 			= get_date_time();
			$senderid 		= $this->session->userdata('user_id');
			
			$data = array(
			'sender' => $senderid,
			'receiver' => $userid,
			'subject' => $subject,
			'msg' => $msg,
			'added' => $added
			);
			$this->db->insert('messages', $data);
			$updateset[] = "warned = 'yes'";
			}

		$updateset[] = "donor = '" . $donor ."' ";

		$updateset[] = "modcomment = '" . $modcomment ."' ";

		$uploaded = $uploaded;
		$downloaded = $downloaded;
		$dur = $dur;
		$warnmod = $warnmod;
		
		$data = array(
		'userid' => $userid,
		'warned_by' => $senderid,
		'warned_for'=> $warnmod,
		'warned_time' => $dur,
		'date' => date('Y-m-d H:i:s'),
		'uploaded' => $uploaded,
		'downloaded' => $downloaded
		);
		
		$this->db->insert('warnings', $data);
		
		//mysql_query("INSERT INTO warnings (userid, warned_by, warned_for, warned_time, date, uploaded, downloaded) VALUES ($userid, $senderid, $warnmod, $dur, NOW(), $uploaded, $downloaded)");

		$this->db->query("UPDATE users SET	" . implode(", ", $updateset) . " WHERE id=$userid", FALSE);

		$returnto = $this->input->post('returnto');//$_POST["returnto"];
		redirect($returnto);
		}

		
		
		
		
		
		
		
		
		
		
		/*public function add()
		{
			$data = array(
				'user_id' => $this->input->post('user_id'),
				'username' => $this->input->post('username'),
				'content' => $this->input->post('content'),
			);
			$this->db->insert('shoutbox', $data);
			
			$this->session->set_flashdata('info', 'bericht toegevoegd !');
			redirect('shoutbox');
		}*/

		
		
		
		
		
		
		
		
		
		public function users_modtask($id = NULL)
		{
			$this->template('users_modtask');
		}

		
		
		
		
		
		
		public function edit($id)
		{
		## something ?	
		}

		
		
		
		
		
		
		
		public function user_donate_edit_week()
		{
		echo 'nog maken.... ga terug';		
		}	
		
		
		
		
		public function user_delete()
		{
		echo 'nog maken.... ga terug';		
		}	
		
		
		
		
		public function user_inbox_spy()
		{
		echo 'nog maken.... ga terug';		
		}	
		
		
		
		
		
		public function user_outbox_spy()
		{
		echo 'nog maken.... ga terug';		
		}	
		
		
		
		
		public function user_gb_bonus()
		{
		echo 'nog maken.... ga terug';		
		}	
		
		
		
		
		public function user_gb_edit()
		{
		echo 'nog maken.... ga terug';		
		}	
		
		
		
		
		
		public function user_change_name()
		{
		echo 'nog maken.... ga terug';		
		}	
		
		
		
		
		public function user_edit_email()
		{
		echo 'nog maken.... ga terug';		
		}	

		
		
		
		
		
		public function user_edit_password()
		{
		echo 'nog maken.... ga terug';		
		}	
		
		
		
		
		
		
		
		
		
		
		public function user_delete_warning()
		{
		echo 'nog maken.... ga terug';		
		}	
			
		
		
		
		
		
		public function user_class_edit()
		{
		sleep(1); 
		header('HTTP 400 Bad Request', true, 400);
        echo "This field is required!";		}	
		
		
		
		
		
		public function user_ip_ban()
		{
		echo 'nog maken.... ga terug';		
		}
		
		
		
		
		
		public function user_account_on()
		{
		echo 'nog maken.... ga terug';		
		}	
		
		
		
		/**
		* Disable the useraccount.
		*
		* @param int $id The id of the user to disable, he or she wont be able to download anymore.
		*/
		public function user_account_off()
		{
		echo 'nog maken.... ga terug';		
		}


		public function alter_maxtorrents()
		{
		echo 'nog maken.... ga terug';	
		}
		
		

		public function block_account()
		{
		echo 'nog maken.... ga terug';	
		}
		
		

		public function flush_torrents()
		{
		echo 'nog maken.... ga terug';	
		}		
		


		public function user_country()
		{
		echo 'nog maken.... ga terug';	
		}		
		
		
		
		
		
		public function user_avatar($id)
		{
		$this->db->query("UPDATE users SET avatar = '' WHERE id = $id");
		
		$username 	= $this->member->get_username($id);
		$sender 	= $this->member->get_username();// without id gives us the current user.
			
		$data = array(
				'sender' 	=> $this->session->userdata('user_id'),
				'receiver' 	=> $id,
				'added' 	=> get_date_time(),
				'msg' 		=> sprintf($this->lang->line('avatar_msg'),$username , $sender),
				'subject' 	=> $this->lang->line('avatar_subject')
			);
			$this->db->insert('messages', $data);
		
		$this->session->set_flashdata('info', 'Avatar verwijderd !');
		redirect('moderator/users_modtask/'.$id.'');
		}	
		
		
		
		public function del_peer_user($id)
		{
		echo 'nog maken.... ga terug';	
		}
		
	
	
	
	
	
	
	
	
		public function peerlist()
		{
			
			$this->load->library('pagination');
			
			$config['base_url'] = base_url('moderator/peerlist');
			$config['total_rows'] = $this->db->get('peers')->num_rows();
			$config['per_page'] = 20;
			$config['num_links'] = 10;
			
			//-------------------------------- bootstrap --------------
					//config for bootstrap pagination class integration
			$config['full_tag_open'] = '<ul class="pagination pagination-sm">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['prev_link'] = '&laquo';
			$config['prev_tag_open'] = '<li class="prev">';
			$config['prev_tag_close'] = '</li>';
			$config['next_link'] = '&raquo';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			
			$this->pagination->initialize($config);

			$this->db->order_by('started', 'DESC');
			$data['peerlist'] = $this->db->get('peers', $config['per_page'], $this->uri->segment(3));

			$this->template('peerlist', $data);
		}


		
		public function flush_ghost($id = NULL)
		{
			if ($this->member->get_user_class() >= UC_MODERATOR) 
			{  
				$announce_interval = 2800;
				$deadtime = time() - floor($announce_interval * 1.3);
				$this->db->query("DELETE FROM peers WHERE last_action < FROM_UNIXTIME('$deadtime')");
				$effected = $this->db->affected_rows();
				
				
				$res = $this->db->query("SELECT * FROM torrents");	
				foreach ($res->result_array() as $row)
					{
					$torrent_id		= $row['id'];
					$count_seeder	= $this->db->where('torrent', $torrent_id)->where('seeder', 'yes')->get('peers')->num_rows();
					$this->db->query("UPDATE torrents SET seeders = $count_seeder WHERE id = $torrent_id");
					}

			if($effected)
			{
			$this->session->set_flashdata('success', "$effected ghost torrent " . ($effected ? 's' : '') . 'zijn succes vol verwijdert.');
			}else{
			$this->session->set_flashdata('danger', 'Er zijn geen ghost torrents verwijderd !');
			}
			redirect('moderator'); 
			}
			
		}
	
	}
