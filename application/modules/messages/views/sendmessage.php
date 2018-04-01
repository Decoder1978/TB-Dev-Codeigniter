<?php 
begin_frame('Bericht verzenden naar '. $receiver->username .'');
?>
<div class="row">
	<div class="col-md-10">
		<form class="" method="post" action="<?php echo base_url('messages/takemessage');?>">
		
		  <div class="form-group">
			<label for="subject">Onderwerp</label>
			<input type="text" class="form-control" name="subject" id="subject" placeholder="Onderwerp">
		  </div>
  
		  <div class="form-group">
			<textarea class="form-control summernote" name="msg" rows="3"></textarea>
		  </div>
		  
		  <input type="hidden" name="returnto" value="<?php echo $_SERVER["HTTP_REFERER"] ?>">
		  <input type="hidden" name="receiver" value="<?php echo $receiver->id ?>">
		  

		  <p><input type="submit" value="Bericht versturen" class="btn btn-primary"></p>
		</form>

	</div>
	<div class="col-md-2">
	
		<div class="list-group">
			<a href="#" class="list-group-item active">
			Cras justo odio
			</a>
			<a href="#" class="list-group-item">Dapibus ac facilisis in</a>
			<a href="#" class="list-group-item">Morbi leo risus</a>
			<a href="#" class="list-group-item">Porta ac consectetur ac</a>
			<a href="#" class="list-group-item">Vestibulum at eros</a>
		</div>
	</div>
</div>

<?php 
end_frame();
?>




