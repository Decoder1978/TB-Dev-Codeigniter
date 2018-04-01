<div class="row">
	<div class="col-md-12">
	<table class="table table-bordered">
	<tr><th class="col-xs-3">Gebruikersnaam:</th><td><?php echo $user_name ;?></td></tr>		
	<tr><th>Rang:</th><td><?php echo $user_rang?></td></tr>		
	<tr><th>E-mail:</th><td><?php echo $user_email ;?></td></tr>
	<tr><th>Gedownload:</th><td><?php echo $user_downloaded ;?></td></tr>		
	<tr><th>Geupload:</th><td><?php echo $user_uploaded ;?></td></tr>
	<tr><th>Ratio:</th><td><?php echo $user_ratio ;?></td></tr>
	<tr><th>Torrent berichten:</th><td><?php echo $user_tor_comment ;?></td></tr>		
	<tr><th>Max torrents:</th><td><?php echo $user_max_torrents ;?></td></tr>		
	<tr><th>Kliks:</th><td><?php echo $user_kliks ;?></td></tr>		
	<tr><th>Forum berichten:</th><td><?php echo $user_forum_comment ;?></td></tr>
	<tr><th>Aangemeld op:</th><td><?php echo $user_added ;?></td></tr>		
	<tr><th>Het laatst gezien op:</th><td><?php echo $user_last_login ;?></td></tr>		
	<?php if ($this->member->get_user_class() >= UC_BEHEERDER){ ?>	
	<tr><th>IP adres:</th><td><?php echo $user_ip ;?></td></tr>	
	<?php } ?>

	<?php if(isset($dubbelip))
	{ 
	echo '<tr><th>Hetzelfde IP-nummer gevonden bij:</th><td>';
		foreach( $dubbelip->result_array() as $row)
		{ 
			if ($user_name <> $row['username'])
			{
			echo $this->member->get_username($row['id']).' - ' ;	
			}
		}
	echo '</td></tr>';
	} ?>
	</table>
	</div>
</div>	