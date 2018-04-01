<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Torrents extends MY_Controller {


		function __construct() 
		{
			parent::__construct();
			
			if (!$this->ion_auth->logged_in())
			{
				redirect('auth/login');
			}
			
			$this->load->language('torrents/torrent_msg');		

			$this->load->model('user_model');
			$this->load->model('categories/categories_model', 'category');
			$this->load->helper('benc');
		}	


		
	public function search()
	{
		$search = $this->input->get('searchquery');


		if (!(string)$search)
		{
		$this->session->set_flashdata('danger', 'Geen data om te verwerken........vul AUB iets in om te zoeken!');
		redirect('torrents');			  
		}

		
		$this->db->like('name', $search, 'both');
		$query = $this->db->get('torrents');
		
		
		$count = $query->num_rows();
		$data['count'] 	= $count;
		$data['search'] = $search;
		
		if($count > 0)
		{
			$data['results'] = $query;
			$this->template('search', $data);
		}else{
			
			$data['no_result'] = $search;
			$this->template('search', $data);
		}
		
	}
	
	/*
	Should we move this to a seperate module comments?
	*/
	
	public function add_comment()
	{
	
		$torrentid = $this->input->post('tid');
		
			if (!(int)$torrentid)
			{
			$this->session->set_flashdata('danger', sprintf($this->lang->line('comment:wrong_id'), $torrentid));
			redirect('torrents');			  
			}

			$text = trim($this->input->post('text'));
			if (!$text)
			{
			$this->session->set_flashdata('danger', sprintf($this->lang->line('comment:empty_no')));
			redirect('torrents/details/'.$torrentid.'');
			}

			$data = array(
				'user' 		=> $this->session->userdata('user_id'),
				'torrent' 	=> $torrentid,
				'added' 	=> get_date_time(),
				'text' 		=> $text,
				'ori_text' 	=> $text
				);
			
			$this->db->insert('comments', $data);
			$this->db->query('UPDATE torrents SET comments = comments + 1 WHERE id = '. $torrentid .'');

        $this->session->set_flashdata('success', sprintf($this->lang->line('comment:msg_success')));
        redirect('torrents/details/'. $torrentid.'#home');
	}		
	
	
	
	
	
	public function deletecomment($id)
	{
		if (!(int)$id)
			{
			$this->session->set_flashdata('danger', sprintf($this->lang->line('comment:wrong_id'), $id));
			redirect('torrents');			  
			}
			
		$torrentid = $this->uri->segment(4);	

		if(!$this->member->get_user_class() >= UC_MODERATOR)
		{
        $this->session->set_flashdata('danger', sprintf($this->lang->line('torrent:no_rights')));
        redirect('torrents');			
		}			

		$data = array('id' => $id);
		
		$this->db->delete('comments', $data);
		$this->db->query('UPDATE torrents SET comments = comments - 1 WHERE id = '. $torrentid .'');

		$this->session->set_flashdata('success', sprintf($this->lang->line('comment:msg_success_del')));
        redirect('torrents/details/'. $torrentid .'');
	}		
	
	
	
	
	
	
	
	public function index()
	{
		
		$this->breadcrumb->append('Torrents', 'torrents');
		
		$data = array();
		
		if($this->member->get_user_class() >= UC_UPLOADER)
		{
			$data['upload_button'] 		= '<a class="btn btn-warning" href="'. base_url('torrents/upload').'"><span class="glyphicon glyphicon-arrow-up aria-hidden="true"></span> Torrent uploaden</a>';
		}
		$data['total_torrents'] 		= $this->db->get('torrents')->num_rows();
		
		$this->template('index', $data);
		$this->db->query("UPDATE users SET last_browse = NOW() where id=".$this->session->userdata('user_id'));
	}	


	public function coverupload($id = NULL)
	{
		if(!$id){
        $this->session->set_flashdata('danger', sprintf($this->lang->line('torrent:cover_no_id')));
        redirect('torrents');
		}
		
		if(!$this->get_user_class() >= UC_UPLOADER)
		{
        $this->session->set_flashdata('danger', sprintf($this->lang->line('torrent:no_rights')));
        redirect('torrents');			
		}
		
		$data = array('error' => '', 'id' => $id);
		
		$this->template('cover_upload', $data);
	}	
	
	


	public function torrent_edit($id = NULL)
	{	
		if(!$id){
        $this->session->set_flashdata('danger', sprintf($this->lang->line('torrent:no_edit_id')));
        redirect('torrents');
		}
		
		add_css('summernote/summernote.css');
		add_js('summernote/summernote.min.js');
		add_js('summernote/plugin/summernote-ext-video.js');
		add_js('bootstrap-filestyle.min.js');		
		add_js('summernote/summer_start.js');
		$this->db->where(array('id' => $id));
		$data['row'] = $this->db->get('torrents')->row();
		
		$this->template('upload', $data);
	}
	

	public function take_edit($id = NULL)
	{
		if(!$id){
        $this->session->set_flashdata('danger', sprintf($this->lang->line('torrent:no_edit_id')));
        redirect('torrents');
		}
		
		$data = array(
		'name' => $this->input->post('name'),
		'category' => $this->input->post('category'),
		'descr' => $this->input->post('descr'),
		'ori_descr' => $this->input->post('descr')
		);
		
		$this->db->where(array('id' => $id));
		$this->db->update('torrents', $data);
		$this->session->set_flashdata('success', sprintf($this->lang->line('torrent:edit_success')));
 		redirect('torrents/details/'. $id .'');
	}
	
	
	
	
	/**
	*
	*@param id (int)
	**/
	public function cover_delete($id = NULL)
	{
		if(!$id){
        $this->session->set_flashdata('danger', sprintf($this->lang->line('cover:cant_delete')));
        redirect('torrents');
		}
		
		$row = $this->db->where(array('id' => $id))->get('torrents')->row();
		
		if($row)
		{
			
		$data = array(
		'cover' => '',
		'cover_thumb' => '');
		
		$this->db->where(array('id' => $id));
		$this->db->update('torrents', $data);
		
		unlink('uploads/covers/'. $row->cover .'');
		unlink('uploads/covers/'. $row->cover_thumb .'');
		
		$this->session->set_flashdata('success', sprintf($this->lang->line('cover:delete_success')));
		redirect('torrents/details/'. $id .'');
		}else{
		$this->session->set_flashdata('danger', sprintf($this->lang->line('cover:delete_failure')));
		redirect('torrents/details/'. $id .'');
		}
	}
	
	public function do_upload($id)
	{
		if(!(int)$id){
        $this->session->set_flashdata('danger', sprintf($this->lang->line('cover:upload_no_id')));
        redirect('torrents');
		}
		
			$config['upload_path']          = 'uploads/covers';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['file_name']            = $id;			
			$config['max_size']             = 300;
			$config['max_width']            = 1600;
			$config['max_height']           = 2200;

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload())
			{
					$error = array('error' => $this->upload->display_errors(), 'id' => $id);

					$this->template('cover_upload', $error);
			}
			else
			{
				$img = $this->upload->data();
				
				$config['image_library'] = 'gd2';
				$config['source_image'] = 'uploads/covers/'. $img['file_name'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = FALSE;
				$config['width']         = 130;
				$config['height']       = 200;

				$this->load->library('image_lib', $config);

				if ( ! $this->image_lib->resize() )
				{
				
					$error = array('error' => $this->image_lib->diplay_errors(), 'id' => $id);

					$this->template('cover_upload', $error);				
				}
				else
				{
				
				//$img = $this->image_lib->data();
				$data = array(
				'cover' => $img['file_name'],
				'cover_thumb' => $img['raw_name'].'_thumb'.$img['file_ext'],
				);
				
				$this->db->where(array('id' => $id));
				$this->db->update('torrents', $data);
				
				redirect('torrents/details/'. $id .'');				
				}
			}
	}

	public function browse()
	{
		
		/*$user = $this->data['curuser'];
		$this->breadcrumb->append('Torrent Overzicht', 'browse');
		$this->load->library('pagination');
		
		$config['base_url'] = ''. base_url().'/torrents/index';
		$config['total_rows'] = $this->db->get('torrents')->num_rows();
		$config['per_page'] = 5;
		$config['num_links'] = 20;
		
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

		$this->db->order_by('added', 'DESC');
		$data['torrent'] = $this->db->get('torrents', $config['per_page'], $this->uri->segment(3));*/

		$this->template('index');
		$this->db->query("UPDATE users SET last_browse = '".time()."' where id='".$this->session->userdata('user_id') ."'");

	} 

	public function details() {
		add_js('summernote/summer_start.js');
	
		$this->load->model('torrentmodel');	
		
		$id = $this->uri->segment(3);
		
		if(!(int)$id)
		{
		redirect('torrents');	
		}

		//$query = $this->db->query("SELECT * FROM torrents WHERE id = $id LIMIT 1");

		$query = $this->db->query("SELECT torrents.seeders, 
						   torrents.banned, 
						   torrents.leechers, 
						   torrents.info_hash, 
						   torrents.filename, 
						   
						   LENGTH(torrents.nfo) AS nfosz, 
 
						   torrents.numratings, 
						   torrents.last_action, 
						   torrents.name, 
						   IF(torrents.numratings < 0, NULL, ROUND(torrents.ratingsum / torrents.numratings, 1)) AS rating, 
						   torrents.owner, 
						   torrents.save_as, 
						   torrents.descr, 
						   torrents.visible, 
						   torrents.size, 
						   torrents.added, 
						   torrents.views, 
						   torrents.hits, 
						   torrents.times_completed, 
						   torrents.id, 
						   torrents.type, 
						   torrents.numfiles, 
						   torrents.cover, 
						   torrents.cover_by, 
						   categories.name AS cat_name, 
						   users.username 
						   FROM torrents 
						   LEFT JOIN categories 
						   ON torrents.category = categories.id 
						   LEFT JOIN users 
						   ON torrents.owner = users.id 
						   WHERE torrents.id = $id");

		
		if($query->num_rows() > 0)
		{
			$torrent 						= $query->row();
			$data['row'] 					= $query->row();
			
			$this->breadcrumb->append('Torrents', 'torrents');
			$this->breadcrumb->append('Details', 'torrents/details/'. $torrent->id .'');
			$this->breadcrumb->append($torrent->name);

			$data['torrent_title'] 			= $torrent->name;
			//$data['end_page'] 				= '';
			$data['torrent_id'] 			= $torrent->id;
			$data['seeders'] 				= number_format($torrent->seeders);		
			$data['times_completed'] 		= number_format($torrent->times_completed); 
			
			$data['download_button']	 	 = '<p>';
			$data['download_button']	 	.= '<a href="'. base_url('torrents/download/'. $torrent->id .'').'" class="btn btn-primary btn-block">';
			$data['download_button']	 	.= '<span class="glyphicon glyphicon-glyphicon glyphicon-download-alt"></span>'; 
			$data['download_button']	 	.= sprintf($this->lang->line('button:download'));
			$data['download_button']	 	.= '</a>';
			$data['download_button']	 	.= '</p>';
			
			if($this->member->get_user_class() >= UC_MODERATOR || $this->session->userdata('user_id') == $torrent->owner)
			{ 	
			$data['torrent_options'] 	= '<button class="btn btn-info" type="button" data-toggle="collapse" data-target="#torrentoptions" aria-expanded="false" aria-controls="torrentoptions">Torrent options</button>';
			}
			
			$data['torrent_table'] 		= '<button class="btn btn-default" type="button" data-toggle="collapse" data-target="#torrenttable" aria-expanded="false" aria-controls="torrenttable">Torrent Information</button>';

			// these options go in.......
			$data['torrent_control'] 		= '<a class="btn btn-info btn-block" href="'. base_url('torrents/control/'. $torrent->id .'').'"><span class="glyphicon glyphicon-glyphicon glyphicon-search"></span> '. sprintf($this->lang->line('button:check_button')) .'</a>';
			$data['torrent_edit'] 			= '<a class="btn btn-default btn-block" href="'. base_url('torrents/torrent_edit/'. $torrent->id .'').'"><span class="glyphicon glyphicon-glyphicon glyphicon-edit"></span> '. sprintf($this->lang->line('button:edit_button')) .'</a>';
			$data['torrent_mass_message'] 	= '<a class="btn btn-warning btn-block" href="'. base_url('torrents/torrent_mass_message/'. $torrent->id .'').'"><span class="glyphicon glyphicon-glyphicon glyphicon-envelope"></span> '. sprintf($this->lang->line('button:mass_pm_button')) .'</a>';
			//$data['torrent_delete'] 		= '<a class="btn btn-danger btn-block" href="'. base_url('torrents/torrent_delete/'. $torrent->id .'').'"><span class="glyphicon glyphicon-glyphicon glyphicon-remove"></span> '. sprintf($this->lang->line('button:delete_button')) .'</a>';
			$data['torrent_delete'] 		= '<button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modal-delete-torrent"> '. sprintf($this->lang->line('button:delete_button')) .' </button>';
			// end options .......		
			
			$data['leechers'] 				= number_format($torrent->leechers); 
			//$data['leechers'] 				= number_format($torrent->leechers); 
			//$data['added'] 					= $torrent->added; 
			$data['added'] 					= str_replace(" ","&nbsp;",$this->convertdatum($torrent->added));
			$data['description'] 			= $torrent->descr; 
			$data['get_peer_info'] 			= $this->torrentmodel->get_peer_info($torrent->id); 
			$data['get_file_info'] 			= $this->torrentmodel->get_file_info($torrent->id, $torrent->size); // save extra query to add torrent filesize: Decoder
			$data['get_completed_info'] 	= $this->torrentmodel->get_completed_info($torrent->id); 
			$data['get_comments'] 			= $this->torrentmodel->get_comments($torrent->id); 
			$data['get_comments_form'] 		= $this->torrentmodel->get_comments_form($torrent->id, $torrent->name); 
			$data['get_comments_total'] 	= $this->torrentmodel->get_comments_total($torrent->id); 
			
			if($torrent->cover){
			$data['cover'] = '<img class="thumbnail img-responsive" src="'. base_url('uploads/covers/'. $torrent->cover .'').'">';
				if($this->member->get_user_class() >= UC_MODERATOR || $this->session->userdata('user_id') == $torrent->owner)
				{ 
				$data['cover_button'] = '<p><a class="btn btn-danger btn-block" href="'. base_url('torrents/cover_delete/'. $torrent->id .'').'">'. sprintf($this->lang->line('button:delete_cover')) .'</a></p>';
				}
			}
			else{
			$data['cover'] = '<img class="thumbnail img-responsive" src="http://placehold.it/400x500" align="top" />';
				if($this->member->get_user_class() >= UC_MODERATOR || $this->session->userdata('user_id') == $torrent->owner)
				{ 
				$data['cover_button'] 		= '<p><button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#cover">'. sprintf($this->lang->line('button:add_cover')) .'</button></p>';
				}
			}
			$this->template('details', $data);			
		}
		else{
			$this->session->set_flashdata('danger', sprintf($this->lang->line('torrent:no_id_no_torrent')));
			redirect('torrents');			
		}
	}

    public function category() {
		
		$data['title'] = 'categorie pagina';
		
		$data['comment'] = 'Hier komen alle torrent in een betreffende categorie';
		
		$this->template('container', $data);
		
        }

	
	
	
	
	
	public function  upload()
	{
		if (!$this->member->get_user_class() >= UC_UPLOADER)
		{
			$this->session->set_flashdata('danger', sprintf($this->lang->line('torrent:no_rights')));
			redirect();
		}
		
		add_css('summernote/summernote.css');
		
		add_js('summernote/summernote.min.js');
		add_js('summernote/plugin/summernote-ext-video.js');
		add_js('bootstrap-filestyle.min.js');
		
		$data['categories'] = $this->db->select('*')
                        ->from('categories')
                        ->order_by('sort', 'asc')
                        ->get()
                        ->result();
						
		$data['title'] = 'Torrent Uploaden';
		$data['comment'] = '';
		$this->template('upload', $data);
	}

		public function is_valid_id($id)
		{
		  return is_numeric($id) && ($id > 0) && (floor($id) == $id);
		}
	
		
		
		
		
		
		public function takeupload()
		{
			//$user = $this->data['curuser'];
			$user = $this->member->get_user();
			$this->load->model('torrentmodel');
			$response = $this->torrentmodel->upload_torrent('userfile');
			$error = '';
			if($error)
			{
			echo 'error';
			}
		}
		
		
		
		
	
		public function download($id) 
		{
			
			$user = $this->data['curuser'];
			$announce_url = $this->config->item('announce_url');
			$id = (int) $id;

			if (! $id ){
			$this->session->set_flashdata('danger', sprintf($this->lang->line('torrent:no_id_no_torrent')));
			redirect('torrents');
			}
		
			$row = $this->db->query('SELECT name, filename FROM torrents WHERE id = '.$id)->row();

			$file = 'uploads/torrents/'.$id.'.torrent';
			
			if (!$row || !is_file($file) || !is_readable($file))
			{
			$this->session->set_flashdata('danger', sprintf($this->lang->line('torrent:no_id_no_torrent')));
			redirect('torrents');
			}
			
			$data = array(
				'hits' => 'hits + 1'
			);

			$this->db->where('id', $id);
			$this->db->update('torrents', $data);
			
			$fn = 'uploads/torrents/'.$id.'.torrent';
			
			$dict = bdec_file($fn, filesize($fn));

			$dict['value']['announce']['value'] = ''. $announce_url .'?passkey='. $user->passkey.'';
			
			$dict['value']['announce']['string'] = strlen($dict['value']['announce']['value']).':'.$dict['value']['announce']['value'];
			
			$dict['value']['announce']['strlen'] = strlen($dict['value']['announce']['string']);
			
			header('Content-Disposition: attachment; filename="'.$row->filename.'"');
			header('Content-Type: application/x-bittorrent');
			
			echo benc($dict);
		}
	
	public function torrent_delete($id)
	{
		
	$row = $this->db->query("SELECT * FROM torrents WHERE id = $id ")->row_array();
	if (!$row)
		die();

		
		
		if ($this->session->userdata('user_id') != $row["owner"] && $this->member->get_user_class() < UC_MODERATOR)
		{
			$this->session->set_flashdata('danger', 'Error...you are not the owner of this torrent!');
			redirect('torrents/details/'.$id.'');
		}

		$rt = 0 + $this->input->post('reasontype');

		if (!is_int($rt) || $rt < 1 || $rt > 5)
		{
			$this->session->set_flashdata('danger', 'Ongeldige reden: $rt.');
			redirect('torrents/details/'.$id.'');
		}

		$reason = $this->input->post('reason');

		if ($rt == 1)
			$reasonstr = "Dood: geen delers/ontvangers meer";
		elseif ($rt == 2)
			$reasonstr = "Dubbel" . ($reason[0] ? (": " . trim($reason[0])) : "!");
		elseif ($rt == 3)
			$reasonstr = "Niet werkende uitgave" . ($reason[1] ? (": " . trim($reason[1])) : "!");
		elseif ($rt == 4)
		{
			if (!$reason[2])
			{
			$this->session->set_flashdata('danger', 'Verwijderen mislukt! Omschrijf de regel die is overtreden.');
			redirect('torrents/details/'.$id.'');
			}
			//site_error_message("Verwijderen mislukt!", "Omschrijf de regel die is overtreden.");
		  $reasonstr = "Overtreding van de regels: " . trim($reason[2]);
		}
		else
		{
			if (!$reason[3])
			{
			$this->session->set_flashdata('danger', 'Verwijderen mislukt! Geef een reden waarom deze torrent verwijderd dient te worden.');
			redirect('torrents/details/'.$id.'');
			}
		  $reasonstr = trim($reason[3]);
		}

		$filename = $row['filename'];

	//deletetorrent($id,$filename);

	//write_log("Torrent $id ($row[name]) is verwijderd door $CURUSER[username] ($reasonstr)\n");
	
	

	

	if($this->input->post('correction')){
	
	// perform ratio correction here if is set:
	// TODO create a template for this message.
	
	$message = "Hallo,\n\n";
	$message .= "De torrent " . $row['name'] . " is verwijderd van ".$this->config->item('site_name').", omdat deze niet goed bleek te zijn.\n\n";
	$message .= "Sorry dat dit is gebeurd, we hopen dat uw volgende download wel goed zal gaan.\n\n";
	$message .= "Om uw ratio te compenseren is er " . byte_format($row['size']) . " bij uw totale upload toegevoegd.\n\n";
	$message .= "Met vriendelijk groet,\n\nonzesite";
	$message = $this->db->escape($message);
	$added = $this->db->escape(get_date_time());
	$sender = 0;

	$def = $this->db->query("SELECT * FROM downup WHERE torrent=$id");
	foreach ($def->result_array() as $defs)
		{
		$userid = $defs['user'];

		$upthis = $row["size"];
		
		$this->db->query("UPDATE users SET uploaded = uploaded + $upthis WHERE id=$userid");
		
		$title = 'De torrent ' . $row['name'] . ' is verwijderd';
		$this->db->query("INSERT INTO messages (sender, receiver, subject, msg, added) VALUES ($sender, $userid, $title, $message, $added)");
		}
		

	$this->session->set_flashdata('info', sprintf($this->lang->line('torrent:final_deleted_correction')));
	}else{
	$this->session->set_flashdata('info', sprintf($this->lang->line('torrent:final_deleted')));
	}
	
	$this->db->where('id', $id);
	$this->db->delete('torrents');
	
	redirect('torrents');	
	}
	
	
	
	
	
	
	
	
	

	public function torrent_mass_message($id)
	{
		
	//if (get_user_class() < UC_UPLOADER)
	//	site_error_message("Foutmelding", "Deze pagina is alleen voor de uploaders en hoger.");

	$torrentid = 0 + $id;

	if (!$torrentid)
		site_error_message("Foutmelding", "Geen torrent ID ontvangen.");

	$row = $this->db->query("SELECT * FROM torrents WHERE id=$torrentid")->row_array();
	$data['row'] = $row;
	//$row = mysql_fetch_array($res);
	if (!$row)
		site_error_message("Foutmelding", "Geen torrent gevonden met dit ID.");

	$action = $this->input->post('action');

	if ($action == "sendmessage")
		{
		//if (get_user_class() < UC_UPLOADER)
		//	site_error_message("Foutmelding", "Alleen uploaders of hoger kunnen deze versturen.");
		$message = $this->input->post('message');
		
		if (!$message)
			site_error_message("Foutmelding", "Geen bericht ontvangen.");
		
		
		$added 			= get_date_time();
		$message 		= $message;
		$title			= 'Torrent bericht: '. $row['name'] .' ';
		$sendermsg 		= $this->session->userdata('user_id');
		$send_count 	= 0;
		
		$res = $this->db->query("SELECT * FROM downup WHERE torrent=$torrentid");
		foreach($res->result_array() as $row)
			{
			$user_id = $row['user'];
			$res2 = $this->db->query("SELECT id FROM users WHERE id=$user_id");
			$row2 = $res2->result_array();
			if ($row2)
				{
				$send_count = $send_count + 1;
				$data = array(
					'subject' => $title,
					'sender' => $sendermsg,
					'receiver' => $user_id,
					'msg' => $message,
					'added' => $added
				);
				$this->db->insert('messages', $data);
				//$this->db->query("INSERT INTO messages (subject, sender, receiver, msg, added) VALUES ($title, $sendermsg, $user_id, $message, $added)");
				}
			}
			//$send_to = $send_to;
			
			$data = array(
				'sender' => $sendermsg,
				'aantal' => $send_count,
				'msg' 	=> $message,
				'added' => $added,
				'torrent_id' => $torrentid
			);
			
			$this->db->insert('massa_bericht_torrents', $data);
			
			$this->session->set_flashdata('info', 'Berichten zijn verzonden.');
			redirect('torrents/details/'.$torrentid.'');
		}

	$data['sjabloon'] = "Hallo,\n\n\n\nMet vriendelijke groet,\n\n" . $this->session->userdata['username'] . "\n\nDit bericht wordt aan iedereen verzonden die de torrent '".$row['name']."'\naan het ontvangen is of ontvangen heeft.";
	
	$data['torrentid'] = $torrentid;
	$this->template('template/mass_message', $data);	
	}
}















