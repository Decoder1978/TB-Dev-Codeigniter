<div class="panel panel-primary">
	<div class="panel-heading">Shoutbox</div>
	<div class="panel-body">	
	Dit is de shoutbox....hier word niet gevloekt, verder zoek je het maar uit!
	</div>
		<table class="table">
			<tr><th>Gebruiker</th><th>Bericht</th></tr>
			<?php foreach($shouts->result() as $s):?>
			<tr>
			<td><?php echo $s->username; ?></td>
			<td><?php echo $s->content; ?></td>
			</tr>
			<?php endforeach; ?>
		</table>  

</div>

	<form method="post" action="<?php echo base_url('shoutbox/add');?>">
		<div class="form-group">
		    <div class="input-group">
				<div class="input-group-addon">Bericht:</div>
				<input type="text" name="content" class="form-control">
				<input type="hidden" name="username" value="<?php echo $user->username;?>">				
				<input type="hidden" name="user_id" value="<?php echo $user->id;?>">
			</div>
			
		</div>

		<button type="submit" class="btn btn-primary">Shout !</button>
	</form>




<!--<script src="<?php echo base_url('assets/js/shoutbox-jquery.js');?>"></script>--?
