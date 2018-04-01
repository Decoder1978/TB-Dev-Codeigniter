<?php
	print"<table class='table table-bordered table-condensed'>";
	$count = $this->db->count_all('peers');

	print"<h3>We hebben $count peers</h3>";
	print"<tr><th>Gebruiker</th><th>Torrent</th><th>Poort</th><th>Upload</th><th>Download</th><th>Verbindbaar</th><th>Delen</th><th>Gestart</th></tr>";

		//$sql = 'SELECT * FROM  `peers` LIMIT 0 , 30';
		
		//$result = $this->db->query($sql);
		if( $peerlist->num_rows() != 0 ) 
		{
		foreach($peerlist->result_array() as $row) 
			{
				
				//echo $row['userid'];
			$sql1 = 'SELECT * FROM users WHERE id = '. $row["userid"] .'';
			$result1 = $this->db->query($sql1);
			foreach ($result1->result_array() as $row1) 
				{
				print'<tr>';
				print'<td><a href="'. base_url('members/details/' . $row['userid'] . '') .'">' . $row1['username'] . '</a></td>';
				$sql2 = "SELECT * FROM torrents WHERE id = $row[torrent]";
				$result2 = $this->db->query($sql2);
				foreach($result2->result_array() as $row2) 
					{
					$smallname =substr(htmlspecialchars($row2["name"]) , 0, 45);
					if ($smallname != htmlspecialchars($row2["name"])) 
						{
						$smallname .= '...';
						}
					print'<td><a href="'. base_url('torrents/details/' . $row['torrent'] . '') .'">' . $smallname . '</td>';
					print'<td >' . $row['port'] . '</td>';
					if ($row['uploaded'] < $row['downloaded'])
					print'<td ><font color=red>' . byte_format($row['uploaded']) . '</font></td>';
					else
					if ($row['uploaded'] == '0')
					print'<td >' . byte_format($row['uploaded']) . '</td>';
					else
					print'<td ><font color=green>' . byte_format($row['uploaded']) . '</font></td>';
					print'<td >' . byte_format($row['downloaded']) . '</td>';
					if ($row['connectable'] == 'yes')
					print'<td ><font color=green>Ja</font></td>';
					else
					print'<td ><font color=red>Nee</font></td>';
					if ($row['seeder'] == 'yes')
					print'<td ><font color=green>Ja</font></td>';
					else
					print'<td ><font color=red>Nee</font></td>';
					print'<td >' . $row['started'] . '</td>';
					print'</tr>';
					}
				}
			}
		print'</table>';
		echo $this->pagination->create_links();
		}
		else {
		print'Nothing here';
		}
		
?>