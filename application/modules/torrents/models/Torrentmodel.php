<?php

class Torrentmodel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper('benc');
		$announce_url = $this->config->item('announce_url');
	}




	public function get_completed_info($torrent_id)
	{
		$table  = "<table class='table table-bordered'>";
		$table .= "<tr>";
		$table .= "<th>Gedownload door</th>";
		$table .= "<th>Ratio</th>";
		$table .= "<th>Datum en tijd</th>";
		$table .= "<th>Ratio torrent</font></th>";
		$table .= "<th>Ontvangen</th>";
		$table .= "<th>Verzonden</th>";
		$table .= "<th>Delen</th>";
		$table .= "</tr>";
		
		$res = $this->db->query("SELECT * FROM downloaded WHERE torrent='$torrent_id' ORDER BY added DESC");
		
		foreach($res->result() as $row)
			{
			$userid = $row->user;
			$ressite =  $this->db->query("SELECT * FROM downup WHERE user='" . $userid . "' AND torrent='" . $torrent_id . "'");
			$rowsite = $ressite->row_array();
			
				if ($rowsite["downloaded"] > 0)
					{
					$ratio = number_format($rowsite["uploaded"] / $rowsite["downloaded"], 2);
					$ratiosite = number_format($rowsite["uploaded"] / $rowsite["downloaded"], 2);
					$ratiosite = "<font color=" . $this->member->get_ratio_color($ratiosite) . ">$ratiosite</font>";
					if ($rowsite["uploaded"] / $rowsite["downloaded"] > 20) $ratiosite = "<center>&infin;</center>";
					}
				else
					{
				  if ($rowsite["uploaded"] > 0)
					$ratiorhc = "<center>&infin;</center>";
				  else
					$ratiosite = "---";
					}

				if ($rowsite["downloaded"] == 0) $ratiosite = "<center>&infin;</center>";
				
				if ($rowsite)
					$uploaded = str_replace(" ", "&nbsp;", byte_format($rowsite["uploaded"]));
				else
					$uploaded = "onbekend";
				if ($rowsite)
					$downloaded = str_replace(" ", "&nbsp;", byte_format($rowsite["downloaded"]));
				else
					$downloaded = "onbekend";
				
				$table .= "<tr>";
				$table .= "<td>";
				$table .= "<a href=". base_url('members/details/'. $row->user .'') .">" . $this->member->get_username($row->user) . "</a>";
				$table .= "</td>";
				$table .= "<td>";
				$ratiouser = $this->member->get_userratio($row->user);
				$table .=  $ratiouser;
				$table .=  "</td>";
				$table .=  "<td>";
				$table .=  $row->added;
				$table .=  "</td>";
				$table .= "<td>";
				$table .=  $ratiosite;
				$table .=  "</td>";
				$table .=  "<td>";
				$table .= $downloaded;
				$table .= "</td>";
				$table .=  "<td>";
				$table .=  $uploaded;
				$table .=  "</td>";
				$table .= "<td>";

				$delen = $this->db->where('userid', $row->user)->where('torrent', $torrent_id)->where('seeder', 'yes')->get('peers')->num_rows();
				if ($delen > 0)
					$table .=  "<span class='text-success'>Ja</span>";
				else
					$table .=  "<span class='text-danger'>NEE</span>";
				$table .=  "</td>";
					
				$table .= "</tr>";
			}
			$table .= "</td></tr></table>";
		return $table;
	}





	
	

	public function get_file_info($torrent_id, $torrent_size)
	{
		$s = "<table class='table table-bordered table-condensed table-striped'>";
		$s.= "<tr><th>Bestandsnaam</th><th>Grootte</td></tr>\n";
		
		$query = $this->db->query("SELECT * FROM files WHERE torrent = ".$torrent_id." ORDER BY id");

			foreach($query->result_array() as $subrow)
			{
			$s .= "<tr><td>" . $subrow["filename"] . "</td><td>" . str_replace(" ","&nbsp;",byte_format($subrow["size"], 2)) . "</td></tr>\n";
			}

		$s .= "<tr><td align=right><b>Totaal</td><td>" . str_replace(" ","&nbsp;",byte_format($torrent_size, 2)) . "</td></tr>\n";
		$s .= "</td></tr></table>";

	return $s;
	}


	
	
	
	
	
	public function get_comments_total($id = NULL)
	{
		if((int)$id)
		{
			$this->db->where('torrent', $id);
		}
		return $this->db->get('comments')->num_rows();
	}	
	
	
	
	
	
	
	public function get_comments_form($torrent_id, $torrent_name)
	{
	add_css('summernote/summernote.css');// add css for summernote editor
	add_js('summernote/summernote.min.js'); // add js for summernote editor
	$add_comment = '<button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Bericht toevoegen.</button>';
	
	$comments  = '<div class="row"><div class="col-xs-12"><div class="pull-left">Commentaar toevoegen aan <strong> '. $torrent_name . '</strong></div><div class="pull-right">'. $add_comment.'</div></div></div>';
	$comments .= '<hr>';
	$comments .= '<div class="collapse" id="collapseExample"><form class="form" name="new_comment" method="post" action="'. base_url('torrents/add_comment/'. $torrent_id .'') .'">';
	$comments .= '<input type="hidden" name="tid" value="'. $torrent_id .'"/>';
	$comments .= '<textarea class="form-control summernote" name="text"></textarea><br />';
	$comments .= '<input type="submit" class="btn btn-primary" value="Bericht verzenden !!"></form><hr /></div>';	
	
	return $comments;
	}
	
	
	
	
	public function get_comments($torrent_id)
	{
	
	$res = $this->db->query("SELECT comments.id, text, comments.added, username, users.id as user, users.avatar FROM comments LEFT JOIN users ON comments.user = users.id WHERE torrent = $torrent_id ORDER BY comments.id DESC LIMIT 5");

	//$allrows = array();
	//echo count($res->result_array());
	/*foreach($res->result_array() as $row)
	{
			
		$user = $this->db->where('id', $row['user'])->get('users')->row_array();	
			
			
			$comment_table = '<div class="panel panel-default">';
			$comment_table .= '<div class="panel-heading">';
			$comment_table .= 'Door '. $user['username'];
			
				if ($this->member->get_user_class() >= UC_ADMINISTRATOR)
				{				
					$comment_table .= '<a class="pull-right btn btn-danger btn-xs" href=deletecomment.php?id=$row[id]><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>&nbsp;&nbsp';
				}
				
			$comment_table .= " op " . $row["added"] . " " . ($this->member->get_user_class() >= UC_MODERATOR || $this->session->userdata('user_id') == $row["user"] ? "<a class='pull-right btn btn-default btn-xs' href=comment.php?action=edit&amp;cid=$row[id]><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>" : "") . "";
			$comment_table .= '</div>';
			$comment_table .= '<div class="panel-body">';
			$body = stripslashes($row["text"]);
			$comment_table .= $body;
			$comment_table .= '</div>';
			$comment_table .= '</div>';
			
			
	
	}*/

	return $res->result_array();

	//if (count($allrows)) 
	//	{
	//	$comments .= '<strong>Laatste commentaren, in omgekeerde volgorde</strong><br /><br />';
	//	$comments .= $this->commenttable($allrows);
	//	}else{
	//	$comments .= 'Nog geen berichten voor deze torrent.....maak jij er een?';	
	//	}



	//return $comment_table;
	}
	
	
	
	
	
	
	
	

	
	function commenttable($rows) 
	{
		
		//var_dump($rows);

		foreach($rows as $row)
			{
			$user = $this->db->where('id', $row['user'])->get('users')->row_array();	
			
			$comment_table = '<div class="panel panel-default">';
			$comment_table .= '<div class="panel-heading">';
			$comment_table .= 'Door '. $user['username'];
			
				if ($this->member->get_user_class() >= UC_ADMINISTRATOR)
				{				
					$comment_table .= '<a class="pull-right btn btn-danger btn-xs" href=deletecomment.php?id=$row[id]><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>&nbsp;&nbsp';
				}
				
			$comment_table .= " op " . $row["added"] . " " . ($this->member->get_user_class() >= UC_MODERATOR || $this->session->userdata('user_id') == $row["user"] ? "<a class='pull-right btn btn-default btn-xs' href=comment.php?action=edit&amp;cid=$row[id]><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>" : "") . "";
			$comment_table .= '</div>';
			$comment_table .= '<div class="panel-body">';
			$body = stripslashes($row["text"]);
			$comment_table .= $body;
			$comment_table .= '</div>';
			$comment_table .= '</div>';
			
			return $comment_table;
			}
		
	}





	
	public function get_peer_info($torrent_id)
	{
		
		if (!$torrent_id)
			new_error_message("Foutmelding", "Geen torrent gevonden.","white",3000);
		
		$seeders_count 	= $this->db->where('seeder', 'yes')->where('torrent', $torrent_id)->get('peers')->num_rows();
		$leechers_count = $this->db->where('seeder', 'no')->where('torrent', $torrent_id)->get('peers')->num_rows();

		//$seeders_count = get_row_count("peers","WHERE seeder='yes' AND torrent=".$torrent_id);
		//$leechers_count = get_row_count("peers","WHERE seeder='no' AND torrent=".$torrent_id);

		$res = $this->db->query("SELECT torrents.cover_by, torrents.seeders, torrents.banned, torrents.leechers, torrents.info_hash, torrents.filename, LENGTH(torrents.nfo) AS nfosz, UNIX_TIMESTAMP() - UNIX_TIMESTAMP(torrents.last_action) AS lastseed, torrents.numratings, torrents.name, IF(torrents.numratings < '0', NULL, ROUND(torrents.ratingsum / torrents.numratings, 1)) AS rating, torrents.owner, torrents.save_as, torrents.descr, torrents.visible, torrents.size, torrents.added, torrents.views, torrents.hits, torrents.times_completed, torrents.id, torrents.type, torrents.numfiles, categories.name AS cat_name, users.username FROM torrents LEFT JOIN categories ON torrents.category = categories.id LEFT JOIN users ON torrents.owner = users.id WHERE torrents.id = $torrent_id") or sqlerr(__FILE__, __LINE__);
		$row = $res->row_array();
		if (!$row)
			{
			echo "<div class=div_info><h4>Foutmelding</h4><p>Deze torrent niet gevonden.</p>";
			}

		$downloaders = array();
		$seeders = array();
		$subres = $this->db->query("SELECT peer_id, seeder, finishedat, downloadoffset, uploadoffset, ip, port, uploaded, downloaded, to_go, UNIX_TIMESTAMP(started) AS st, connectable, agent, UNIX_TIMESTAMP(last_action) AS la, userid FROM peers WHERE torrent = $torrent_id") or sqlerr();
		
		foreach($subres->result_array() as $subrow )
			{
			if ($subrow["seeder"] == "yes")
				$seeders[] = $subrow;
			else
				$downloaders[] = $subrow;
			}

		function leech_sort($a,$b)
			{
			if ( isset( $_GET["usort"] ) ) return seed_sort($a,$b);				
			$x = $a["to_go"];
			$y = $b["to_go"];
			if ($x == $y)
				return 0;
			if ($x < $y)
				return -1;
			return 1;
			}
		function seed_sort($a,$b)
			{
			$x = $a["uploaded"];
			$y = $b["uploaded"];
			if ($x == $y)
				return 0;
			if ($x < $y)
				return 1;
			return -1;
			}

		usort($seeders, "seed_sort");
		usort($downloaders, "leech_sort");
//var_dump($downloaders);



		if ($seeders_count == 1)
			$x = "<font size=2><b>" . $seeders_count . " Deler</b></font>\n";
		else
			$x = "<font size=2><b>" . $seeders_count . " Delers</b></font>\n";
		
		$peer_info = begin_frame($x ,'info');
		$peer_info .= $this->dltable("Deler", $seeders, $row);
		$peer_info .= end_frame();


		if ($leechers_count == 1)
			$xx = "<font size=2><b>" . $leechers_count . " Ontvanger</b></font>\n";
		else
			$xx ="<font size=2><b>" . $leechers_count . " Ontvangers</b></font>\n";

		$peer_info .= begin_frame($xx ,'danger');
		$peer_info .= $this->dltable("Ontvangers", $downloaders, $row);
		$peer_info .= end_frame();




				/*function getagent($httpagent, $peer_id)
					{
					if (substr($peer_id,1,2) == "BC")
						return "BitComet" . " " . substr($peer_id,4,1) . "." . substr($peer_id,5,2);
					elseif (substr($peer_id,0,4) == "exbc")
						return "BitComet oude versie";
					else
						return ($httpagent != "" ? $httpagent : "---");
					}*/
		return $peer_info;

	}

		function procent_totaal($waarde)
		{
			$totaal = '';
			
			//echo $waarde;
			
			if($waarde == '100')
			{
			$totaal = 'progress-bar progress-bar-primary';
			}
			if($waarde >= '80' && $waarde <='99')
			{
			$totaal = 'progress-bar progress-bar-success progress-bar-striped active';
			}
			if($waarde >= '30' && $waarde <='79')
			{
			$totaal = 'progress-bar progress-bar-warning progress-bar-striped active';
			}
			if($waarde >= '0' && $waarde <='29')
			{
			$totaal = 'progress-bar progress-bar-danger progress-bar-striped active';
			}

			//if($waarde <= 0 ){ $waarde = '0' ;}
			
			$procent   = '<div class="progress" style="margin-bottom: 0px;">';
			$procent  .= '<div class="'. $totaal.'" role="progressbar" aria-valuenow="'.$waarde.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$waarde.'%">';
			$procent  .= '<span class="">'.$waarde.'%</span>';
			$procent  .= '</div>';
			$procent  .= '</div>';
		
		return $procent;	
		}

	
	
		public function dltable($name, $arr, $torrent)
			{
			//global $CURUSER;

			//var_dump($torrent);
			
			$s = '';
			if (!count($arr))
				return $s;
			$s = "<table class='table table-bordered'>";
			$s .= "<tr><th>Gebruiker</th>" .
				  "<th>Gedeeld</th>".
				  "<th class='hidden-xs hidden-sm'>Snelheid</th>".
				  "<th>Ontvangen</th>" .
				  "<th class='hidden-xs hidden-sm'>Snelheid</th>" .
				  "<th>Ratio</th>" .
				  "<th width='200px'>Kompleet</th>" .
				  //"<th>Programma</th>".
				  "</tr>\n";
			$now = time();
			$moderator = (isset($CURUSER) && $this->member->get_user_class() >= UC_ADMINISTRATOR);
			$mod = $this->member->get_user_class() >= UC_MODERATOR;
			
			foreach ($arr as $e) 
			{
				$userid = $e['userid'];
				$torrentid = $torrent['id'];
				$ressite =  $this->db->query("SELECT * FROM downup WHERE user='" . $userid . "' AND torrent='" . $torrentid . "'");
				$rowsite = $ressite->row_array();
				if ($rowsite["downloaded"] > 0)
				{
					$ratiosite = number_format($rowsite["uploaded"] / $rowsite["downloaded"], 2);
					$ratiosite = "<font color=" . $this->member->get_ratio_color($ratiosite) . ">$ratiosite</font>";
					if ($rowsite["uploaded"] / $rowsite["downloaded"] > 20) $ratiosite = "<center>&infin;</center>";
				}
				else
				  if ($rowsite["uploaded"] > 0)
					$ratiorhc = "<center>&infin;</center>";
				  else
					$ratiosite = "---";

				if ($rowsite["downloaded"] == 0) $ratiosite = "<center>&infin;</center>";

				if ($rowsite)
					$uploaded = str_replace(" ", "&nbsp;", byte_format($rowsite["uploaded"]));
				else
					$uploaded = "onbekend";
				if ($rowsite)
					$downloaded = str_replace(" ", "&nbsp;", byte_format($rowsite["downloaded"]));
				else
					$downloaded = "onbekend";

						//($unr = mysql_query("SELECT username, warned, donor, privacy FROM users WHERE id=$e[userid] ORDER BY last_access DESC LIMIT 1")) or die;
						//$una = mysql_fetch_array($unr);

						//if ($una["username"]) 
						//{
						
						$s .= "<td><a href=". base_url('members/details/'. $e['userid'] .'') .">".$this->member->get_username($e['userid'])." ".$this->member->get_userratio($e['userid'])."</a></td>\n";
						//} 
						//else
						//$s .= "<td >" . ($mod ? $e["ip"] : preg_replace('/\.\d+$/', ".xxx", $e["ip"])) . "</td>\n";
						
				$secs 		= max(1, ($now - $e["st"]) - ($now - $e["la"]));
				//$revived 	= $e["revived"] == "yes";
				$tegaan 	= floor(100 * (1 - ($e["to_go"] / $torrent["size"])));
				
				$s .= "<td>" . str_replace(" ","&nbsp;",$uploaded) . "</td>\n";
				$s .= "<td class='hidden-xs hidden-sm'><nobr>" . str_replace(" ","&nbsp;",byte_format(($e["uploaded"] - $e["uploadoffset"]) / $secs)) . "/s</nobr></td>\n";
				$s .= "<td>" . $downloaded . "</td>\n";
				if ($e["seeder"] == "no")
					$s .= "<td class='hidden-xs hidden-sm'><nobr>" . byte_format(($e["downloaded"] - $e["downloadoffset"]) / $secs) . "/s</nobr></td>\n";
				else
					$s .= "<td class='hidden-xs hidden-sm'><nobr>" . byte_format(($e["downloaded"] - $e["downloadoffset"]) / max(1, $e["finishedat"] - $e['st'])) .	"/s</nobr></td>\n";
				$s .= "<td>$ratiosite</td>\n";
				$s .= "<td>". $this->procent_totaal($tegaan) ."</td>\n";
				//$s .= "<td >" . htmlspecialchars(getagent($e["agent"], $e["peer_id"])) . "</td>\n";
				$s .= "</tr>\n";
			}
			$s .= "</table>\n";
			return $s;
			}	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function upload_torrent($fieldname)
	{

		$naam  = $this->input->post('name');
		$cat   = $this->input->post('category');
		$descr = $this->input->post('descr');
		
		if(!$naam)
		{
			$this->session->set_flashdata('info', 'Geen naam ingevuld......geef deze torrent een titel !');
			redirect('torrents/upload');			
		}
		
		if(!$cat)
		{
			$this->session->set_flashdata('info', 'Geen categorie geselecteerd......kies een categorie !');
			redirect('torrents/upload');			
		}
		
		if(!$descr)
		{
			$this->session->set_flashdata('info', 'Geen omschrijfing ontvangen of te weinig woorden gekregen !');
			redirect('torrents/upload');			
		}
		
		if (!isset($_FILES['userfile'])){
				$this->session->set_flashdata('danger', 'Geen bestand ontvangen !');
				redirect('torrents/upload');
		}
		

		$f = $_FILES['userfile'];
		$fname = $f['name'];
		if (empty($fname)) {
			$this->session->set_flashdata('danger', 'Geen bestand ontvangen !');
			redirect('torrents/upload');
		}

		

		if(preg_match('/^[^\0-\x1f:\\\\\/?*\xff#<>|]+$/si', $fname)){
			$pathinfo = pathinfo($fname);
			
			if($pathinfo['extension'] != 'torrent' && $pathinfo['extension'] != 'zip'){
			$this->session->set_flashdata('danger', 'Dit is geen torrent !! <br />Selecteer een torrent om te verzenden!');
			redirect('torrents/upload');
			}
		}

		


		$shortfname = $torrent = basename($fname);
		$tmpname = $f['tmp_name'];
		if(!is_uploaded_file($tmpname)) {
			$this->session->set_flashdata('danger', 'Huh.....??');
			redirect('torrents/upload');
		}

		
		if(!filesize($tmpname)){
			$this->session->set_flashdata('danger', 'ooooh dit bestand is leeg....wat heb je geupload ??');
			redirect('torrents/upload');
		}
		
		// analyse Upload. Zip -> multifile check; torrent -> single check

		$pathinfo = pathinfo($fname);

		if($pathinfo['extension'] == 'torrent') {
			$data = file_get_contents($tmpname);
			$return = $this->checkFile($fname, $data);
			//$msg .= $return['msg'];
			//$error = $return['code'];
			if($return['msg'])
			{
			$this->session->set_flashdata('danger', $return['msg']);
			redirect('torrents/upload');
			}
		}
	}

	public function checkFile($filename, $data){
		
	$this->load->library('torrent');
	//$user = $this->data['curuser'];

	$torrent_new = new Torrent($data);


/*echo '<br>private: ', $torrent->is_private() ? 'yes' : 'no', 
	 '<br>annonce: ', $torrent->announce(), 
	 '<br>name: ', $torrent->name(), 
	 '<br>comment: ', $torrent->comment(), 
	 '<br>piece_length: ', $torrent->piece_length(), 
	 '<br>size: ', $torrent->size( 2 ),
	 '<br>hash info: ', $torrent->hash_info(),
	 '<br>stats: ';
var_dump( $torrent->scrape() );
echo '<br>content: ';
var_dump( $torrent->content() );
echo '<br>source: ',
	 $torrent;

// get magnet link
$torrent->magnet(); // use $torrent->magnet( false ); to get non html encoded ampersand

//die();*/

	
	//$torrent->hash_info();
	//die();
	
	// decode the torrent file
	$dict= $this->bdecode($data);
	// change announce url
	$dict['announce'] = $this->config->item('announce_url');
	// add private tracker flag
	$dict['info']['private']=1;
	// compute infohash
	//$infohash = pack('H*', sha1($this->bencode($dict['info'])));
	$infohash = $torrent_new->hash_info();
	// recreate the torrent file
	$data = $this->bencode($dict);
	
	$dict = bdec($data);
	if (!isset($dict)){
		$ret['code'] = -1;
		$ret['msg'] = 'Torrent file is corrupt!';
		return $ret;
	}

	
	list($ann, $info) = $this->dict_check($dict, 'announce(string):info');

	$tmaker = (isset($dict['value']['created by']) && !empty($dict['value']['created by']['value'])) ? $dict['value']['created by']['value'] : 'Unknown';
	
	unset($dict);
	
	list($dname, $plen, $pieces) = $this->dict_check($info, 'name(string):piece length(integer):pieces(string)');
	

	if ($ann != $this->config->item('announce_url')) {
		$ret['code'] = -1;
		$ret['msg'] = 'invalid announce url! must be <b>' . $this->config->item('announce_url') . '</b>';
		return $ret;
	}
	
	if (strlen($pieces) % 20 != 0) {
		$ret['code'] = -1;
		$ret['msg'] = 'invalid pieces';
		return $ret;
	}
	
	$filelist = array();
	$totallen = $this->dict_get($info, 'length', 'integer');
	if (isset($totallen)) {
		$filelist[] = array($dname, $totallen);
		$type = 'single';
	}
	else {
		$flist = $this->dict_get($info, 'files', 'list');
		if (!isset($flist)) {
					$ret['code'] = -1;
					$ret['msg'] = 'missing both length and file';
					return $ret;
				}
		if (!count($flist)) {
					$ret['code'] = -1;
					$ret['msg'] = 'no files';
					return $ret;
				}
		$totallen = 0;
		foreach ($flist as $fn) {
			list($ll, $ff) = $this->dict_check($fn, 'length(integer):path(list)');
			$totallen += $ll;
			$ffa = array();
			foreach ($ff as $ffe) {
				if ($ffe['type'] != 'string') {
					$ret['code'] = -1;
					$ret['msg'] = 'filename error';
					return $ret;
				}
				$ffa[] = $ffe['value'];
			}
			if (!count($ffa)){
				$ret['code'] = -1;
				$ret['msg'] = 'filename error';
				return $ret;
			}
			$ffe = implode('/', $ffa);
			$filelist[] = array($ffe, $ll);
		}
		$type = 'multi';
	}
		
	
	//$infohash = pack('H*', sha1($info['string']));
	//$infohash = sha1($info["string"]);
	
	unset($info);
	// Replace punctuation characters with spaces
	
	$torrent = str_replace('_', ' ', $filename);
	//$torrent = str_replace('.torrent', '', $torrent);
	
	
	// make this codeigiter db compatible........
	/*$query = 	$this->db->get('torrents');
				$this->db->where('info_hash', $infohash);
	$count = $query->num_rows();

	
	if($count > 0) {
	$this->session->set_flashdata('info', 'Deze torrent bestaat al !');
	redirect('torrents/upload');
	}*/
	
	$data = array(
			'search_text' => 'My title',
			'filename' => $torrent,
			'owner' => $this->session->userdata('user_id'),			
			'visible' => 'no',
			'info_hash' => $infohash,
			'name' => $this->input->post('name'),
			'size' => $totallen,
			'numfiles' => count($filelist),
			'type' => $type,
			'descr' => $this->input->post('descr'),
			'ori_descr' => $this->input->post('descr'),
			'category' => $this->input->post('category'),
			'save_as' => $dname,
			'added' => get_date_time(),
			'last_action' => get_date_time(),
			'nfo' => ''
	);
	
	$this->db->insert('torrents', $data);
	unset($data);// dont need this anymore
	$id = $this->db->insert_id();
	$this->db->delete('files', array('torrent' => $id));


		foreach ($filelist as $file) {
			$data = array(
				'torrent' => $id,
				'filename' => $file[0],
				'size' => $file[1],
			);
			$this->db->insert('files', $data);			
			}
		$tmpname = $_FILES["userfile"]["tmp_name"];
		move_uploaded_file($tmpname, "uploads/torrents/$id.torrent");
		$this->session->set_flashdata('success', 'Gelukt!! De torrent is juist ontvangen en de gegevens zijn toegevoegd!');
		redirect('torrents/details/'. $id .'');
}

