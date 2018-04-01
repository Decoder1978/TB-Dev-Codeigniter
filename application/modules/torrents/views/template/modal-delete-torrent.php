<div class="modal fade" id="modal-delete-torrent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Verwijderen van de torrent.</h4>
      </div>
      <div class="modal-body">
		
	<form class='form-horizontal' method='post' action='<?php echo base_url('torrents/torrent_delete/'. $row->id .'') ?>'>
	<table class='table table-bordered table-condensed'>
	<tr><td><input name='reasontype' type='radio' value='1'>Dood</td><td> 0 delers, 0 ontvangers = 0 bronnen totaal</td></tr>
	<tr><td><input name='reasontype' type='radio' value='2'>Dubbel</td><td><input type='text' size='40' name='reason[]'></td></tr>
	<tr><td><input name='reasontype' type='radio' value='3'>Niet werkend</td><td><input type='text' size='40' name='reason[]'></td></tr>
	<tr><td><input name='reasontype' type='radio' value='4'>Overtreding van de regels</td><td><input type='text' size='40' name='reason[]'> verplicht</td></tr>
	<tr><td><input name='reasontype' type='radio' value='5' checked>Anders:</td><td><input type='text' size='40' name='reason[]'> verplicht</td></tr>
	<input type='hidden' name='id' value='<?php echo $row->id ?>'>
	</table>

	

	
      </div>
      <div class="modal-footer">
		<span class="pull-left"><input type="checkbox" name="correction"> Verwijderen met correctie</span>
        <input class='btn btn-danger' type='submit' value='Verwijder torrent'>
      </div>
	  	</form>
    </div>
  </div>
</div>