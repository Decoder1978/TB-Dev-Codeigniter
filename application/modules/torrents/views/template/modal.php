<!-- Modal -->
<div class="modal fade" id="cover" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cover toevoegen</h4>
      </div>
      <div class="modal-body">

		<?php 
		echo form_open_multipart('torrents/do_upload/'. $torrent_id .'');
		echo '<p class="help-block">Een cover toevoegen aan <strong>'. $torrent_title .'</strong></p>';
		
		echo form_upload('userfile');
		?>

      </div>
      <div class="modal-footer">
	  <?php echo form_submit('submit', 'verzenden', 'class="btn btn-primary"'); ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Sluiten</button>
     </div>
	 <?php echo form_close();?>
    </div>
  </div>
</div>