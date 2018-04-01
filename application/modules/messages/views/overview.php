<?php echo begin_frame('Berichten voor: '.$username) ;?>

<table class="table table-hover table-bordered">
	<tr><th>Onderwerp</th><th>Van</th><th>Datum</th></tr>
<?php 

if(isset($get_messages))
	{
	foreach($get_messages->result() as $message){ 
	
	$sender = $this->db->select('username')->where('id', $message->sender)->get('users')->row();
	
	if(!$sender)
	{
		$sender_name = '<span class="text-danger">**Systeem bericht**</span>';
	}else{
		$sender_name = '<a href="'. base_url('members/details/'. $message->sender .'') .'">'. $sender->username .'</a>';
	}
	?>

	<tr>
	<td><a href="<?php echo base_url('messages/details/'. $message->id .'');?>"><?php echo $message->subject; ?></a></td>
	<td><?php echo $sender_name; ?></td>
	<td style="white-space: nowrap !important;"><?php echo timespan(mysql_to_unix($message->added));?></td>
	</tr>

	
<?php }

}else{
	echo '<tr><td colspan="3" style="padding: 10px;"><div class="alert alert-info" role="alert">Geen berichten hier vriend........sorry</div></td></tr>';
}?>

</table>

<?php echo end_frame() ;?>