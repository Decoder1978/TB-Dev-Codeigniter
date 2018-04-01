<h4><span class="pull-left" style="text-shadow: 1px 1px 1px #000;"><strong>We hebben <?php echo $total_torrents ?> Torrents</strong></span></h4><span class="pull-right" style=""><?php if(isset($upload_button)){echo $upload_button ;}?></span>
<br /><hr />

<?php 
	$cats = $this->db->query("SELECT * FROM categories");
	
	if($cats->num_rows() == 0)
	{
	echo sprintf($this->lang->line('torrent_no_cats'));	
	}else{ ?>


			<?php $this->load->view('template/new_torrents');?>


			<?php $this->load->view('template/popular_torrents');?>
	
	
	<?php	foreach($cats->result_array() as $cat)
		{
			//echo begin_frame('Categorie <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> '.$cat['name'], 'default'); ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Categorie > <?php echo $cat['name']?></h3>
				</div>

				<div class='panel-body'>
				
				</div>
				<table class="table table-striped table-bordered" style="margin-bottom: 0px;">
				<tr>
				<th><?php echo lang('torrent_heading_table');?></th>
				<th class="hidden-xs hidden-sm" style="width: 80px; text-align: center;"><?php echo lang('torrent:size'); ?></th>
				<th class="hidden-xs hidden-sm" style="width: 80px; text-align: center;"><?php echo lang('torrent:files'); ?></th>
				<th class="hidden-xs hidden-sm" style="width: 140px; text-align: center;"><?php echo lang('torrent:added'); ?></th>
				<th class="success" style="width: 20px; text-align: center; color: green;"><span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span></th>
				<th class="danger" style="width: 20px; text-align: center; color: red;"><span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></th>
				</tr>
				<?php 
				$torrents = $this->db->select('*')->where('category', $cat['id'])->where('visible','yes')->order_by('added', 'DESC')->get('torrents',10);
				
				foreach($torrents->result() as $row){
					?>
					<tr>
					<td style="white-space: nowrap;">

						<?php if (mysql_to_unix($row->added) <= $this->session->userdata('last_browse')):?>
						<strong><a href="<?php echo base_url('torrents/details/'. $row->id .'');?>"><?php echo  character_limiter($row->name, 60, '&#8230;')?></a>&nbsp;&nbsp;&nbsp;<span class="text-danger"><?php echo lang('tor_new'); ?></span></strong>
						<?php else: ?>
						<span class="pull-left"><a href="<?php echo base_url('torrents/details/'. $row->id .'');?>"><?php echo  character_limiter($row->name, 60, '&#8230;')?></a></span>
						<?php endif;?>
						<?php 

						if($row->comments > 0)
						{
						 echo '<span class="pull-right" style="font-color: #ddd;">'. $row->comments .'&nbsp;&nbsp;<span class="glyphicon glyphicon-comment" aria-hidden="true"></span></span>';	
						}
					?>
					</td>
					<td class="hidden-xs hidden-sm"><center><?php echo byte_format($row->size, 2) ?></center></td>
					<td class="hidden-xs hidden-sm"><center><?php echo $row->numfiles ?></center></td>
					<td class="hidden-xs hidden-sm"><center><?php echo timespan(mysql_to_unix($row->added), '',1); ?>&nbsp;ago</center></td>
					<td class="success"><center><?php echo $row->seeders ?></center></td>
					<td class="danger"><center><?php echo $row->leechers ?></center></td>
					</tr>
					<?php 			
					}
				?>			
			</table>
			</div>
			<?php
			//echo end_frame();
		}
	}
?>





