<?php defined('BASEPATH') or exit('No direct script access allowed');

class Member_model extends MY_Model {
	


		public function get_user_ip($userip, $userid)
		{
			if ($userip && ($this->member->get_user_class() >= UC_MODERATOR || $userid == $this->session->userdata('user_id')))
				{
				  $ip = $userip;
				  $dom = gethostbyaddr($userip);
				  if ($dom == $userip || gethostbyname($dom) != $userip)
					$addr = $ip;
				  else
				  {
					$dom = strtoupper($dom);
					$domparts = explode(".", $dom);
					$domain = $domparts[count($domparts) - 2];
					if ($domain == "COM" || $domain == "CO" || $domain == "NET" || $domain == "NE" || $domain == "ORG" || $domain == "OR" )
					  $l = 2;
					else
					  $l = 1;
					$addr = "$ip ($dom)";
				  }
				}
				return $addr ;
		}
	
	public function torrent_table_user($id)
	{
		$r = $this->db->query("SELECT id, added, name, seeders, leechers, category FROM torrents WHERE owner=$id ORDER BY added DESC");
	
	
		
		if ($r->num_rows() > 0)
		{
			$torrents = "<table class='table table-bordered'>" .
			"<tr><td>Soort</td><td>Naam</td><td style='width: 160px;'>Geplaats&nbsp;op</td>".
			"<td class='success' style='width: 20px; text-align: center; color: green;'><span class='glyphicon glyphicon-arrow-up'></span></td>".
			"<td class='danger' style='width: 20px; text-align: center; color: red;'><span class='glyphicon glyphicon-arrow-down'></span></td></tr>";
			foreach($r->result_array() as $a)
			{
				$this->db->where('seeder', 'yes');
				$this->db->where('torrent', $a['id']);
			$seeders_count = $this->db->get('peers')->num_rows();
			
			
				$this->db->where('seeder', 'no');
				$this->db->where('torrent', $a['id']);
			$leechers_count = $this->db->get('peers')->num_rows();

			$r2 = $this->db->query("SELECT name, image FROM categories WHERE id=$a[category]");
			$a2 = $r2->row();
			
			$cat = $a2->name;
			$torrents .= "<tr>";
			$torrents .= "<td><span class='text-danger'>$cat</span></td>";
			$torrents .= "<td><a href=". base_url('torrents/details/'. $a["id"] .'/hit') .">" . htmlspecialchars($a["name"]) . "</a></td>";
			$torrents .= "<td>" . $a['added'] . "</td>";
			$torrents .= "<td class='success'>$seeders_count</td>";
			$torrents .= "<td class='danger'>$leechers_count</td>";
			$torrents .= "</tr>";
			}
			$torrents .= "</table>";
			
			return $torrents ;
		}
		return '<div class="alert alert-info">Deze gebruiker heeft geen torrents geplaatst.</div>';
	}	
	
	



