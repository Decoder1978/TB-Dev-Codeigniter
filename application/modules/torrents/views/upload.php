<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">
		<?php echo isset($row) ? 'Torrent '. $row->name .' Aanpassen' : 'Torrent uploaden'; ?>
		</h3>
	</div>
    <script src="<?php echo base_url('assets/js/bootstrap-filestyle.min.js');?>"></script>
	
	<?php
		$categories = $this->db->select('*')
                        ->from('categories')
                        ->order_by('sort', 'asc')
                        ->get()
                        ->result();
	?>
	
    <div class="panel-body">
	<?php $url = isset($row) ? base_url('torrents/take_edit/'. $row->id .'') : base_url('torrents/takeupload'); ?>
		<form enctype="multipart/form-data" action="<?php echo $url ;?>" method="post">
		<p style="background: #f6f6f6; padding: 10px; border: 1px solid #d6d6d6;">
		<?php echo lang('upload:tracker_announce'); ?> <b><?php echo $this->config->item('announce_url');?>?passkey=<?php echo $user->passkey; ?></b></p>


			<div class="form-group">
				<label for="naam"><?php echo lang('upload:name_label'); ?></label>
				<input type="text" name="name" id="naam" class="form-control" value="<?php echo isset($row) ? $row->name : ''; ?>">
			</div>
			
				
			<?php
			
			$file = '<div class="form-group">';
			$file.=	'<label for="bestand">'. lang('upload:file_name').'</label>';
			$file.=	'<input class="filestyle" type="file" name="userfile" id="bestand" data-buttonBefore="true" data-buttonText="'. lang('upload:add_file').'" data-buttonName="btn-primary">';
			$file.=	'</div>';
			?>

			<?php echo isset($row) ? '' : $file; ?>
			
			<div class="form-group">
				<label for="cat"><?php echo lang('upload:cat_label'); ?></label>
				<select name="category" id="cat" class="form-control">
				<option value="0"><?php echo lang('upload:cat_select'); ?></option>
				<?php
				if(isset($row))
				{
					foreach ($categories as $cat) 
					{
					echo '<option value="'. $cat->id .'"';
					
					if ($cat->id == $row->category)
					{
					echo ' selected="selected" class="text-success"';
					}
					echo '>' . $cat->name . '</option>';
				}
					
				}else{
					foreach ($categories as $cat)
					{
					echo '<option value="' . $cat->id . '">' . $cat->name . '</option>';
					}	
				}
				?>
				</select>
			</div>			
			<div class="form-group">
				<label for="descr"><?php echo lang('upload:description'); ?></label>
				<textarea name="descr" class="form-control summernote" rows="10"><?php echo isset($row) ? $row->descr : ''; ?></textarea>
				
				<script>
				$(document).ready(function() {
				  $('.summernote').summernote({
					  height: 250
				  });
				});
				</script>
			</div>			
		<input type="submit" class="btn btn-primary" value="<?php echo lang('upload:upload'); ?>" />
	</form>
</div>
</div>
