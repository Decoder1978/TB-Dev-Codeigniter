<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends MY_Controller {


	function __construct()
	{
		parent::__construct();
		
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}
		
		$this->load->library('forums');		
		$this->load->model('forummodel');
		$this->load->language('forum/forum_langs');

	}
	

	public function index()
	{
		$forums = $this->db->query("select id from forums");
		foreach($forums->result_array() as $forum)
		{
			$postcount = 0;
			$topiccount = 0;
			$topics = $this->db->query("select id from topics where forumid=$forum[id]");
			foreach($topics->result_array() as $topic)
			{
				$arr = $this->db->query("select * from posts where topicid=$topic[id]")->num_rows();
				$postcount += $arr;
				++$topiccount;
			}
			$this->db->query("update forums set postcount=$postcount, topiccount=$topiccount where id=$forum[id]");
		}	
		$data['forums_res'] = $this->db->query("SELECT * FROM forums ORDER BY sort, name");
		//echo $this->lang->line('hello');
		$this->template('index', $data);
	}
	
	
	
	
	public function quote()
	{
		$topicid 	= $this->uri->segment(3);
		$postid 	= $this->uri->segment(4);
		
		if (!(int)($topicid))
			site_error_message("Foutmelding", "Ongeldig topic ID $topicid.");

		$forumid 	= $this->forums->get_forum_id($topicid);
		$arr 		= $this->forums->get_forum_access_levels($forumid) or die;
		
		if ($this->member->get_user_class() < $arr["read"]) {
			site_error_message("Foutmelding", "U heeft geen toegang tot dit forum.");
			die;
			}
	

    $data['quote'] = $this->forums->insert_compose_frame($topicid, false, true, $postid);
	$this->template('template/quote', $data);
	}
	


	
	
	
	
	public function edit()
	{
  	add_css('summernote/summernote.css');
	add_js('summernote/summernote.min.js'); 

    $postid = $this->uri->segment(3);
	$data['postid'] = $postid;
    $topicid = $this->uri->segment(4);
	$data['topicid'] = $topicid;
	
    if (!(int)($postid))
    die;

    $res = $this->db->query("SELECT * FROM posts WHERE id=$postid");

		if ($res->num_rows() != 1)
		site_error_message("Foutmelding", "Geen post met ID $postid");

		$arr = $res->row_array();
		$data['arr'] = $arr;

		$res2 = $this->db->query("SELECT locked FROM topics WHERE id = " . $arr["topicid"]);
		$arr2 = $res2->row_array();

 		//if (mysql_num_rows($res) != 1)
		//	site_error_message("Foutmelding", "Geen topic geassocieerd met $postid.");

		$locked = ($arr2["locked"] == 'yes');

    if (($this->session->userdata('user_id') != $arr["userid"] || $locked) && $this->member->get_user_class() < UC_MODERATOR)
      site_error_message("Foutmelding", "Geweigerd!");

    if ($this->input->post('submit'))
    {
    	$body = $this->input->post('body');

    	if ($body == "")
    	  site_error_message("Foutmelding", "Inhoud kan niet leeg zijn!");

      $body = $body;

      $editedat = time();
	  
	  $data = array(
	  'body' => $body,
	  'editedat' => $editedat,
	  'editedby' => $this->session->userdata('user_id'),
	  'editedbyusername' => $this->session->userdata('username')
	  );

	  $this->db->where('id', $postid);
	  $this->db->update('posts', $data);
     // mysql_query("UPDATE posts SET body=$body, editedat=$editedat, editedby=$CURUSER[id] WHERE id=$postid") or sqlerr(__FILE__, __LINE__);

		redirect('forum/viewtopic/'.$topicid.'#'. $postid .'');
	}


	$this->template('template/editpost', $data);
  	}







	
	public function replay()
	{
	$topicid = $this->uri->segment(3); //$_GET["topicid"];

	$forumid = $this->forums->get_forum_id($topicid);
	$arr = $this->forums->get_forum_access_levels($forumid);
	
	if ($this->member->get_user_class() < $arr["read"]) {
		$this->session->set_flashdata('danger', 'U heeft geen toegang tot dit forum!');
 		redirect('forum/viewtopic/'. $topicid .'');	
		}

    if (!(int)($topicid))
	{
		$this->session->set_flashdata('danger', 'ID ontbreekt...sorry maar ik kan deze opdracht niet uitvoeren !!');
 		redirect('forum/viewtopic/'. $topicid .'');		
	}

    $data['replay'] = $this->forums->insert_compose_frame($topicid, false);
	$this->template('template/replay', $data);
	}
	


	public function setsticky()
	{
	$topicid = 0 + $this->input->post('topicid'); //$HTTP_POST_VARS["topicid"];

    if (!$topicid || $this->member->get_user_class() < UC_MODERATOR)
	{
		$this->session->set_flashdata('danger', 'ID ontbreekt...sorry maar ik kan deze opdracht niet uitvoeren !!');
 		redirect('forum/viewtopic/'. $topicid .'');
	}

	$sticky = $this->db->escape($this->input->post('sticky'));
	
    $this->db->query("UPDATE topics SET sticky=$sticky WHERE id=$topicid");

	$this->session->set_flashdata('info', 'Gelukt.....sticky status is aangepast voor dit topic !!');
 	redirect('forum/viewtopic/'. $topicid .'');
	}
	
	
	
	
	
	
	
	public function setlocked()
	{

	$topicid = 0 + $this->input->post('topicid'); //$HTTP_POST_VARS["topicid"];

    if (!$topicid || $this->member->get_user_class() < UC_MODERATOR)
	{
		$this->session->set_flashdata('danger', 'ID ontbreekt...sorry maar ik kan deze opdracht niet uitvoeren !!');
 		redirect('forum/viewtopic/'. $topicid .'');
	}

	$locked = $this->db->escape($this->input->post('locked'));
	
    $this->db->query("UPDATE topics SET locked=$locked WHERE id=$topicid");

	$this->session->set_flashdata('info', 'Gelukt.....locked status is aangepast voor dit topic !!');
 	redirect('forum/viewtopic/'. $topicid .'');
	}
	
	
	
	
	
	
	
	public function renametopic()
	{
	$topicid = 0 + $this->input->post('topicid'); //$HTTP_POST_VARS["topicid"];

    if (!$topicid || $this->member->get_user_class() < UC_MODERATOR)
	{
		$this->session->set_flashdata('danger', 'ID ontbreekt...sorry maar ik kan deze opdracht niet uitvoeren !!');
 		redirect('forum/viewtopic/'. $topicid .'');
	}
	
  	$subject = $this->input->post('subject'); //$HTTP_POST_VARS['subject'];

  	if($subject == '')
	{
	$this->session->set_flashdata('danger', 'Je moet wel een onderwerp invullen he....');
 	redirect('forum/viewtopic/'. $topicid .'');		
	}

  	$subject = $this->db->escape($subject);

  	$this->db->query("UPDATE topics SET subject=$subject WHERE id=$topicid");

	$this->session->set_flashdata('info', 'Gelukt.....De topic titel is aangepast!!');
 	redirect('forum/viewtopic/'. $topicid .'');
	}
	
	
	
	
	
	
	
	public function movetopic()
	{
  
    $forumid = $this->input->post('forumid');

    $topicid = $this->input->post('topicid');

    if (!(int)($forumid) || !(int)($topicid) || $this->member->get_user_class() < UC_MODERATOR)
	{
		$this->session->set_flashdata('danger', 'Gegevens ontbreken....of je bent geen Moderator....sorry maar ik kan deze opdracht niet uitvoeren !!');
 		redirect('forum/viewtopic/'. $topicid .'');
	}

    // Make sure topic and forum is valid

    $res = $this->db->query("SELECT minclasswrite FROM forums WHERE id=$forumid");

    if ($res->num_rows() != 1)
	{
		$this->session->set_flashdata('danger', 'Forum bestaat niet....sorry maar ik kan deze opdracht niet uitvoeren !!');
 		redirect('forum/viewtopic/'. $topicid .'');		
	}


    $arr = $res->row_array();

    if ($this->member->get_user_class() < $arr['minclasswrite'])
    die('Hier dat stomme arr dingetje hier boven regel 272 forum.php');

    $res = $this->db->query("SELECT subject,forumid FROM topics WHERE id=$topicid");

    if ($res->num_rows() != 1)
	{
		$this->session->set_flashdata('danger', 'Topic bestaat niet....sorry maar ik kan deze opdracht niet uitvoeren !!');
 		redirect('forum/viewtopic/'. $topicid .'');			
	}


    $arr = $res->row_array();

    if ($arr["forumid"] != $forumid)
	{
	$this->db->query("UPDATE topics SET forumid=$forumid WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);
	}

	$this->session->set_flashdata('info', 'Gelukt...ik heb deze topic kunnen verplaatsen !');
 	redirect('forum/viewtopic/'. $topicid .'');	
	}
	
	
	
	
	
	
	
	public function deletetopic()
	{
    $forumid = $this->input->post('forumid');
	$topicid = $this->input->post('topicid');


    if (!(int)($topicid) || $this->member->get_user_class() < UC_ADMINISTRATOR)
	{
		$this->session->set_flashdata('danger', 'Gegevens ontbreken....of je bent geen Administrator....sorry maar ik kan deze opdracht niet uitvoeren !!');
 		redirect('forum/viewtopic/'. $topicid .'');		
	}

	$this->db->query("DELETE FROM topics WHERE id=$topicid");

    $this->db->query("DELETE FROM posts WHERE topicid=$topicid");

    $this->session->set_flashdata('info', 'Gelukt...ik heb deze topic kunnen verwijderen !');
 	redirect('forum/viewforum/'. $forumid .'');	
	}	
	

	
	
	
	
	
	
	public function forum_admin()
	{
	if ($this->input->post('action') == "addforum")
		{
			$this->forummodel->insert_forum();
		}		
		
	if ($this->input->post('action') == "editforum")
		{
			$this->forummodel->edit_forum();
		}		

	if ($this->input->post('action') == "del")
		{
			$this->forummodel->del_forum();
		}
		
	$this->template('admin/index');
	}	
	


	public function forum_delete()
	{
		$id = $this->uri->segment(3);
		$this->forummodel->del_forum($id);
	}	
	
	
	public function forum_edit()
	{
		$data['id'] = $this->uri->segment(3);
		$this->template('template/edit_forum_modal', $data);
	}

	public function viewtopic()
	{
	$topicid = $this->uri->segment(3);
	$data['topicid'] = $topicid;

    if (!(int)($topicid))
    die;

    $userid = $this->session->userdata('user_id');//$CURUSER["id"];
    $data['userid']  = $userid;
	$this->db->query("UPDATE topics SET views = views + 1 WHERE id=$topicid");

    //------ Get topic info

    $res = $this->db->query("SELECT * FROM topics WHERE id=$topicid");

    $arr = $res->row_array() or site_error_message("Forumfout", "Topic bestaat niet");

    $locked 	= $arr["locked"] == 'yes';
    $subject 	= $arr["subject"];
    $sticky 	= $arr["sticky"] == "yes";
    $forumid 	= $arr["forumid"];

    $data['locked'] 	= $locked;
    $data['subject'] 	= $subject;
    $data['sticky'] 	= $sticky;
    $data['forumid'] 	= $forumid;

	//------ Get forum
	$res 		= $this->db->query("SELECT * FROM forums WHERE id=$forumid");
	$arr	 	= $res->row_array() or die("Forum = NULL");
	$forum 		= $arr["name"];
	$data['forum'] = $arr["name"];

    if ($this->session->userdata('class') < $arr["minclassread"])
		site_error_message("Foutmelding", "Je mag dit topic niet bekijken");

    //------ Get post count
	//$postcount 	= $this->db->query("SELECT * FROM posts WHERE topicid=$topicid")->num_rows();

	//------ Get posts
	$res 		= $this->db->query("SELECT * FROM posts WHERE topicid=$topicid ORDER BY id LIMIT 20");
	$data['res'] = $res;

    //site_header("Bekijk topic");
	//tabel_top("<a href=?action=viewforum&forumid=$forumid><font color=white>$forum</font></a> &gt; " . stripslashes($subject) . "");
    //begin_frame();
	//insert_quick_jump_menu($forumid);
    //print($pagemenu);
	$template  = '';
	







  
	//var_dump($res->result_array());


    //------ Mod options
	if ($this->member->get_user_class() >= UC_MODERATOR)
	{
	   // attach_frame();

	$template .= $this->load->view('template/mod_options_modal', $data);
	}


	$maypost = FALSE;

  	if ($locked && $this->member->get_user_class() < UC_MODERATOR)
  		$template .="<div class='alert alert-danger'>Dit topic is gesloten. Er kunnen geen nieuwe posts worden gemaakt.</div>";

  	else
  	{
	    $arr = $this->forums->get_forum_access_levels($forumid) or die;

	    if ($this->member->get_user_class() < $arr["write"])
	    $template .="<div class='alert alert-danger'>Je mag niet in dit forum posten.</div>";

	    else
	    $maypost = TRUE;
	}

	$template .="<a class='btn btn-default btn-sm' href='forums.php?action=viewunread' value=''><span class='glyphicon glyphicon-eye-open'></span> Ongelezen berichten</a>&nbsp;&nbsp;&nbsp;";
    if ($maypost)
    {
	$template .="<a class='btn btn-info btn-sm' href='". base_url('forum/replay/'. $topicid .'') ."' value=''><span class='glyphicon glyphicon-pencil'></span> Reageer op deze topic</a>&nbsp;&nbsp;&nbsp;";
    }
  	if ($this->member->get_user_class() >= UC_MODERATOR)
	{

	$template .="<button class='btn btn-danger btn-sm' data-target='#myModal' data-toggle='modal'><span class='glyphicon glyphicon-wrench'></span> Moderator Opties</button>&nbsp;&nbsp;&nbsp;";
	}



    //------ Forum quick jump drop-down
    $template .="</tr></table>";
  	//print($pagemenu);

	
	$data['maypost'] = $maypost;
	$data['template'] = $template;
	$this->template('viewtopic', $data);
		
	}

	
	public function viewforum()
	{
		
    $forumid = $this->uri->segment(3);//$_GET["forumid"];

    if (!(int)($forumid))
      $forumid = 1; //die;

    //$page = $_GET["page"];
	$page = '';
	$num = '';

    $userid = $this->session->userdata('user_id');//$CURUSER["id"];

    //------ Get forum name

    $res = $this->db->query("SELECT name, minclassread FROM forums WHERE id=$forumid");

    $arr = $res->row_array();

    $data['forumname'] = $arr["name"];

    if ($this->member->get_user_class() < $arr["minclassread"])
      die("Geen rechten");

    //------ Page links

    //------ Get topic count

	
	//TODO:  add or remove this completly from users table
    $perpage = $this->session->userdata('topicsperpage');//$CURUSER["topicsperpage"]; 
	if (!$perpage) $perpage = 20;

    $res = $this->db->query("SELECT COUNT(*) FROM topics WHERE forumid=$forumid") or sqlerr(__FILE__, __LINE__);

    $arr = $res->row_array();

	
	
   // $num = $arr[0];

/*    if ($page == 0)
      $page = 1;

    $first = ($page * $perpage) - $perpage + 1;

    $last = $first + $perpage - 1;

    if ($last > $num)
      $last = $num;

    $pages = floor($num / $perpage);

    if ($perpage * $pages < $num)
      ++$pages;

    //------ Build menu

    $menu = "<p align=center><b>\n";

    $lastspace = false;

    for ($i = 1; $i <= $pages; ++$i)
    {
    	if ($i == $page)
        $menu .= "<font class=red>$i</font>\n";

      elseif ($i > 3 && ($i < $pages - 2) && ($page - $i > 3 || $i - $page > 3))
    	{
    		if ($lastspace)
    		  continue;

  		  $menu .= "... \n";

     		$lastspace = true;
    	}

      else
      {
        $menu .= "<a href=?action=viewforum&forumid=$forumid&page=$i>$i</a>\n";

        $lastspace = false;
      }
      if ($i < $pages)
        $menu .= "</b>|<b>\n";
    }

    $menu .= "<br>\n";

    if ($page == 1)
      $menu .= "<font class=red>&lt;&lt; Vorige</font>";

    else
      $menu .= "<a href=?action=viewforum&forumid=$forumid&page=" . ($page - 1) . ">&lt;&lt; Vorige</a>";

    $menu .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    if ($last == $num)
      $menu .= "<font class=red>Volgende &gt;&gt;</font>";

    else
      $menu .= "<a href=?action=viewforum&forumid=$forumid&page=" . ($page + 1) . ">Volgende &gt;&gt;</a>";

    $menu .= "</b></p>\n";

    $offset = $first - 1;*/

    //------ Get topics data

    //$data['topicsres'] = $this->db->query("SELECT * FROM topics WHERE forumid=$forumid ORDER BY sticky, lastpost DESC LIMIT $offset,$perpage");
    $data['topicsres'] = $this->db->query("SELECT * FROM topics WHERE forumid=$forumid ORDER BY sticky, lastpost DESC LIMIT $perpage");

	$this->template('viewforum', $data);
	}
	
	
	
	public function newtopic()
	{
		$forumid = $this->uri->segment(3);//$_GET["forumid"];
		$arr = $this->forums->get_forum_access_levels($forumid);
		
		if ($this->member->get_user_class() < $arr["read"]) {
			$this->session->set_flashdata('danger', 'U heeft geen toegang tot dit forum.');
			redirect('forum');			
			}

		if (!(int)($forumid)){
			$this->session->set_flashdata('danger', 'Geen forum gegevens ontvangen!');
			redirect('forum');
			}
		
		$data['compose'] = $this->forums->insert_compose_frame($forumid);
		
		$this->template('newtopic', $data);
	}
	
	
	public function post()
	{
		
		$forumid = 0 + '';
		$topicid = 0 + '';
		$subject = '';
		
		if($this->input->post('forumid'))
		{ 
			$forumid = $this->input->post('forumid');
		}
		if($this->input->post('topicid'))
		{ 
			$topicid = $this->input->post('topicid');
		}

		//$forumid = 0 + $_POST["forumid"];
		//$topicid = 0 + $_POST["topicid"];

    if (!(int)($forumid) && !(int)($topicid))
      site_error_message("Fout", "ID bestaat niet.");

    $newtopic = $forumid > 0;

    $subject = $this->input->post('subject'); //_POST["subject"];

    if ($newtopic)
    {
      $subject = trim($subject);

      if (!$subject)
        site_error_message("Foutmelding", "Je moet een onderwerp opgeven.");

	//TODO: check this out max length :S 
	
      if (strlen($subject) > 5000)
        site_error_message("Foutmelding", "Het onderwerp is langer dan $maxsubjectlength tekens.");
    }
    else
      $forumid = $this->forums->get_topic_forum($topicid) or die("Ongeldig topic ID");

    //------ Make sure sure user has write access in forum

    $arr = $this->forums->get_forum_access_levels($forumid) or die("Ongeldig forum ID");

    if ($this->member->get_user_class() < $arr["write"] || ($newtopic && $this->member->get_user_class() < $arr["create"]))
      site_error_message("Foutmelding", "Toegang geweigerd");

    $body = trim($_POST["body"]);

    if ($body == "")
      site_error_message("Foutmelding", "Geen inhoud");

    //$userid = $CURUSER["id"];
    $userid 	= $this->session->userdata('user_id');
    $username 	= $this->session->userdata('username');

    if ($newtopic)
    {
      //---- Create topic

      //$subject = sqlesc($subject);

	  $data = array(
	  'userid' => $userid,	  
	  'username' => $username,
	  'added' => time(),
	  'forumid' => $forumid,
	  'subject' => $subject
	  );
	  
	  $this->db->insert('topics', $data);
      //mysql_query("INSERT INTO topics (userid, forumid, subject) VALUES($userid, $forumid, $subject)") or sqlerr(__FILE__, __LINE__);

      //$topicid = mysql_insert_id() or site_error_message("Foutmelding", "Geen topic ID. Probeer opnieuw");
      $topicid = $this->db->insert_id() or site_error_message("Foutmelding", "Geen topic ID. Probeer opnieuw");
    }
    else
    {
      //---- Make sure topic exists and is unlocked

      $res = $this->db->query("SELECT * FROM topics WHERE id=$topicid");

      $arr = $res->row_array() or die("Topic id n/a");

      if ($arr["locked"] == 'yes' && get_user_class() < UC_MODERATOR)
        site_error_message("Foutmelding", "Dit topic is gesloten.");

      //---- Get forum ID

      $forumid = $arr["forumid"];
    }

    //------ Insert post

    //$added = "'" . get_date_time() . "'";

    //$body = sqlesc($body);
	
	$data = array(
	'topicid' => $topicid,
	'userid' => $userid,
	'username' => $username,
	'added' => time(),
	'body' => $body
	);

	$this->db->insert('posts', $data);
   // mysql_query("INSERT INTO posts (topicid, userid, added, body) " .
   // "VALUES($topicid, $userid, $added, $body)") or sqlerr(__FILE__, __LINE__);

    //$postid = mysql_insert_id() or die("Post id n/a");
    $postid = $this->db->insert_id() or die("Post id n/a");

    //------ Update topic last post

    $this->forums->update_topic_last_post($topicid);

    //------ All done, redirect user to the post

    //$headerstr = "Location: $BASEURL/forums.php?action=viewtopic&topicid=$topicid&page=last";

    if ($newtopic)
		redirect('forum/viewtopic/'. $topicid.'');
      //header($headerstr);

    else
		redirect('forum/viewtopic/'. $topicid.'');
		//header("$headerstr#$postid");

    die;
		
	}
	
	
	
	
	
	
	
	
	
	
	
}
