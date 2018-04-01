<?php 
echo form_open_multipart('torrents/do_upload/'. $row->id);
echo '<p class="help-block">Een cover toevoegen aan deze torrent<br>Let op een bestaande cover word verwijderd.</p>';
echo '<br>';
echo form_upload('userfile');
echo '<br><br>';
echo form_submit('submit', 'verzenden', 'class="btn btn-primary"');
echo form_close();
?>