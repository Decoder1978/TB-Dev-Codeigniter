<?php 
begin_frame();
$count = 1;
$res = $this->db->query("SELECT id, name, filename, owner FROM torrents ORDER BY id DESC LIMIT 1000");
foreach ($res->result_array() as $row)
	{

	//$test = file_get_contents(base_url('uploads/torrents/' . $row['id'] .'.torrent'));
	$test = file_get_contents(base_url('application/modules/members/controllers/Members.php'));
	
	echo $test;
	$ann_1 = substr_count($test, "announce.php?passkey");
	$ann_2 = substr_count($test, ":announce-list");

	if (substr_count($test, "announce.php?passkey") > 1 && substr_count($test, ":announce-list") > 0)
		{
		print "".$count++." - <a class=altlink_white href=details.php?id=".$row['id'].">".$row['name']."</a> - Door:<a class=altlink_white href=userdetails.php?id=".$row['owner'].">".get_username($row['owner'])."</a>";
		print "<br>";
		}
	}
end_frame();