function dict_check($d, $s) {
	if ($d['type'] != 'dictionary') {
		// bark('not a dictionary');
		return false;
	}
	$a = explode(':', $s);
	$dd = $d['value'];
	$ret = array();
	$t='';
	foreach ($a as $k) {
		unset($t);
		if (preg_match('/^(.*)\((.*)\)$/', $k, $m)) {
			$k = $m[1];
			$t = $m[2];
		}
		if (!isset($dd[$k])) {
			// bark('dictionary is missing key(s)');
			return false;
		}
		if (isset($t)) {
			if ($dd[$k]['type'] != $t){
				// bark("invalid entry in dictionary");
				return false;
			}
			$ret[] = $dd[$k]['value'];
		}
		else
		$ret[] = $dd[$k];
	}
	return $ret;
}

function dict_get($d, $k, $t) {
	if ($d['type'] != 'dictionary')
	bark("not a dictionary");
	$dd = $d['value'];
	if (!isset($dd[$k]))
	return;
	$v = $dd[$k];
	if ($v['type'] != $t) {
	  // bark("invalid dictionary entry type");
	  var_dump($v);
	  exit();
	}
	return $v["value"];
}

function file_list($arr,$id)
{
	foreach($arr as $v)
	$new[] = "($id,".sqlesc($v[0]).','.$v[1].')';
	return join(',',$new);
}


