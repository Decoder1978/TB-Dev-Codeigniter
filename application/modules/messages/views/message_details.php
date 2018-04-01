<?php 
begin_frame('Onderwerp: '.$subject);
?>
<table class='table table-bordered table-striped table-condensed'>
<tr>
<th colspan='2'>
<div class='pull-left'>Van <?php echo $username ?>&nbsp;&nbsp;<span class="label label-important"><?php echo $new_message ?></span></div>
<div class='pull-right'><?php echo $added?> geleden</div></th></tr>
<tr><td class="" style="width: 200px;">
		
		<table class='table table-bordered table-condensed'>
		<tr><td colspan='2'><?php echo $avatar ?></td></tr>
		<tr><td>Download</td><td><?php echo $downloaded ?></td></tr>
		<tr><td>Upload</td><td><?php echo $uploaded ?></td></tr>
		<tr><td>Ratio</td><td><?php echo $ratio ?></td></tr>
		</table>

</td><td style="padding: 30px;"><?php echo nl2br($message);?></td></tr>
<tr><td colspan="2">
<div class="">
<?php 

echo $btn_replay; ?>
<button class="btn btn-default">Knop</button>
<button class="btn btn-default">Knop</button>
<button class="btn btn-default">Knop</button>
</div>
</td></tr>		

</table>		
<?php 
end_frame();
?>