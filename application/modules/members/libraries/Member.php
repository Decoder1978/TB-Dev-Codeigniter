<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member {
	
	public function __construct()
    {
        $this->ci =& get_instance();

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
	
	
	  public function get_ratio_color($ratio)
	  {
		if ($ratio < 0.1) 	return "#ff0000";
		if ($ratio < 0.2) 	return "#ee0000";
		if ($ratio < 0.3) 	return "#dd0000";
		if ($ratio < 0.4) 	return "#cc0000";
		if ($ratio < 0.5) 	return "#bb0000";
		if ($ratio < 0.6) 	return "#aa0000";
		if ($ratio < 0.7) 	return "#990000";
		if ($ratio < 0.8) 	return "#880000";
		if ($ratio < 0.9) 	return "#770000";
		if ($ratio < 1) 	return "#660000";
		return "green";
	  }
  
  
	public function get_user_class($id = NULL)
	{
		
		if($id)
		{
			return $this->ci->db->select('class')->from('users')->where('id', $id)->get()->row_array();
		}else{
			return $this->ci->session->userdata('class');	
		}
	}

	function is_valid_user_class($class)
	{
	  return is_numeric($class) && floor($class) == $class && $class >= UC_USER && $class <= UC_GOD;
	}
	
	function get_username($id = NULL)
		{
		
		if((int)$id)
		{
			$row = $this->ci->db->query('SELECT username FROM users WHERE id='. $id .'')->row_array();
			return '<a href='. base_url('members/details/'. $id .'') .'>'.$row['username'].' </a>';
		}else{
			$row = $this->ci->db->query('SELECT username, id FROM users WHERE id='. $this->ci->session->userdata('user_id') .'')->row_array();
			return '<a href='. base_url('members/details/'. $row['id'] .'') .'>'.$row['username'].' </a>';
		}
	}	
	
	
	function get_user_avatar($id)
	{
	$row = $this->ci->db->query('SELECT avatar FROM users WHERE id='. $id .'')->row_array();
		
		if($row['avatar'])
			{
			return '<img class="img-responsive thumbnail" style="margin-bottom: 0px;" src="'. base_url('uploads/avatars/'. $row['avatar'] .'').'">';
			}else{
			return '<img class="img-responsive thumbnail" style="margin-bottom: 0px;" src="http://lorempixel.com/249/330/people">';
			}
	}

	
	
	
	function get_user($id = NULL)
		{
			
		if((int)$id)
		{
		$row = $this->ci->db->query("SELECT * FROM users WHERE id = $id")->row_array();
		}else{
		$row = $this->ci->db->query("SELECT * FROM users WHERE id = '". $this->ci->session->userdata('user_id') ."'")->row_array();
		}
		
		return $row;
		}
		
		

	function get_email($id)
		{
		$row = $this->ci->db->query("SELECT email FROM users WHERE id = $id")->row_array();
		if ($row)
			return $row['email'];
		}

	function get_passkey($id)
		{
		$row = $this->ci->db->query("SELECT passkey FROM users WHERE id = $id")->row_array();
		if ($row)
			return $row['passkey'];
		}

	/*function get_usernamesite($id)
		{
		//$res = mysql_query("SELECT deleted, username, warned, donor, blocked FROM users WHERE id = $id")	or sqlerr();
		$row = $this->ci->db->query("SELECT deleted, username, warned, donor, blocked FROM users WHERE id = $id")->row_array();
		$usernamesite = $row['username'];
		if ($row['warned'] == "yes")
			$usernamesite .= "&nbsp;<img width='16px' height='16px' src='". base_url('assets/img/UserIcons/warning.png') ."' alt='Gewaarschuwd'>";
		if ($row['blocked'] == "yes")
			$usernamesite .= "&nbsp;<img width='16px' height='16px' src='". base_url('img/UserIcons/block.png') ."' alt='Geblokeerd'>";
		if ($row['donor'] == "yes")
			$usernamesite .= "&nbsp;<img width='16px' height='16px' src='". base_url('img/UserIcons/donateur.png') ."' alt='Donateur'>";
		if ($row['deleted'] == "yes")
			$usernamesite = "<del>". $usernamesite ."</del>";
		if ($row)
			return $usernamesite;
		}
		


	function get_categorie($id)
		{
		$res = mysql_query("SELECT image FROM categories WHERE id = $id") or sqlerr();
		$row = mysql_fetch_array($res);
		if (!$row['image']) 
			return "";
		else
			return $row['image'];
		}

	function get_categorie_naam($id)
		{
		$res = mysql_query("SELECT name FROM categories WHERE id = $id") or sqlerr();
		$row = mysql_fetch_array($res);
		if (!$row['name']) 
			return "";
		else
			return $row['name'];
		}

		*/
	function get_userratio($id)
		{
		$ratio = '';
		$res = $this->ci->db->query("SELECT downloaded, uploaded FROM users WHERE id = '$id'");
		$row = $res->row_array();
		$ratiotmp =  number_format((($row["downloaded"] > 0) ? ($row["uploaded"] / $row["downloaded"]) : 0),2);
		if ($ratiotmp < 1)
			$ratio .= "<font color=red>(" . $ratiotmp . ")</font>";
		else
			$ratio .= "<font color=green>(" . $ratiotmp . ")</font>";
		if ($row)
			return $ratio;
		}

	function get_ratio($id)
		{
		$row = $this->ci->db->query("SELECT downloaded, uploaded FROM users WHERE id = $id")->row_array();
		//$row = mysql_fetch_array($res);
		$ratio =  number_format((($row["downloaded"] > 0) ? ($row["uploaded"] / $row["downloaded"]) : 0),2);
		if ($row)
			return $ratio;
		}
		
		
function gmtime()
{
    return strtotime(get_date_time());
}		
		
		
		
	function staftijd($ts)
	{
	  $mins = floor(($this->gmtime() - $ts) / 60);
	   if ($mins > 0)
		if ($mins > 1) return "<div class=staff_offline>Offline</div>"; 
		else return "<div class=staff_offline>Offline</div>";
	  return "<div class=staff_online>Online</div>";
	}
		
		
		
		
		
		
		function stafftable($class)
		{
			$res = $this->ci->db->query("SELECT * FROM users WHERE class = $class ");	
			if ($res->num_rows() > 0)
			{
				foreach($res->result_array() as $arr)
				{
					$gezien = $arr["last_login"];
					$lastseen = $arr["last_login"];

					if ($gezien == "0000-00-00 00:00:00")
					$lastseen = "nooit";
					else
					{
					$lastseen = " (" . timespan($gezien,'',2);
					}

					$aanwezig = $this->staftijd($gezien);
					$cover    = $this->get_user_avatar($arr["id"]); 
						
					$sterren = '3';

					print"<div class='col-lg-4'>";
					?>
					<div class="media" style="border: 1px solid #ddd; padding: 5px; margin-bottom: 10px;">
					  <div class="pull-left" style="width: 100px;">
						<?php echo $this->get_user_avatar($arr['id']);?>
					  </div>
					  <div class="pull-left">
						<h4><?php echo $this->get_username($arr['id']);?></h4>
						...
					  </div>
					</div>				
					<?php
					print"</div>";
				}
			}
		}
}