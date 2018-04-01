<?php 
if(isset($warned)) { echo $warned; }
if(isset($block_text)){ echo $block_text; }
?>
<?php echo begin_frame('Profiel van '. $user_name .'', 'primary');?>
<div class="row">
	<div class="col-lg-12"><?php echo $ip_control; ?></div>
</div>

<div class="row">
	<div class="col-xs-3">
		<div class="well">
			<p><?php echo $user_avatar; ?></p>
			<?php echo $this->load->view('avatar_block');?>
			
			<?php echo $button_block ;?>
			<p><a href="<?php echo base_url('messages/sendmessage/'. $user_name .''); ?>" class="btn btn-default btn-block">Bericht sturen</a></p>
			<p><button type="button" class="btn btn-warning btn-block">Gebruiker rapporteren !</button></p>
			<p><?php echo $button_mod ?></p>
			
		</div>
	</div>
	<div class="col-xs-9">
		<div> <!-- nav container -->
		<!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#userdetails" aria-controls="userdetails" role="tab" data-toggle="tab">Profiel van <?php echo $user_name; ?></a></li>
			<li role="presentation"><a href="#torrent_added" aria-controls="torrent_added" role="tab" data-toggle="tab">Geplaatst</a></li>
			<li role="presentation"><a href="#torrent_seeding" aria-controls="torrent_seeding" role="tab" data-toggle="tab">Downloaden</a></li>
			<li role="presentation"><a href="#torrent_leeching" aria-controls="torrent_leeching" role="tab" data-toggle="tab">Delen</a></li>
			<li role="presentation"><a href="#torrent_downloaded" aria-controls="torrent_downloaded" role="tab" data-toggle="tab">Kompleet</a></li>
			<?php 
			if ($this->member->get_user_class() >= UC_MODERATOR && $class < $this->member->get_user_class()){ ?>
			<li role="presentation"><a href="#mod_options" aria-controls="mod_options" role="tab" data-toggle="tab">Moderator</a></li>
			<?php } ?>
		  </ul>

		  <!-- Tab panes -->
			<div class="tab-content" style="border-right: 1px solid #ddd; border-bottom: 1px solid #ddd; border-left: 1px solid #ddd; padding: 10px; margin-bottom: 20px;">
				<div role="tabpanel" class="tab-pane active" id="userdetails"><?php echo $this->load->view('user_table');?></div>
				<div role="tabpanel" class="tab-pane" id="torrent_added"><h3>Geplaatste torrents</h3><?php echo $this->load->view('torrent_added');?></div>
				<div role="tabpanel" class="tab-pane" id="torrent_seeding"><h3>Gedownload</h3><?php echo $user_torrent_downloaded?></div>
				<div role="tabpanel" class="tab-pane" id="torrent_leeching"><h3>Delen</h3><?php echo $user_torrent_seeding?></div>
				<div role="tabpanel" class="tab-pane" id="torrent_downloaded"><h3>Ontvangen</h3><?php echo $user_torrent_leeching?></div>
				<div role="tabpanel" class="tab-pane" id="mod_options"><?php echo $this->load->view('moderator_comment');?></div>
			</div>
		</div> <!-- end nav container -->
	</div>
</div>

<?php echo end_frame(); ?>






