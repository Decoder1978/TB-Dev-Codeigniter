<?php
class Forummodel extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		
	}
	
	
	
	
	public function insert_forum()
	{
		$name = $this->input->post('name');		
		$desc = $this->input->post('desc');

		if ($this->member->get_user_class() < UC_ADMINISTRATOR)
		{
		$this->session->set_flashdata('danger', 'Toegang geweigerd !');
		redirect('forum');
		}
		
		if (!$name && !$desc)
			{
			$this->session->set_flashdata('danger', 'Gegevens ontbreken!');
			redirect('forum/forum_admin');
			}
		
			$data = array(
			'sort' 				=> $this->input->post('sort'),
			'name' 				=> $this->input->post('name'),
			'description' 		=> $this->input->post('desc'),
			'minclassread' 		=> $this->input->post('readclass'),
			'minclasswrite' 	=> $this->input->post('writeclass'),
			'minclasscreate'	=> $this->input->post('createclass')
			);
		
			$this->db->insert('forums', $data);
			$this->session->set_flashdata('info', 'Forum successvol toegevoegd!');
			redirect('forum/forum_admin');
	}
	
	
	public function edit_forum()
	{
		$name 	= $this->input->post('name');		
		$desc 	= $this->input->post('desc');
		$id 	= $this->input->post('id');
		
		
		if ($this->member->get_user_class() < UC_ADMINISTRATOR)
		{
		$this->session->set_flashdata('danger', 'Toegang geweigerd !');
		redirect('forum/forum_admin');
		}
		
		if (!$name && !$desc && !$id)
			{
			$this->session->set_flashdata('danger', 'Gegevens ontbreken!');
			redirect('forum/forum_admin');
			}
			
			$data = array(
			'sort' 				=> $this->input->post('sort'),
			'name' 				=> $this->input->post('name'),
			'description' 		=> $this->input->post('desc'),
			'minclassread' 		=> $this->input->post('readclass'),
			'minclasswrite' 	=> $this->input->post('writeclass'),
			'minclasscreate'	=> $this->input->post('createclass')
			);
			
			$this->db->where('id', $id);
			$this->db->update('forums', $data);
			$this->session->set_flashdata('info', 'Forum successvol aangepast!');
			redirect('forum/forum_admin');
	}
	
	
	
	
	public function del_forum($id)
	{

		//$id 	= $this->input->post('id');

		if ($this->member->get_user_class() < UC_ADMINISTRATOR)
		{
		$this->session->set_flashdata('danger', 'Toegang geweigerd !');
		redirect('forum/forum_admin');
		}
		
		if (!$id)
			{
			$this->session->set_flashdata('danger', 'Gegevens ontbreken!');
			redirect('forum/forum_admin');
			}
			
		$result = $this->db->query("SELECT * FROM topics where forumid = '".$id."'");
		if ($row = $result->result_array())
			{
			do
				{
				$this->db->query("DELETE FROM posts where topicid = '".$id."'");
				}
			while($row = $result->result_array());
			}
		$this->db->query("DELETE FROM topics where forumid = '".$id."'");
		$this->db->query("DELETE FROM forums where id = '".$id."'");

		$this->session->set_flashdata('info', 'Forum successvol verwijderd!');
		redirect('forum/forum_admin');
	
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
	    $res = mysql_query("SELECT forumid FROM topics WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);

		if (mysql_num_rows($res) != 1)
			return false;
		
		$arr = mysql_fetch_assoc($res);
		
		return $arr['forumid'];
	}

  function get_forum_access_levels($forumid)
  {
    $res = mysql_query("SELECT minclassread, minclasswrite, minclasscreate FROM forums WHERE id=$forumid") or sqlerr(__FILE__, __LINE__);

    if (mysql_num_rows($res) != 1)
      return false;

    $arr = mysql_fetch_assoc($res);

    return array("read" => $arr["minclassread"], "write" => $arr["minclasswrite"], "create" => $arr["minclasscreate"]);
  }

  //-------- Returns the forum ID of a topic, or false on error

  function get_topic_forum($topicid)
  {
    $res = mysql_query("SELECT forumid FROM topics WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);

    if (mysql_num_rows($res) != 1)
      return false;

    $arr = mysql_fetch_row($res);

    return $arr[0];
  }

  //-------- Returns the ID of the last post of a forum

  function update_topic_last_post($topicid)
  {
    $res = mysql_query("SELECT id FROM posts WHERE topicid=$topicid ORDER BY id DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);

    $arr = mysql_fetch_row($res) or die("Geen post gevonden");

    $postid = $arr[0];

    mysql_query("UPDATE topics SET lastpost=$postid WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);
  }

  function get_forum_last_post($forumid)
  {
    $res = mysql_query("SELECT lastpost FROM topics WHERE forumid=$forumid ORDER BY lastpost DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);

    $arr = mysql_fetch_row($res);

    $postid = $arr[0];

    if ($postid)
      return $postid;

    else
      return 0;
  }

  //-------- Inserts a quick jump menu

  function insert_quick_jump_menu($currentforum = 0)
  {
    print("<div class='pull_right'><form method=get action=? name=jump>\n");
    print("<input type=hidden name=action value=viewforum>\n");
    print("<select name=forumid onchange=\"if(this.options[this.selectedIndex].value != -1){ forms['jump'].submit() }\">\n");

    $res = mysql_query("SELECT * FROM forums ORDER BY name") or sqlerr(__FILE__, __LINE__);

    while ($arr = mysql_fetch_assoc($res))
    {
      if (get_user_class() >= $arr["minclassread"])
        print("<option value=" . $arr["id"] . ($currentforum == $arr["id"] ? " selected>" : ">") . $arr["name"] . "\n");
    }
    print("</select>\n");
    print("</form></div>");
  }

  //-------- Inserts a compose frame

  function insert_compose_frame($id, $newtopic = true, $quote = false)
  {
    global $maxsubjectlength, $CURUSER;

    if ($newtopic)
    {
      $res = mysql_query("SELECT name FROM forums WHERE id=$id") or sqlerr(__FILE__, __LINE__);

      $arr = mysql_fetch_assoc($res) or die("Forum bestaat niet");

      $forumname = $arr["name"];

	tabel_top("Nieuw topic in <a href=?action=viewforum&forumid=$id>$forumname</a>");
    }
    else
    {
      $res = mysql_query("SELECT * FROM topics WHERE id=$id") or sqlerr(__FILE__, __LINE__);

      $arr = mysql_fetch_assoc($res) or site_error_message("Forumfout", "Topic bestaat niet.");

      $subject = $arr["subject"];
    tabel_top("Reageer op topic: <a href=?action=viewtopic&topicid=$id>$subject</font></a>");
	}
	
    begin_frame();
    print("<form method=post action=?action=post>\n");

    if ($newtopic)
      print("<input type=hidden name=forumid value=$id>\n");

    else
      print("<input type=hidden name=topicid value=$id>\n");

    echo"<table class='table table-bordered table-striped'>";

    if ($newtopic)
      print("<tr>
	  <td>Onderwerp</td>
	  <td><input class='input-block-level' type=text maxlength=100 name=subject placeholder='Onderwerp'></td>
	  </tr>\n");

    if ($quote)
    {
       $postid = $_GET["postid"];
       if (!is_valid_id($postid))
         die;

//	   $res = mysql_query("SELECT posts.*, users.username FROM posts JOIN users ON posts.userid = users.id WHERE posts.id=$postid") or sqlerr(__FILE__, __LINE__);
	   $res = mysql_query("SELECT posts.*, users.username FROM posts LEFT JOIN users ON posts.userid = users.id WHERE posts.id=$postid") or sqlerr(__FILE__, __LINE__);

	   if (mysql_num_rows($res) != 1)
	     site_error_message("Foutmelding", "Er bestaat geen post met ID $postid.");

	   $arr = mysql_fetch_assoc($res);
    }

    print("<tr><td>Inhoud</td>
	<td><textarea id='editor_forum' class='input-block-level' name=body rows=10>".($quote?(("[quote=".htmlspecialchars($arr["username"])."]".stripslashes(htmlspecialchars($arr["body"]))."[/quote]")):"")."</textarea></td></tr>\n");
    print("<tr><td colspan=2 align=center><input type=submit value='Versturen'></td></tr>\n");
    echo"</table>";
    print("</form>\n");
    end_frame();

    //------ Get 10 last posts if this is a reply

    if (!$newtopic)
    {
	begin_frame();

    $postres = mysql_query("SELECT * FROM posts WHERE topicid=$id ORDER BY id DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);
    while ($post = mysql_fetch_assoc($postres))
    {
    //-- Get poster details
    $userres = mysql_query("SELECT * FROM users WHERE id=" . $post["userid"] . " LIMIT 1") or sqlerr(__FILE__, __LINE__);
    $user = mysql_fetch_assoc($userres);
	
	if($user['avatar']){
	$avatar = $user['avatar'];
	}else{
	$avatar = "img/default_avatar.png";
	}
	$posts_count = get_row_count("posts", "WHERE userid = '".$user['id']."'");
    $added = convertdatum($post["added"]) . " (" . (get_elapsed_time(sql_timestamp_to_unix_timestamp($post["added"]))) . " geleden)";
	
	$body = format_comment($post["body"]); 
	$body = stripslashes($body);

	?>
	<table class='table table-bordered table-striped'>
	<tr><th colspan='2'><?php echo "Geplaatst op $added" ?></th></tr>
	<tr>
	<td width='160px'>
	<table class='table table-bordered table-condensed'>
	<tr><td colspan='2'><div align='center'><img class='thumbnail forum-img' src='<?php echo $avatar ?>'></div></td></tr>
	<tr><td><strong>Naam</strong></td><td><?php echo"<a href=userdetails.php?id=". $user['id'] ."><b>".get_usernamesite($user['id']) ."</a></b>"?></td></tr>
	<tr><td><strong>Download</strong></td><td><?php echo mksize($user['downloaded']) ?></td></tr>
	<tr><td><strong>Upload</strong></td><td><?php echo mksize($user["uploaded"]) ?></td></tr>
	<tr><td><strong>Posts</strong></td><td><?php echo $posts_count ?></td></tr>
	</table>
	</td>
	<td style='box-shadow: inset 1px 1px 10px 2px black; padding:10px;'><?php echo stripslashes($body) ?></div></td>
	</tr>
	<tr><td colspan='2'></td></tr>
	</table>
	<?php
	}
	end_frame();
    }
  }
	
}
?>