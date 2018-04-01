<div class="row">
	<div class="col-md-6">
		<p>
		<span class="text-success"><span class="glyphicon glyphicon-glyphicon glyphicon-arrow-up"></span> Delers:  <strong><?php echo $seeders; ?> </strong></span>|
		<span class="text-warning"><span class="glyphicon glyphicon-glyphicon glyphicon-arrow-down"></span> Ontvangers:  <strong><?php echo $leechers;?> </strong></span>|
		<span class="text-info"><span class="glyphicon glyphicon-glyphicon glyphicon-saved"></span> Gedownload:  <strong><?php echo $times_completed;?> </strong></span>
		</p>
	</div>
	<div class="col-md-6">
	<p>
		<span class="text-info"><span class="glyphicon glyphicon-glyphicon glyphicon-user"></span> Geupload door:  
		<strong><a href="<?php echo base_url('members/details/'. $row->owner.''); ?>"><?php echo $this->member->get_usernamesite($row->owner);?></a> </strong></span>||
		<span class="text-info"><span class="glyphicon glyphicon-glyphicon glyphicon-star"></span> Waardering:  <strong><?php echo number_format($row->owner);?> </strong></span>
	</p>

	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<?php echo $download_button; ?>
						<!-- Single button -->
		<?php if (isset($torrent_options)){ ?>
		
		<div class="btn-group">
			<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Torrent opties <span class="caret"></span>
			</button>
				<ul class="dropdown-menu">
					<?php echo $cover_upload; ?>
					<li role="separator" class="divider"></li>
					<?php echo $torrent_edit; ?>
					<li role="separator" class="divider"></li>
					<li><a href="#"><span class="text-info"><span class="glyphicon glyphicon-glyphicon glyphicon-envelope"></span> Massa bericht versturen</span></a></li>
					<li role="separator" class="divider"></li>
					<?php echo $torrent_delete; ?>
				</ul>
			</div>
		
		<?php }?>
	</div>
</div>
<br />
<div class="row">
	<div class="col-md-9">
	<span><small>Toegevoegd op: <?php echo $added ?></small></span><br />	
	<span><small>Deze torrent is gecontroleerd  <span class="glyphicon glyphicon-glyphicon glyphicon-ok text-success"></span></small></span>
	</div>	
	
	<div class="col-md-3">
	<?php
		$this->load->view('template/video_block');	
	?>
	</div>
</div>