<?php echo begin_frame('Passkey controleren', 'primary'); ?>
<?php 
if(isset($result))
{
	echo '<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 20px; margin-bottom: 20px;">';
	echo $passkey .' is van '. $name .' ';
	echo '</div>';
}
?>
<form method="post" action="<?php echo base_url('moderator/checkpasskey'); ?>">
<table class="table table-bordered">
<tr><td class="col-lg-2">Passkey Gebruiker</td><td><input type="text" class="form-control" name="passkey"></td></tr>
<tr><td colspan="2"><input class="btn btn-default" type="submit" value="Controleren!"></td></tr>
</table>
</form>
<?php echo end_frame(); ?>