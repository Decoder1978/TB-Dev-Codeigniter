<?php 

    $pn = 0;

	$pc = $res->num_rows();	
	
	
	$r = $this->db->query("SELECT lastpostread FROM readposts WHERE userid=" . $this->session->userdata('user_id') . " AND topicid=$topicid");

    $a = $r->row_array();

    $lpr = $a['lastpostread'];

    if (!$a)
      $this->db->query("INSERT INTO readposts (userid, topicid) VALUES($userid, $topicid)");

	echo begin_frame('<a href=?action=viewforum&forumid='. $forumid.'>'. $forum.'</a> &gt;&gt; ' . stripslashes($subject) . '','primary');

    foreach($res->result_array() as $arr)
    {
    ++$pn;
	$postid 	= $arr["id"];
	$posterid 	= $arr["userid"];
	$added 		= unix_to_human($arr["added"]);

    //---- Get poster details
	$res222 	= $this->db->query("SELECT * FROM users WHERE id=$posterid");
	$arr222 	= $res222->row_array();
	
	if ($pn == $pc)
		{
        if ($postid > $lpr)
        $this->db->query("UPDATE readposts SET lastpostread=$postid WHERE userid=$userid AND topicid=$topicid");
		}

	$body = $arr["body"]; 
	$body = stripslashes($body);

	$body .= $this->forums->get_edit_by($arr['editedby'], $arr);

	$avatar = $this->member->get_user_avatar($userid);
	$posts_count = $this->db->query('SELECT * FROM posts WHERE userid = "'. $arr222['id'].'"')->num_rows();
	//$data['response_buttons'] = $this->forums->get_response_buttons($locked);
	$response_buttons = $this->forums->get_response_buttons($locked, $maypost, $topicid, $postid, $posterid);
	// TODO: push to template from here and review code 
	

	
	echo '<table class="table table-bordered">';
	echo '<tr><th colspan="2">Geplaatst op '. $added.' <span class="pull-right">';

	echo  $response_buttons;

	
	echo '</span></th></tr>';
	echo '<tr>';
	echo '<td style="width: 220px;">';
	echo '<table class="table table-bordered table-condensed">';
	echo '<tr><td colspan="2"><div align="center">'. $avatar .'</div></td></tr>';
	echo '<tr><td>Naam</td><td>'. $this->member->get_username($posterid) .'</td></tr>';
	echo '<tr><td>Download</td><td>'. byte_format($arr222["downloaded"]) .'</td></tr>';
	echo '<tr><td>Upload</td><td>'. byte_format($arr222["uploaded"]) .'</td></tr>';
	echo '<tr><td>Posts</td><td>'. $posts_count .'</td></tr>';
	echo '</table>';
	echo '</td>';
	echo'<td style="padding:10px;">'. stripslashes($body) .'</div></td>';
	echo '</tr>';
	echo '<tr><td colspan="2"></td></tr>';
	echo '</table>';
	}


	echo $template; 

	echo end_frame();
	

?>