	public function maketable($res)
	{
	global $cats;
	if (!isset($cats))
	{
	$res2 = $this->db->query("SELECT id, image, name FROM categories");
		foreach($res2->result_array() as $arr)
		{
		$catimages[$arr["id"]] = $arr["image"];
		$catnames[$arr["id"]] = $arr["name"];
		}
	}
	$ret = "<table class='table table-bordered'>" .
	"<tr>
	<td>Soort</td>
	<td>Naam</td>
	<td>Grootte</td>
	<td>Verzonden</td>" .
	"<td>Ontvangen</td>
	<td>Ratio&nbsp;torrent</td></tr>";
	foreach($res->result_array() as $arr)
	{

	//$del_old = get_row_count("torrents", "WHERE id=$arr[torrent]");
	$del_old = $this->db->where('id', $arr['torrent'])->get('torrents')->num_rows();
	if ($del_old == 0) {
	$this->db->query("DELETE FROM downloaded WHERE torrent=$arr[torrent]");
	}
	else {
	$arr2 = $this->db->query("SELECT name,size,category,added FROM torrents WHERE id=$arr[torrent]")->row_array();
	//$arr2 = mysql_fetch_assoc($res2);
	$catimage = htmlspecialchars($catimages[$arr2["category"]]);
	$catname = str_replace(" ", "&nbsp;", htmlspecialchars($catnames[$arr2["category"]]));
	$size = str_replace(" ", "&nbsp;", byte_format($arr2["size"]));
	$userid = $arr['user'];
	$torrentid = $arr['torrent'];
	$rowsite =  $this->db->query("SELECT * FROM downup WHERE user='" . $userid . "' AND torrent='" . $torrentid . "'")->row_array();
	//$rowsite = mysql_fetch_array($ressite);
	if ($rowsite["downloaded"] > 0)
	{
	$ratio = number_format($rowsite["uploaded"] / $rowsite["downloaded"], 2);
	$ratio = "<font color=" . $this->member->get_ratio_color($ratio) . ">$ratio</font>";
	if ($rowsite["uploaded"] / $rowsite["downloaded"] > 20) $ratio = "<center>&infin;</center>";
	}
	else
	if ($rowsite["uploaded"] > 0)
	$ratio = "<center>&infin;</center>";
	else
	$ratio = "---";

	if ($rowsite)
	$uploaded = str_replace(" ", "&nbsp;", byte_format($rowsite["uploaded"]));
	else
	$uploaded = "onbekend";
	if ($rowsite)
	$downloaded = str_replace(" ", "&nbsp;", byte_format($rowsite["downloaded"]));
	else
	$downloaded = "onbekend";

	$ret .= "<tr><td><span class='text-danger'>$catname</span></td>" .
	"<td><a href=". base_url('torrents/details/'.$arr['torrent'].'')."><b>" . htmlspecialchars($arr2['name']) .
	"</b></a></td><td align=center>$size</td><td align=center>$uploaded</td>" .
	"<td align=center>$downloaded</td><td align=center>$ratio</td></tr>";
	}
	}
	$ret .= "</table>";
	return $ret;
	}



function maketable_seeding($res)
{

	$res2 = $this->db->query("SELECT id, image, name FROM categories");
	foreach($res2->result_array() as $arr)
	{
		$catimages[$arr["id"]] = $arr["image"];
		$catnames[$arr["id"]] = $arr["name"];
	}

	if ($this->member->get_user_class() >= UC_MODERATOR)
		{
		$ret = "<table class='table table-bordered'>" .
		"<tr>".
		"<td>Soort</td>".
		"<td>Naam</td>".
		"<td>Grootte</td>".
		"<td>Verzonden</td>" .
		"<td>Ontvangen</td>".
		"<td>Ratio&nbsp;torrent</td>".
		"<td>Stuur&nbsp;overseed&nbsp;bericht</td>".
		"</tr>";
		}
	else
		{
		$ret = "<table class='table table-bordered'>" .
		"<tr>".
		"<td>Soort</td>".
		"<td>Naam</td>".
		"<td>Grootte</td>".
		"<td>Verzonden</td>" .
		"<td>Ontvangen</td>".
		"<td>Ratio&nbsp;torrent</td></tr>";
		}
  foreach ($res->result_array() as $arr)
  {
		
	$this->db->where('id', $arr['torrent']);
	$del_old = $this->db->get('torrents')->num_rows();
	
	//$del_old = get_row_count("torrents", "WHERE id=$arr[torrent]");
	if ($del_old == 0) {
		$this->db->query("DELETE FROM downloaded WHERE torrent=". $arr['torrent'] ."");
		}
	else 
	{
	$res2 = $this->db->query("SELECT name,size,category,added FROM torrents WHERE id=$arr[torrent]");
    $arr2 = $res2->row();
	
	//var_dump($this->db->last_query());
	$catimage = htmlspecialchars($catimages[$arr2->category]);
	
	$catname = str_replace(" ", "&nbsp;", htmlspecialchars($catnames[$arr2->category]));
	
	$size = str_replace(" ", "&nbsp;", byte_format($arr2->size));
	
	$userid = $arr['user'];
	
	$torrentid = $arr['torrent'];
	
	$ressite =  $this->db->query("SELECT * FROM downup WHERE user='" . $userid . "' AND torrent='" . $torrentid . "'");
	$rowsite = $ressite->row_array();
	
	//var_dump($rowsite['downloaded']);
	
    if ($rowsite['downloaded'] > 0)
    {
      	$ratio = number_format($rowsite['uploaded'] / $rowsite['downloaded'], 2);
      	$ratio_send = number_format($rowsite['uploaded'] / $rowsite['downloaded'], 2);
      	$ratio = "<font color=" . $this->member->get_ratio_color($ratio) . "><center>$ratio</center></font>";
		if ($rowsite['uploaded'] / $rowsite['downloaded'] > 20) $ratio = "<center>&infin;</center>";
    }
    else
      if ($rowsite['uploaded'] > 0)
        $ratio = "<center>&infin;</center>";
      else
        $ratio = "<center>---</center>";

	if ($rowsite)
		$uploaded = str_replace(" ", "&nbsp;", byte_format($rowsite['uploaded']));
	else
		$uploaded = "onbekend";
	if ($rowsite)
		$downloaded = str_replace(" ", "&nbsp;", byte_format($rowsite['downloaded']));
	else
		$downloaded = "onbekend";

	$sender 		= "";
	$message		= "&nbsp;";
	$ratio_send 	= '';
	
	if ($this->db->where('receiver', $userid)->where('torrent', $torrentid)->get('warn_pm_seeding')->num_rows() > 0) 
		{
		$def =  mysql_query("SELECT sender FROM warn_pm_seeding WHERE receiver=$userid AND torrent=$torrentid") or sqlerr(__FILE__, __LINE__);
		while ($defs = mysql_fetch_assoc($def))
			{
			$sender .= get_username($defs['sender']) . ", ";
			}
		}
		if ($rowsite['uploaded'] > 0)
			{
			if ($ratio_send > 1.5)
				{
				if ($sender)
					$message =  $sender . "<a class=altlink href=message_seeding.php?userid=" . $userid . "&amp;warnid=1&amp;torrentid=$torrentid&amp;ratio=$ratio_send&amp;referer=userdetails.php?id=$userid>nogmaals</a>";
				else
					$message = "<a class=altlink href=message_seeding.php?userid=" . $userid . "&amp;warnid=1&amp;torrentid=$torrentid&amp;ratio=$ratio_send&amp;referer=userdetails.php?id=$userid>stuur pm</a>";
				}
			}
		
	if ($this->member->get_user_class() >= UC_MODERATOR)
		{
	    $ret .= "<tr>".
		"<td><span class='text-danger'>$catname</span></td>" .
		"<td><a href=". base_url('torrents/details/'. $arr['torrent'].'/hit') .">" . htmlspecialchars($arr2->name) . "</a></td>".
		"<td>$size</td>".
		"<td>$uploaded</td>" .
		"<td>$downloaded</td>".
		"<td>$ratio</td>".
		"<td>$message</td>".
		"</tr>";
		}
	else
		{
	    $ret .= "<tr>".
		"<td><span class='text-danger'>$catname</span></td>" .
		"<td><a href=". base_url('torrents/details/'. $arr['torrent'].'/hit') .">" . htmlspecialchars($arr2->name) . "</a></td>".
		"<td>$size</td>".
		"<td>$uploaded</td>" .
		"<td>$downloaded</td>".
		"<td>$ratio</td>".
		"</tr>";
		}
  }
	}
  $ret .= "</table>";
  return $ret;
}

function maketable_downloaded($res)
{
	global $cats, $id;
	if (!isset($cats))
	{
		$res2 = $this->db->query("SELECT id, image, name FROM categories");
		foreach($res2->result_array() as $arr)
		{
			$catimages[$arr["id"]] = $arr["image"];
			$catnames[$arr["id"]] = $arr["name"];
		}
	}

/*	if ($this->member->get_user_class() >= UC_ADMINISTRATOR)
		{
		$ret  =  "<div align=right><form method=post action=user_downup_gb_all.php>";
		$ret .=  "<input type=hidden name=action value=correctie>";
		$ret .=  "<input type=hidden name=userid value=".$id.">";
		$ret .=  "<input type=hidden name=returnto value=userdetails.php?id=".$id.">";
		$ret .=  "<input type=submit class='btn btn-danger' value='Alle torrents aanpassen'>";
		$ret .=  "</form><br><div align=center>";
		}
*/
  	$ret = "<table class='table table-bordered'>" .
    	"<tr>".
		"<td>Soort</td>".
		"<td>Naam</td>".
		"<td>Datum</td>".
		"<td>Grootte</td>".
		"<td>Verzonden</td>" .
    	"<td>Ontvangen</td>".
		"<td>Ratio&nbsp;torrent";
	if ($this->member->get_user_class() >= UC_GOD)
		{
		$ret .= "</td><td>Correctie";
		}
	$ret .= "</td></tr>";
  foreach($res->result_array() as $arr)
  {

	//$del_old = get_row_count("torrents", "WHERE id=$arr[torrent]");
	
	$del_old = $this->db->where('id', $arr['torrent'])->get('torrents')->num_rows();
	
	if ($del_old == 0) 
		{
		$this->db->query("DELETE FROM downloaded WHERE torrent=$arr[torrent]");
		}
		else{
			$res2 = $this->db->query("SELECT name,size,category,added FROM torrents WHERE id=$arr[torrent]");
			$arr2 = $res2->row_array();
			
			$catimage = htmlspecialchars($catimages[$arr2["category"]]);
			$catname = str_replace(" ", "&nbsp;", htmlspecialchars($catnames[$arr2["category"]]));
			$size = str_replace(" ", "&nbsp;", byte_format($arr2["size"]));
			$userid = $arr['user'];
			$torrentid = $arr['torrent'];
			$ressite =  $this->db->query("SELECT * FROM downup WHERE user='" . $userid . "' AND torrent='" . $torrentid . "'") or sqlerr(__FILE__, __LINE__);
			$rowsite = $ressite->row_array();
			$added = '';
			
    if ($rowsite["downloaded"] > 0)
    {
      	$ratio = number_format($rowsite["uploaded"] / $rowsite["downloaded"], 2);
      	$ratio = "<font color=" . $this->member->get_ratio_color($ratio) . ">$ratio</font>";
		if ($rowsite["uploaded"] / $rowsite["downloaded"] > 20) $ratio = "<center>&infin;</center>";
    }
    else
      if ($rowsite["uploaded"] > 0)
        $ratio = "<center>&infin;</center>";
      else
        $ratio = "<center>---</center>";

	if ($rowsite)
		$uploaded = str_replace(" ", "&nbsp;", byte_format($rowsite["uploaded"]));
	else
		$uploaded = "onbekend";

	if ($rowsite)
		$downloaded = str_replace(" ", "&nbsp;", byte_format($rowsite["downloaded"]));
	else
		$downloaded = "onbekend";
	if ($rowsite)
		$added = $arr['added'];	
	
    $ret .= "<tr>".
	"<td><span class='text-danger'>$catname</span></td>" .
	"<td><a href=". base_url('torrents/details/'. $arr['torrent'].'/hit') .">" . htmlspecialchars($arr2['name']) . "</a></td>".
	"<td>$added</td>".
	"<td>$size</td>".
	"<td>$uploaded</td>" .
	"<td>$downloaded</td>".
	"<td>$ratio";
	if ($this->member->get_user_class() >= UC_ADMINISTRATOR)
		{
		$ret .=  "</td><td align=center>";
		$ret .=  "<table><tr><td>";
		$ret .=  "<form method=post action='". base_url('members/user_down_up') ."'>";
		$ret .=  "<input type=hidden name=action value=correctie>";
		$ret .=  "<input type=hidden name=torrentid value=".$torrentid.">";
		$ret .=  "<input type=hidden name=userid value=".$userid.">";
		$ret .=  "<input type=hidden name=returnto value='". base_url('members/details/'. $userid .'') ."#torrent_seeding'>";
		$ret .=  "<input type=submit class='btn btn-sm btn-default' value='Aanpassen'>";
		$ret .=  "</form>";
		$ret .=  "</td></tr></table>";
		}	
	$ret .= "</td></tr>";
  }
	}
  $ret .= "</table>";
  return $ret;
}

	
	
	
	