// Stolen from http://wiki.theory.org/Decoding_encoding_bencoded_data_with_PHP
// TX to Punko?!
function bdecode($s, &$pos=0) {
	if($pos>=strlen($s)) {
		return null;
	}
	switch($s[$pos]){
		case 'd':
			$pos++;
			$retval=array();
			while ($s[$pos]!='e'){
				$key = $this->bdecode($s, $pos);
				$val = $this->bdecode($s, $pos);
				if ($key===null || $val===null)
				break;
				$retval[$key]=$val;
			}
			$retval['isDct']=true;
			$pos++;
			return $retval;

		case 'l':
			$pos++;
			$retval=array();
			while ($s[$pos]!='e'){
				$val = $this->bdecode($s, $pos);
				if ($val===null)
				break;
				$retval[]=$val;
			}
			$pos++;
			return $retval;

		case 'i':
			$pos++;
			$digits=strpos($s, 'e', $pos)-$pos;
			$val=(int)substr($s, $pos, $digits);
			$pos+=$digits+1;
			return $val;

			//	case "0": case "1": case "2": case "3": case "4":
			//	case "5": case "6": case "7": case "8": case "9":
		default:
			$digits=strpos($s, ':', $pos)-$pos;
		if ($digits<0 || $digits >20)
		return null;
		$len=(int)substr($s, $pos, $digits);
		$pos+=$digits+1;
		$str=substr($s, $pos, $len);
		$pos+=$len;
		//echo "pos: $pos str: [$str] len: $len digits: $digits\n";
		return (string)$str;
	}
	return null;
}

// Stolen from http://wiki.theory.org/Decoding_encoding_bencoded_data_with_PHP
// TX to Punko?!
function bencode(&$d){
	if(is_array($d)){
		$ret = 'l';
		if(isset($d['isDct']) && $d['isDct']){
			$isDict=1;
			$ret = 'd';
			// this is required by the specs, and BitTornado actualy chokes on unsorted dictionaries
			ksort($d, SORT_STRING);
		}
		foreach($d as $key=>$value) {
			if(isset($isDict)) {
				// skip the isDct element, only if it's set by us
				if($key=="isDct" and is_bool($value)) continue;
				$ret.=strlen($key).":".$key;
			}
			if (is_string($value)) {
				$ret.=strlen($value).":".$value;
			} elseif (is_int($value)){
				$ret.="i${value}e";
		} else {
			$ret.= $this->bencode ($value);
		}
	}
	return $ret.'e';
} elseif (is_string($d)) // fallback if we're given a single bencoded string or int
return strlen($d).":".$d;
elseif (is_int($d))
return "i${d}e";
else
return null;
}

}
?>
