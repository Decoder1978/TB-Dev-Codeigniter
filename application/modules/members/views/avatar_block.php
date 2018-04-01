			<?php
			if($user_id === $this->session->userdata('user_id'))
			{
			
				
				echo '<p>'. $avatar_button.'</p>';
				
				?>
				


			<div id="myPopover" class="hide">
				
			<form class="form" method="post" enctype="multipart/form-data" action="<?php echo base_url('members/avatar_upload/'. $this->session->userdata('user_id') .'')?>">

				<table class="table table-bordered">
				<tr><th colspan="2">Avatar toevoegen voor uw account</th></tr>
				<tr>
				<td>Avatare selecteren</td>
				<td>
				<div class="form-group">
				<input type="file" name="userfile">
				<small><span class="help-block">Uw avatar mag niet groter zijn dan 300 KB.<br />Een bestaande avatar word automatishe overgeschreven.</span></small>
				</div>
				</td>
				</tr>
				<tr><td colspan="2"><button type="submit" class="btn btn-primary pull-right">Avatar verzenden</button></td></tr>
				</table>
			</form>
			</div>

				<script>


					$('[rel="popover"]').popover({
						container: 'body',
						html: true,
						content: function () {
							var clone = $($(this).data('popover-content')).clone(true).removeClass('hide');
							return clone;
						}
					}).click(function(e) {
						e.preventDefault();
					});


				</script>
<?php 
			}?>