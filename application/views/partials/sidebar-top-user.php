
	<?php
	
		//$credits = $this->session->userdata('credits');
		$user = $this->db->where('id', $this->session->userdata('user_id'))->get('users')->row_array();
		$credits = '10';
		$messages = '3';
		$unread = '2';
		$outmessages = '0';
		$which_mod = 'RCR1984';
		$maxtorrents = $user['maxtorrents'];
		//$peers = get_row_count("peers", "WHERE userid=$CURUSER[id]");
		$peers = $this->db->where('userid', $this->session->userdata('user_id'))->get('peers')->num_rows();
		//$seeding = get_row_count("peers", "WHERE userid=$CURUSER[id] AND seeder='yes'");
		$seeding = $this->db->where('userid', $this->session->userdata('user_id'))->where('seeder', 'yes')->get('peers')->num_rows();
		$leeching = $peers - $seeding;
		$uped = byte_format($this->session->userdata('uploaded'));
		$downed = byte_format($this->session->userdata('downloaded'));
		$verschil = byte_format($uped - $downed);
		$donor = $user['donor'];
		$warned = $this->session->userdata('warned');
		//$ratio = number_format((($downed > 0) ? ($uped / $downed) : 0),2);
		$ratio = $this->member->get_userratio($this->session->userdata('user_id'));
		$cover = 'test';
	print"<table class='table table-bordered' style='width: 100%; background: white;'>";
	print"<tr><td rowspan='3' width='100px' >". $this->member->get_user_avatar($this->session->userdata('user_id')) ."</td>
			  <td colspan=2 width=120px><strong>". $this->member->get_username($this->session->userdata('user_id')) ."</strong></td>
			  <td>Ontvangen</td><td>" . $downed . "</td>
			  <td><a href=credits.php>Credits</a></td><td>". $credits ." punten</td>
			  </tr>";
	print"<tr><td><a href=inbox.php>Postvak-in</a></td>
			  <td>" . $messages . "&nbsp;-&nbsp;" . $unread . "</td>
			  <td>Verzonden</td>
			  <td>" . $uped . "</td>
			  <td>Torrents</td>
			  <td>" . $maxtorrents . "&nbsp;<span class='glyphicon glyphicon-glyphicon glyphicon-arrow-up'></span>&nbsp;" . $seeding . "&nbsp;<span class='glyphicon glyphicon-glyphicon glyphicon-arrow-down'></span>&nbsp;" . $leeching . "</td>
			  </tr>";
	print"<tr><td><a class=altlink_white href=outbox.php>Postvak-uit</a></td>
			  <td>" . $outmessages . "</td>
			  <td>Ratio</td>
			  <td><font color=" . $this->member->get_ratio_color($ratio) . ">" . $ratio . "</font></td>
			  <td>Moderator</td><td>". $which_mod ."</td>
			  </tr>";
	print"</table>";
	?>
