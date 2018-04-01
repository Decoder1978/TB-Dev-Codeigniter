<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Forums
{
	
	function __construct()
	{
		$this->ci =& get_instance();
		
	}

  function catch_up()
  {
	//die("Deze functie is op dit moment niet beschikbaar");
    global $CURUSER;

    $userid = $CURUSER["id"];

    $res = mysql_query("SELECT id, lastpost FROM topics") or sqlerr(__FILE__, __LINE__);

    while ($arr = mysql_fetch_assoc($res))
    {
      $topicid = $arr["id"];

      $postid = $arr["lastpost"];

      $r = mysql_query("SELECT id,lastpostread FROM readposts WHERE userid=$userid and topicid=$topicid") or sqlerr(__FILE__, __LINE__);

      if (mysql_num_rows($r) == 0)
        mysql_query("INSERT INTO readposts (userid, topicid, lastpostread) VALUES($userid, $topicid, $postid)") or sqlerr(__FILE__, __LINE__);

      else
      {
        $a = mysql_fetch_assoc($r);

        if ($a["lastpostread"] < $postid)
          mysql_query("UPDATE readposts SET lastpostread=$postid WHERE id=" . $a["id"]) or sqlerr(__FILE__, __LINE__);
      }
    }
  }

  //-------- Returns the minimum read/write class levels of a forum


function get_forum_id($topicid)
	{
	    $res = $this->ci->db->query("SELECT forumid FROM topics WHERE id=$topicid");

		if ($res->num_rows() != 1)
		{
			return FALSE;
		}
		$arr = $res->row_array();
		
		return $arr['forumid'];
	}

  function get_forum_access_levels($forumid)
  {
    $res = $this->ci->db->query("SELECT * FROM forums WHERE id='". $forumid ."'");

    if ($res->num_rows() != 1)
	{
	return false;	
	} 

    $arr = $res->row_array();

    return array("read" => $arr["minclassread"], "write" => $arr["minclasswrite"], "create" => $arr["minclasscreate"]);
  }

  //-------- Returns the forum ID of a topic, or false on error

  function get_topic_forum($topicid)
  {
    $res = $this->ci->db->query("SELECT forumid FROM topics WHERE id=$topicid");

    if ($res->num_rows() != 1)
	{
		return FALSE;
	}


    $arr = $res->row_array();

    return $arr['forumid'];
  }

  //-------- Returns the ID of the last post of a forum

  function update_topic_last_post($topicid)
  {
    $res = $this->ci->db->query("SELECT id FROM posts WHERE topicid=$topicid ORDER BY id DESC LIMIT 1");

    $arr = $res->row_array() or die("Geen post gevonden");

    $postid = $arr['id'];

    $this->ci->db->query("UPDATE topics SET lastpost=$postid WHERE id=$topicid");
  }
  
  
  
  
	public function get_edit_by($id, $arr)
	{
	//if ((int)($arr['editedby']))
    // {
        $res2 = $this->ci->db->query('SELECT username FROM users WHERE id='.$id.'');
        if ($res2->num_rows() == 1)
        {
          $arr2 = $res2->row_array();
          return '<p class=small>Laatst bewerkt door <a href=userdetails.php?id='. $arr['editedby'] .'>'. $arr2['username'] .'</a> op '. unix_to_human($arr['editedat']) .'</p>';
        }
      //}
	}
  
  
	public function get_response_buttons($locked, $maypost, $topicid, $postid, $posterid)
	{
		$return = '';
		
		//echo $maypost;
		if (!$locked && $maypost || $this->ci->member->get_user_class() >= UC_MODERATOR)
		{
		$return .= '<a class="btn btn-default btn-xs" href='. base_url('forum/quote/'. $topicid .'/'. $postid .'') .'><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Quote</a>&nbsp;&nbsp;&nbsp;';
		}
		
		if (($this->ci->session->userdata('user_id') == $posterid && !$locked) || $this->ci->member->get_user_class() >= UC_MODERATOR)
		{
		$return .= '<a class="btn btn-default btn-xs" href='. base_url('forum/edit/'. $postid .'/'. $topicid .'') .'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Bewerk</a>&nbsp;&nbsp;&nbsp;';
		} 
		
		if ($this->ci->member->get_user_class() >= UC_ADMINISTRATOR)
		{
		$return .= '<a class="btn btn-danger btn-xs" href=?action=deletepost&postid=$postid><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Verwijder</a>&nbsp;&nbsp;&nbsp;';
		}
		
		$return .= '<a class="btn btn-success btn-xs" href="#top"><span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span> Top</a>';
		
		return $return;
	}
  
  
  
  

  public function get_forum_last_post($forumid)
  {
    $res = $this->ci->db->query("SELECT lastpost FROM topics WHERE forumid=$forumid ORDER BY lastpost DESC LIMIT 1");

    $arr = $res->row_array();

    $postid = $arr['lastpost'];

    if ($postid)
      return $postid;

    else
      return 0;
  }
  
  
  
  
  
  
  

  //-------- Inserts a quick jump menu

  function insert_quick_jump_menu($currentforum = 0)
  {
	  
 
	$jumpmenu  = "";
    $jumpmenu .= "<div class='pull_right'><form method=get action='". base_url('forum/viewforum/')."' name=jump>";
	$jumpmenu .= "<select class='form-control' name='' onchange=\"if(this.options[this.selectedIndex].value != '' ) location.href=this.options[this.selectedIndex].value\">";

    $res = $this->ci->db->query("SELECT * FROM forums ORDER BY name");

    foreach ($res->result_array() as $arr)
    {
      if ($this->ci->member->get_user_class() >= $arr["minclassread"])
        $jumpmenu .= "<option value=" . $arr["id"] . ($currentforum == $arr["id"] ? " selected>" : ">") . $arr["name"] . "";
    }
    $jumpmenu .= "</select>";
	$jumpmenu .="</form></div>";
	
	return $jumpmenu;
  }

  //-------- Inserts a compose frame

  function insert_compose_frame($id, $newtopic = true, $quote = false, $postid = NULL)
  {
	add_css('summernote/summernote.css');
	add_js('summernote/summernote.min.js'); 

   
   $compose_frame = '';
   
    if ($newtopic)
    {
      $res = $this->ci->db->query("SELECT name FROM forums WHERE id=$id");

      $arr = $res->row_array() or die("Forum bestaat niet");

      $forumname = $arr["name"];

	$compose_frame .= begin_frame("Nieuw topic in >> <a href=?action=viewforum&forumid=$id>$forumname</a>",'primary');
    }
    else // replay message
    {
      $res = $this->ci->db->query("SELECT * FROM topics WHERE id=$id");

      $arr = $res->row_array();
	  
	  if(!$arr)
	  {
		$this->ci->session->set_flashdata('danger', '<strong>Fout</strong>Topic bestaat niet.!!');
 		redirect('forum');			  
	  }

      $subject = $arr["subject"];
    $compose_frame .= begin_frame("Reageer op topic: <a href=?action=viewtopic&topicid=$id>$subject</font></a>",'primary');
	}
	

    $compose_frame .= "<form method=post action='". base_url('forum/post') ."'>";

    if ($newtopic)
	{
	$compose_frame .= "<input type=hidden name=forumid value=$id>";	
	}else{
	$compose_frame .= "<input type=hidden name=topicid value=$id>";
	}
    
	$compose_frame .= "<table class='table table-bordered table-striped'>";

    if ($newtopic)
	{
	$compose_frame .= "<tr><td>Onderwerp</td><td><input class='form-control' type=text maxlength=100 name=subject placeholder='Onderwerp'></td></tr>";	
	}

    if ($quote)
    {

       if (!(int)($postid))
         die('Cant quote without post id!!');

//	   $res = mysql_query("SELECT posts.*, users.username FROM posts JOIN users ON posts.userid = users.id WHERE posts.id=$postid") or sqlerr(__FILE__, __LINE__);
	   $res = $this->ci->db->query("SELECT posts.*, users.username FROM posts LEFT JOIN users ON posts.userid = users.id WHERE posts.id=$postid") or sqlerr(__FILE__, __LINE__);

	   if ($res->num_rows() != 1)
	     site_error_message("Foutmelding", "Er bestaat geen post met ID $postid.");

	   $arr = $res->row_array();
	   
    }

	$compose_frame .= "<tr><td class='col-md-2'>Inhoud</td>";
	$compose_frame .= "<td><textarea id='editor_forum' class='form-control summernote' name=body rows=10>".($quote?(("[quote=".htmlspecialchars($arr["username"])."]".stripslashes(htmlspecialchars($arr["body"]))."[/quote]")):"")."</textarea></td></tr>";
	$compose_frame .="<tr><td colspan=2 align='right'><input class='btn btn-primary' type=submit value='Versturen'></td></tr>";
    $compose_frame .="</table>";
    $compose_frame .="</form>";
    $compose_frame .= end_frame();

    //------ Get 10 last posts if this is a reply

    if (!$newtopic)
    {
	$compose_frame .= begin_frame('De laatste 10 forum posten voor dit onderwerp','success');

    $postres = $this->ci->db->query("SELECT * FROM posts WHERE topicid=$id ORDER BY id DESC LIMIT 10");
    foreach($postres->result_array() as $post)
    {
    //-- Get poster details
    $userres = $this->ci->db->query("SELECT * FROM users WHERE id=" . $post["userid"] . " LIMIT 1");
    $user = $userres->row_array();
	
	if($user['avatar']){
	$avatar = $user['avatar'];
	}else{
	$avatar = "img/default_avatar.png";
	}
	//$posts_count = get_row_count("posts", "WHERE userid = '".$user['id']."'");
	$posts_count = $this->ci->db->query('SELECT * FROM posts WHERE userid = '.$user['id'].'')->num_rows();
    //$added = convertdatum($post["added"]) . " (" . (get_elapsed_time(sql_timestamp_to_unix_timestamp($post["added"]))) . " geleden)";
    $added = unix_to_human($post["added"]);
	
	$body = $post["body"]; 
	$body = stripslashes($body);

	
	$compose_frame .= '<table class="table table-bordered table-striped">';
	$compose_frame .= '<tr><th colspan="2">Geplaatst op '.$added.'</th></tr>';
	$compose_frame .= '<tr>';
	$compose_frame .= '<td width="220px">';
	$compose_frame .= '<table class="table table-bordered table-condensed">';
	$compose_frame .= '<tr><td colspan="2"><div align="center">'. $this->ci->member->get_user_avatar($user['id']) .'</div></td></tr>';
	$compose_frame .= '<tr><td><strong>Naam</strong></td><td>'. $this->ci->member->get_username($user['id']) .'</td></tr>';
	$compose_frame .= "<tr><td><strong>Download</strong></td><td>". byte_format($user['downloaded']). "</td></tr>";
	$compose_frame .= "<tr><td><strong>Upload</strong></td><td>". byte_format($user['uploaded']). "</td></tr>";
	$compose_frame .= "<tr><td><strong>Posts</strong></td><td> ". $posts_count. " </td></tr>";
	$compose_frame .= "</table>";
	$compose_frame .= "</td>";
	$compose_frame .= "<td style='padding:10px;'>". stripslashes($body) ."</div></td>";
	$compose_frame .= "</tr>";
	$compose_frame .= "<tr><td colspan='2'></td></tr>";
	$compose_frame .= "</table>";

	}
	$compose_frame .= end_frame();
    }
	
	return $compose_frame ;
  }


}