	public function mod_options($id)
	{
		$options  = "<td><form method=get action=users_modtask.php>";
		$options .= "<input type=hidden name=action value=view>";
		$options .= "<input type=hidden name=user_id value=" . $id . ">";
		$options .= "<input type=submit class='btn btn-danger' value='Moderator opties'>";
		$options .= "</form></td>";
		
		return $options;
	}
	
	
	public function mod_comment($user)
	{
	$form  = "<h5>Gebruikers gegevens aanpassen (alleen voor moderator en hoger)</h5>";
	//$form  = "<div class='panel panel-danger'>";
	//$form .= "<div class='panel-heading'>Gebruikers gegevens aanpassen (alleen voor moderator en hoger)</div>";
	//$form .= "<div class='panel-body'>";
	$form .= "<form method=post action=".base_url("moderator/modtask") .">";
	$form .= "<input type=hidden name='action' value='edituser'>";
	$form .= "<input type=hidden name='userid' value='$user->id'>";
	$form .= "<input type=hidden name='returnto' value='members/details/$user->id'>";
	$form .= "<table class='table table-bordered table-condensed'>";

	// we do not want mods to be able to change user classes or amount donated...
	$form .= "<input type=hidden name=donor value=$user->donor>";

	$modcomment = htmlspecialchars($user->modcomment);
	$modcomment = stripslashes($modcomment);

	$d = str_replace("\n&cedil;", "\n<br>", $modcomment);

	$form .= "<tr><td class='col-md-2'>Commentaar</td><td colspan=3><textarea class='form-control' rows='15' name=modcomment>$modcomment</textarea></td></tr>";
	$warned = $user->warned == "yes";
	$form .= "<tr><td></td>";
	if ($warned)
		$form .= "<td><input name='warned' value='yes' type='radio' " . ($warned ? " checked" : "") . ">Ja <input name='warned' value='no' type='radio' " . (!$warned ? " checked" : "") . ">Nee</td>";
	else
		$form .= "<td><b>Niet&nbsp;gewaarschuwd</b></td>";
	if ($warned)
		{
		$warneduntil = $user->warneduntil;
		if ($warneduntil == '0000-00-00 00:00:00')
			$form .= "<td align=center>(arbitrary duration)</td></tr>";
		else
			{
			$form .= "<td align=center>Gewaarschuwd tot " . $warneduntil;
			}
		}
	else
		{
		$form .= "<td>Waarschuw voor <select name=warnlength>";
		$form .= "<option value=0>------</option>";
		$form .= "<option value=48>2 dagen</option>";
		$form .= "<option value=96>4 dagen</option>";
		$form .= "<option value=336>2 weken</option>";
		$form .= "<option value=672>4 weken</option>";
		$form .= "<option value=1680>10 weken</option>";
		$form .= "</select></td>";
		$form .= "<td>Waarschuwen voor <select name=warnreason>";
		$form .= "<option value=1>Ratio te laag</option>";
		$form .= "<option value=0>Pakken en wegwezen</option>";
		$form .= "<option value=2>Overseeden</option>";
		$form .= "<option value=3>Gb verschil</option>";
		$form .= "<option value=4>Gedrag</option>";
		$form .= "</select></td></tr>";
		}
	$form .= "</td></tr>";
	$form .= "<tr><td colspan=4 align=center><input type=submit class='btn btn-primary' value='Aanpassen'></td></tr>";
	$form .= "</table>";
	$form .= "</form>";
	//$form .= "</div>";
	//$form .= "</div>";

	return $form ;
	}
	
}

