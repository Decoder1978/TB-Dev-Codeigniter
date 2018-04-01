<?php echo begin_frame('Torrent Empire - Forums','primary'); ?>

<table class='table table-bordered table-condensed'>
<tr><th>Forum</th><th style="width: 180px;">&nbsp;</th><th style="width: 200px;">Laatste berichten</th></tr>
<?php
  foreach($forums_res->result_array() as $forums_arr)
  {
    if ($this->member->get_user_class() < $forums_arr["minclassread"])
      continue;

    $forumid = $forums_arr["id"];

    $forumname = htmlspecialchars($forums_arr["name"]);

    $forumdescription = htmlspecialchars($forums_arr["description"]);

    $topiccount = number_format($forums_arr["topiccount"]);

    $postcount = number_format($forums_arr["postcount"]);

    $lastpostid = $this->forums->get_forum_last_post($forumid);

    // Get last post info

    $post_res = $this->db->query("SELECT added,topicid,userid FROM posts WHERE id=$lastpostid");

    if ($post_res->num_rows() == 1)
    {
      $post_arr = $post_res->row_array() or die("Ongeldig forum last_post");

      $lastposterid = $post_arr["userid"];

      $lastpostdate = unix_to_human($post_arr["added"]);

      $lasttopicid = $post_arr["topicid"];

      $user_res = $this->db->query("SELECT username FROM users WHERE id=$lastposterid");

      $user_arr = $user_res->row_array();

      $lastposter = htmlspecialchars($user_arr['username']);

      $topic_res = $this->db->query("SELECT subject FROM topics WHERE id=$lasttopicid");

      $topic_arr = $topic_res->row_array();

      $lasttopic = htmlspecialchars($topic_arr['subject']);

//      $lastpost = "<nobr>$lastpostdate&nbsp;" .
//      "door <a href=userdetails.php?id=$lastposterid><b>$lastposter</b></a><br>" .
//      "in <a href=?action=viewtopic&topicid=$lasttopicid&amp;page=p$lastpostid#$lastpostid><b>" . stripslashes($lasttopic) . "</b></a></nobr>";

      $lastpost = "$lastpostdate&nbsp;<br>door <a href=userdetails.php?id=$lastposterid><b>$lastposter</b></a>";
 	  
      $r = $this->db->query("SELECT lastpostread FROM readposts WHERE userid=". $this->session->userdata('user_id') ." AND topicid=$lasttopicid");

      $a = $r->row_array();

      if ($a && $a['lastpostread'] >= $lastpostid)
        $img = "icon-nonew";
      else
        $img = "icon-new";
    }
    else
    {
      $lastpost = "Geen berichten...<br>bent u de eerste?";
      $img = "unlocked";
    }
	?>

<tr><td>	
	<div class="media">
		<div class="media-left">
		<a href="#"><img class="media-object" src="http://placehold.it/44x44" alt="..."></a>
		</div>
		<div class="media-body">
			<h5 class="media-heading"><a href="<?php echo  base_url('forum/viewforum/'. $forumid .'')?>"><b><?php echo $forumname?></b></a></h5>
			<small><i><?php echo $forumdescription; ?></i></small>
		</div>
	</div>	
	</td>
	<td>Onderwerpen: <strong><?php echo $topiccount ?></strong> <br />Berichten: <?php echo $postcount ?></td><td><?php echo $lastpost ?></td></tr>
	<?php } ?>
	</table>
	<?php

	echo '<div class="pull-left">';
	echo"<a class='btn btn-default btn-sm' href=?action=search><span class='glyphicon glyphicon-search'></span> Zoeken</a>&nbsp;&nbsp;&nbsp;";
	echo"<a class='btn btn-info btn-sm' href=?action=viewunread><span class='glyphicon glyphicon-eye-open'></span> Ongelezen berichten</a>&nbsp;&nbsp;&nbsp;";
	echo"<a class='btn btn-success btn-sm' href=?catchup><span class='glyphicon glyphicon-thumbs-up'></span> Alles gelezen</a>&nbsp;&nbsp;&nbsp;";
	echo '</div>';
	echo '<div class="pull-right">';
	if($this->member->get_user_class() >= UC_ADMINISTRATOR)
	{
	echo"<a class='btn btn-danger btn-sm' href=". base_url('forum/forum_admin') ."><span class='glyphicon glyphicon-wrench'></span> Forum Admin</a>&nbsp;&nbsp;&nbsp;";
	}
	echo '</div>';	
	
	echo end_frame();

?>