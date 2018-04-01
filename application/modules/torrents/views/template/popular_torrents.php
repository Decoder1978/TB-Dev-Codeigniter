<?php echo begin_frame('Populaire torrents', 'default');
		$populair = $this->db->query("SELECT * FROM torrents WHERE visible = 'yes' ORDER BY seeders DESC LIMIT 5 ")->result_array();
		echo '<table class="table table-bordered table-condensed">';
		echo '<tr><th>'. lang('torrent_heading_table') .'</th><th class="success" style="width: 30px; text-align: center; color: green;"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></th></tr>';			
			foreach($populair as $pop)
			{
				$img = '<img src="'. base_url('uploads/covers/'. $pop['cover'] .'').'">';
			    echo '<tr><td><a href="'. base_url('torrents/details/'. $pop['id'] .'').'">'. character_limiter($pop['name'], 60, '&#8230;').'</a></td><td class="success"><center>'. $pop['seeders'] .'</center></td></tr>';	

			}
		echo '</table>';

echo end_frame(); ?>