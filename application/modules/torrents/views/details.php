<div class="row">
	<div class="col-xs-12">
		<h3 style="margin-top: 0px;">
			<span class="pull-left" style="color: rgb(57, 132, 198);"><strong><?php echo $torrent_title ;?></strong></span>
		</h3>
		<span class="pull-right"><?php echo $torrent_table ;?></span>
		<span class="pull-right"><?php if(isset($torrent_options)){echo $torrent_options ;}?></span>
	</div>
</div>

<div class="" style="">
	<div class="torrentblock"><span class="text-success"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span> seeders: <strong><?php echo $seeders ?></strong></span></div>
	<div class="torrentblock"><span class="text-danger"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span> leechers: <strong><?php echo $leechers ?></strong></span></div>
	<div class="torrentblock"><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span> updated: <?php echo timespan(human_to_unix($row->last_action), time(), 2) ?>&nbsp;ago</div>
</div>

<hr />
		<div class="collapse" id="torrenttable">
		<?php 
		$data['row'] = $row;
		$this->load->view('torrent_info', $data);
		
		?>
		</div>	
		
		<div class="collapse" id="torrentoptions">
		  <div class="well">
				<div class="row">
					<div class="col-xs-3">
					<?php echo $torrent_edit ;?>
					</div>
					<div class="col-xs-3">
					<?php echo $torrent_mass_message ;?>
					</div>
					<div class="col-xs-3">
					<?php echo $torrent_control ;?>
					</div>
					<div class="col-xs-3">
					<?php echo $torrent_delete ;?>
									
					</div>
				</div>
			</div>
		</div>	

				
	<div class="row">
		<div class="col-xs-3">
			<?php echo $cover ; ?>
			<?php 
			if(isset($cover_button))
			{
				echo $cover_button ;
			}	
			?>
		<?php echo $download_button; ?>
		</div>
		<div class="col-xs-9">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#main" aria-controls="main" role="tab" data-toggle="tab"><?php echo 'Omschrijfing' ;?></a></li>
			<li role="presentation"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?php echo lang('torrent:comments');?> <?php echo $get_comments_total;?></a></li>
			<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?php echo lang('torrent:seeder_leecher');?></a></li>
			<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><?php echo lang('torrent:completed');?></a></li>
			<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab"><?php echo lang('torrent:filelist');?></a></li>
			</ul>
			<!-- Tab panes -->
			<!-- TODO: put this css in css file...get it out of here !! -->
			<div class="tab-content" style="border-left: 1px solid #ddd; border-right: 1px solid #ddd; border-bottom: 1px solid #ddd; padding: 20px; background: white;">
				
				<div role="tabpanel" class="tab-pane active" id="main">		
					<?php echo $description;?>
				</div>
				
				<div role="tabpanel" class="tab-pane fade" id="home">
					<?php echo $get_comments_form;?>
					<?php  
					foreach($get_comments as $row)// TODO: moved overhere....could not somehow get this from the model....strange but look ad this later again
					{
							echo '<div class="panel panel-default">';
							echo '<div class="panel-heading">';
							echo 'Door '. $this->member->get_username($row['user']);
							
								if ($this->member->get_user_class() >= UC_ADMINISTRATOR)
								{				
									echo '<a class="pull-right btn btn-danger btn-xs" href='. base_url('torrents/deletecomment/'.$row['id'].'/'. $torrent_id .'') .'><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>&nbsp;&nbsp';
								}
								
							echo " op " . $row["added"] . " " . ($this->member->get_user_class() >= UC_MODERATOR || $this->session->userdata('user_id') == $row["user"] ? "<a class='pull-right btn btn-default btn-xs' href=comment.php?action=edit&amp;cid=$row[id]><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>" : "") . "";
							echo '</div>';
							echo '<div class="panel-body">';
							$body = stripslashes($row["text"]);
							echo  $body;
							echo '</div>';
							echo '</div>';
					}?>
				</div>
				<div role="tabpanel" class="tab-pane fade" id="profile"><?php echo $get_peer_info;?></div>
				<div role="tabpanel" class="tab-pane fade" id="messages"><?php echo $get_completed_info;?></div>
				<div role="tabpanel" class="tab-pane fade" id="settings"><?php echo $get_file_info;?></div>
			</div>
		</div>
	</div>
<?php $this->load->view('template/modal');?>
<?php 
	//$data['torrent'] = $torrent;
	$this->load->view('template/modal-delete-torrent');?>


