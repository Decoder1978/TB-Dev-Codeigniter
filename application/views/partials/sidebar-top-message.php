<li class="dropdown">

	<a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">
	<?php if($new_messages > 0){ ?>
		<span class="label label-danger" style="position: absolute; top: 6px; left: 22px; z-index: -10;"><?php echo $new_messages;?></span>
	<?php } ?>
		<span class="glyphicon glyphicon-envelope"></span>

	</a>
	
	<ul class="dropdown-menu" style="width: 320px;">
		<li class="dropdown-header">Meldingen</li>
		<?php
		$messages = $this->db->query("SELECT * FROM messages WHERE receiver=".$this->session->userdata('user_id')." AND unread='yes' ORDER BY added DESC LIMIT 5");
		
		if($messages->num_rows() > 0)
		{
			foreach($messages->result_array() as $message)
			{
			echo '<li><div style="background: #f5f5f5; border: 1px solid #bbb; padding: 10px; margin: 5px; font-size: 12px"><a href="'. base_url('messages/details/'. $message['id'].'') .'">'. $message['subject'].'</a></div></li>';	
			}
		}
		else
		{
		echo '<a href="'. base_url('messages') .'"><div style="background: #f5f5f5; border: 1px solid #bbb; padding: 10px; margin: 5px; font-size: 12px">Er zijn geen nieuwe berichten voor u....</div></a>';	
		}
		?>

	</ul>
</li><!--dropdown-->