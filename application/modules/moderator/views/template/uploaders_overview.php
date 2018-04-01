<?php

echo begin_frame('Uploader overzicht', 'primary');

print "<table class='table table-bordered table-striped'>";
print "<tr>";
print "<th>Gebruiker</th>";
print "<th>Functie</th>";
print "<th>Laatst&nbsp;gezien</th>";
print "<th>Uploads</th>";
print "<th>Laatste&nbsp;upload</th>";
if ($this->member->get_user_class() >= UC_BEHEERDER)
	print "<th>Verwijderen</th>";
print "</tr>";

	if($res->num_rows() > 0)
		{
		foreach($res->result_array() as $row)
			{
				
			$row2 = '';
			$row3 = '';
			
			$torrents = $this->db->where('owner', $row['id'])->get('torrents')->num_rows();
			print "<tr>";	
			print "<td width=160px>". $this->member->get_username($row['id']) ."</td>";
			print "<td>" . $this->member->get_user_class_name($row["class"]) . "</td>";
			print "<td>"  . timespan($row["last_access"], time(), 3) . "</td>";
			print "<td align=center>" . $torrents . "</td>";
			if ($torrents > 0)
				{
				$row2 = $this->db->query("SELECT * FROM torrents WHERE owner=$row[id] ORDER BY added DESC LIMIT 1")->result_array();
				//$row2 = mysql_fetch_array($res2);

				$added_limiet = time() - 86400 * 21;
				$row3 = $this->db->query("SELECT * FROM torrents WHERE owner=$row[id] AND added > FROM_UNIXTIME($added_limiet) ORDER BY added DESC LIMIT 1")->result_array();
				//$row3 = mysql_fetch_array($res3);
				if ($row3)
					$color= "";
				else
					$color= "red";

				print "<td><font color=$color>" . convertdatum($row2['added'], "No") . "</td>";
				}
			else
				print "<td> </td>";

			if ($this->member->get_user_class() >= UC_BEHEERDER)
				{
				if (!$row3)
					{
					print "<td width='140'>";
					print "<form method=post action=''>";			
					print "<input type=hidden name=action value=uploader_status>";
					print "<input type=hidden name=user_id value=".$row['id'].">";
					print "<input class='btn btn-danger btn-block' type=submit value='Uploader status ontnemen'></form>";
					print "</td>";
					}
				else
					print "<td> </td>";
				}
			print "</tr>";
			}
		}else{
		echo '<tr><td class="danger" colspan="6"><h5>Geen uploaders aanwezig...</h5></td></tr>';	
		}
	
print "</tr></table>";

echo end_frame();

