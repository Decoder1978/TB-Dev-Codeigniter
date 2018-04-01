<?php 
echo begin_frame($this->lang->line('torrent:newest'), 'success');

$torrentss = $this->db->query("SELECT * FROM torrents WHERE visible = 'yes' ORDER BY added DESC LIMIT 6")->result_array();
echo '<div class="row">';?>
<?php 

	foreach($torrentss as $torrentt)
	{
		if($torrentt['cover_thumb'])
		{
			$cover = '<img class="img-responsive" src="'. base_url('uploads/covers/'. $torrentt['cover_thumb'].'') .'">';
		}else{
			$cover = '<img class="img-responsive" src="http://placehold.it/130x200?text=Geen+cover">';
		}
		echo '<div class="col-xs-2">';
		echo '<a href="'. base_url('torrents/details/'. $torrentt['id'] .'') .'" class="thumbnail">';
		echo $cover;
		echo '</a>';
		echo '</div>';	
	}
echo '</div>';
echo end_frame(); 
?>