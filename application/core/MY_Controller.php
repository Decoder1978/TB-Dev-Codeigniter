<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."third_party/MX/Controller.php";


class MY_Controller extends MX_Controller
{
	
	public function __construct() 
	{

		$this->breadcrumb->prepend('<span class="glyphicon glyphicon-home"></span>');

        if ($this->_logged_in()) {
            $logged_in = true;

            //load library if user logged in
            $this->load->library('ion_auth');
        } else {
            $logged_in = false;
        }

		
		//TODO: get rid of this crap as soon as posible
        $this->data = array(
            'curuser' 		=> ($logged_in ? $this->ion_auth->user()->row() : FALSE),
            'logged_in' 	=> $logged_in,
			'uploader_up' 	=> ($logged_in ? $this->ion_auth->in_group(array('uploader','moderators', 'admin', 'beheerder', 'owner')) : FALSE),			
			'mod_up' 		=> ($logged_in ? $this->ion_auth->in_group(array('moderators', 'admin', 'beheerder', 'owner')) : FALSE),			
			'admin_up' 		=> ($logged_in ? $this->ion_auth->in_group(array('admin', 'beheerder', 'owner')) : FALSE),			
			'op_up' 		=> ($logged_in ? $this->ion_auth->in_group(array('beheerder', 'owner')) : FALSE)
        );

        $this->load->vars($this->data);
		//$this->secure();
		//$this->output->enable_profiler(TRUE);
		if ($this->_logged_in())
		{
		$this->site_ip_check($this->session->userdata('user_id'));
		$user_lang = $this->db->query("SELECT language FROM users WHERE id=".$this->session->userdata('user_id')."")->row_array();
		$this->config->set_item('language', $user_lang['language']);
		}
	}
	
	
	
	
	
	public function site_ip_check($id)
	{
	$site_ip = $this->getip();
	
	$this->db->where('userid', $id);
	$this->db->where('ip', $site_ip);
	$query = $this->db->get('user_ip');
	$row = $query->result_array();

	if (!$row)
		{
		$added = get_date_time();
		$site_ip = $site_ip;
		
		$data = array(
		'userid' => $id,
		'ip' => $site_ip,
		'added' => $added,
		'last_seen' => $added
		);
		
		$this->db->insert('user_ip', $data);
		}
	else
		{
		$id = $row[0]['id'];
		$added = get_date_time();
		$this->db->query("UPDATE user_ip SET last_seen = now() WHERE id='$id'");
		}
	}
	
		public function secure()// this function makes use of our new database table admin_pages...
			{			//to secure our pages in a new way...so we wont have to look if privilegess are set correctly 'Decoder'
			$url = $this->uri->segment(2);
			$res = $this->db->query("SELECT * FROM admin_pages WHERE url='$url'");
			$row = $res->row_array();
			if ($this->member->get_user_class() < $row['class'])
			{
			redirect();	
			}	
		}


	public function getip()
		{
		global $_SERVER;

		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			{
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
		else
			{
			$ip = $_SERVER['REMOTE_ADDR'];
			}
		return $ip;
		}
	
	private function _logged_in() {
        $this->load->library('session');
        $this->load->model('ion_auth_model');
        $this->ion_auth_model->trigger_events('logged_in');

        return (bool) $this->session->userdata('identity');
    }
	
		function convertdatum($datum,$tijd="") {
		if (substr($datum,5,1) == "0")
			$month = substr($datum,6,1);
		else
			$month = substr($datum,5,2);
		if (substr($datum,8,1) == "0")
			$day = substr($datum,9,1);
		else
			$day = substr($datum,8,2);
		$year = substr($datum,0,4);
		if (!$tijd == "no")
			$time = "  om " . substr($datum,11,8);
		else
			$time = "";
		if ($month == "1") return $day . " januari " . $year . $time;
		if ($month == "2") return $day . " februari " . $year . $time;
		if ($month == "3") return $day . " maart " . $year . $time;
		if ($month == "4") return $day . " april " . $year . $time;
		if ($month == "5") return $day . " mei " . $year . $time;
		if ($month == "6") return $day . " juni " . $year . $time;
		if ($month == "7") return $day . " juli " . $year . $time;
		if ($month == "8") return $day . " augustus " . $year . $time;
		if ($month == "9") return $day . " september " . $year . $time;
		if ($month == "10") return $day . " oktober " . $year . $time;
		if ($month == "11") return $day . " november " . $year . $time;
		if ($month == "12") return $day . " december " . $year . $time;
	}	
	
	function is_valid_id($id)
	{
	  return is_numeric($id) && ($id > 0) && (floor($id) == $id);
	}		
		
	
	
	
	
	
	
	
	public function template($html, $data = FALSE)
	{
		
		//echo $_SERVER['REQUEST_URI'] ;
		$this->db->query("UPDATE users SET last_page = ". $this->db->escape(str_replace("/","",$_SERVER['REQUEST_URI'] ))." WHERE id='". $this->session->userdata('user_id')."'");
		if ($this->member->get_user_class() >= UC_MODERATOR)
			{
			$res_hits = $this->db->query("SELECT * FROM hits WHERE user_id=".$this->session->userdata('user_id')." AND page=".$this->db->escape($_SERVER['REQUEST_URI']));
			$row_hits = $res_hits->row_array();
			if ($row_hits)		
				$this->db->query("UPDATE hits set kliks=kliks+1 WHERE id=".$row_hits['id']);
			else
				$this->db->query("INSERT INTO hits (user_id, page, kliks) VALUES(".$this->session->userdata('user_id').", ".$this->db->escape($_SERVER['REQUEST_URI']).",1)");
			}
		
		$this->db->where('receiver', $this->session->userdata('user_id'));		
		$this->db->where('unread', 'yes');
		$this->db->from('messages');
		$data['new_messages'] = $this->db->count_all_results();
		if($this->member->get_user_class() >= UC_UPLOADER)
		{			
		$data['uploader'] = '<li><a href="'. base_url('torrents/upload') .'"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Torrent uploaden</a></li> ';
		}				

		$data['user'] = $this->ion_auth->user()->row();
		
		$data['query'] = $this->db->get('menu');
		
		$data['site_message'] = $this->db->where('active', 'yes')->get('site_message')->row_array();

		$added = time();
		
		if($this->session->userdata('class') == 7)
		{
			$this->db->query("UPDATE users SET kliks = kliks + 1, last_access='".$added."', ip_address='0.0.0.0' WHERE id=" . $this->session->userdata('user_id'));
		}else{
			$this->db->query("UPDATE users SET kliks = kliks + 1, last_access='" . $added . "', ip_address='". $_SERVER['REMOTE_ADDR'] ."' WHERE id=" . $this->session->userdata('user_id'));	
		}

		$this->load->view('include/header-test', $data);
		$this->load->view($html, $data);
		$this->load->view('include/footer-test');
	}
	
	
	
	
	
	
	
	

		function get_user_class_name($class)
		{
		switch ($class)
			{
			case UC_USER: 			return "Normale&nbsp;gebruiker";
			case UC_POWER_USER: 	return "Top&nbsp;gebruiker";
			case UC_VIP: 			return "Belangrijke&nbsp;gebruiker";
			case UC_UPLOADER: 		return "Uploader";
			case UC_MODERATOR: 		return "Moderator";
			case UC_ADMINISTRATOR: 	return "Administrator";
			case UC_BEHEERDER: 		return "Beheerder";
			case UC_GOD: 			return "Eigenaar";
			}
		return "";
		}



}
