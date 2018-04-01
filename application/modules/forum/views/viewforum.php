<?php 

    $userid = $this->session->userdata('user_id');
	echo begin_frame('<a href=forums.php> &gt; '. $forumname .'</a>','primary');

	$forumid 	= $this->uri->segment(3);
	$arr 		= $this->forums->get_forum_access_levels($forumid);
	$maypost 	= $this->member->get_user_class() >= $arr["write"] && $this->member->get_user_class() >= $arr["create"];
	
	if ($topicsres->num_rows() > 0)
    {
      //print($menu);

      print("<table class='table table-bordered'>");

      print("<tr><th>Topic</th><th width='100px'>Reacties</th><th width='100px'>Bekeken</th><th width='100px'>Auteur</th><th width='300px'>Laatste berichten</th>\n");

      print("</tr>\n");

		foreach($topicsres->result_array() as $topicarr)
		{
			$topicid 		= $topicarr["id"];
			$topic_userid 	= $topicarr["userid"];
			$topic_views 	= $topicarr["views"];
			$views 			= number_format($topic_views);
			$locked 		= $topicarr["locked"] == "yes";
			$sticky 		= $topicarr["sticky"] == "yes";

			//---- Get reply count

			$arr 			= $this->db->query("SELECT * FROM posts WHERE topicid=" .$topicid ."")->num_rows();
			$posts 			= $arr;
			$replies 		= max(0, $posts - 1);

			//---- Get userID and date of last post

			$res 			= $this->db->query("SELECT * FROM posts WHERE topicid=$topicid ORDER BY id DESC LIMIT 1");
			$arr 			= $res->row_array();
			$lppostid 		= 0 + $arr["id"];
			$lpuserid 		= 0 + $arr["userid"];
			$lpadded 		= "<nobr>" . unix_to_human($arr["added"]) . "</nobr>";

			//------ Get name of last poster
			$lpusername 	= $this->member->get_username($lpuserid);
			//------ Get author
			$lpauthor 		= $this->member->get_username($topic_userid);


			//---- Print row

			$r = $this->db->query("SELECT lastpostread FROM readposts WHERE userid=$userid AND topicid=$topicid");
			$a = $r->row_array();
			
			$new 			= !$a || $lppostid > $a['lastpostread'];
			$topicpic 		= ($locked ? ($new ? "icon-new-sticky" : "icon-nonew-sticky") : ($new ? "icon-new" : "icon-nonew"));
			$subject 		= ($sticky ? "Sticky: " : "") . "<a class='' href=". base_url('forum/viewtopic/'. $topicid .'') .">" . stripslashes($topicarr["subject"]) . "</a>";

			echo"<tr>";
			echo"<td>";
			echo"<table>";
			echo"<td style='width: 34px;'><img src='http://placehold.it/24x24'></td>";
			echo"<td>$subject</td>";
			echo"</table>";
			echo"</td>";
			echo"<td>$replies</td>";
			echo"<td>$views</td>";
			echo"<td>$lpauthor</td>";
			echo"<td>$lpadded&nbsp;door&nbsp;$lpusername</td>";
			echo"</tr>";
		} // foreach

		echo("</table>\n");

	}else{
	if ($maypost){?> 
	<div class="row">
		<div class="col-xs-12">
			<div class="alert alert-info">Er zijn nog geen berichten in dit forum....Maak jij er een?</div>
		</div>
	</div>
	<?php } 	
	}
	
	if (!$maypost){?>
	
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-warning"><i><h4>Sorry maar u heeft niet de juiste rechten om een topic te creeren....</h4></i></div>
		</div>
	</div>
	
	<?php } ?>

	
	<div class="row">
	<div class="col-xs-6">
	
	<?php if ($maypost){?> 
	
    <a class="btn btn-success btn-sm" href="<?php echo base_url('forum/newtopic/'. $forumid .'')?> "><span class="glyphicon glyphicon-pencil"></span> Nieuw onderwerp</a>&nbsp;&nbsp;&nbsp;
	<?php } ?>
	
	<a class="btn btn-info btn-sm" href="<?php echo base_url('forum/viewunread') ?>"><span class="glyphicon glyphicon-eye-open"></span>  Ongelezen berichten </a>

	
	</div>
	<div class='col-xs-3'>

	</div>	
	<div class='col-xs-3'>
	<?php echo $this->forums->insert_quick_jump_menu($forumid); ?>
	</div>
	</div>
  	</div>
	</div>
