<?php 
echo begin_frame('Shoutbox','primary');
?>
<?php
if ($this->member->get_user_class() >= UC_BEHEERDER)
print "<a class='btn btn-default btn-sm' href=insertshout.php?legen=ja><span class='glyphicon glyphicon-trash'></span> Leeg gehele chat.</font></a><br /><br />";
?>
<div class="row">
	<div class="col-md-9">
		<?php echo begin_frame('Chat', 'info');?>
		<div id="ack"></div>
		<form class="form-horizontal" id="shoutform" method="post" action="<?php echo base_url('shoutbox/add')?>">
		
		  <div class="form-group">
			<div class="col-sm-10">
				<input class="form-control" placeholder="type hier om te chatten en hit enter!" maxlength="300" type="text" name="content" id="shout"/>
				<input type="hidden" name="user_id" id="id" value="<?php echo $this->session->userdata('user_id');?>">
				<input type="hidden" name="username" id="id" value="<?php echo $this->session->userdata('username');?>">			
			</div>
			<div class="col-sm-2">
			<button id="submit" class='btn btn-default btn-block' style><span class="glyphicon glyphicon-comment" aria-hidden="true"></span></button>
			</div>
			</div>
		</form>
	<div id="shoutbox" style=""></div>	
	<?php echo end_frame();?>
	</div>
	<div class="col-md-3">
	<?php echo begin_frame('Online gebruikers', 'info');?>
		<ul class="list-group">
		<?php echo "<div id=active_users></div>"; ?>
		</ul>
	<?php echo end_frame();?>
	</div>
</div>
<?php echo end_frame(); ?>




<script>


$('#active_users').load('shoutbox/updateUsers');
$('#shoutbox').load('shoutbox/get_shouts');

$.ajaxSetup ({
    // Disable caching of AJAX responses IE hack by Decoder
    cache: false
});
   $("button#submit").click ( function() {
   if( $("#shout").val() == "")
	 $("div#ack").html("<div class='alert alert-danger'>he wil je wel ff wat text erin zetten?</div>");
	 else
	 $("div#ack").hide();
	 $.post($("#shoutform").attr("action"),
	        $("#shoutform :input").serializeArray(),
			function addShout(data) {
				$(".shoutbox-shouts").append(
					'<tr>' +
						'<td>'+ data.username +'</td>' +
						'<td>'+ data.content.replace(/(<([^>]+)>)/ig,"") +'</td>' +
					'</tr>'
				).hide().fadeIn();
			});
	  		$("#shoutform").submit( function() {
		return false;
		});
		$('#shout').val('');
     });	

	 
function updateUsers(){
    // Assuming we have #active_users
    $('#active_users').load('shoutbox/updateUsers');
}

function updateShouts(){
    // Assuming we have #shoutbox
    $('#shoutbox').load('shoutbox/get_shouts');
}

setInterval( "updateUsers()", 1400 );
setInterval( "updateShouts()", 1400 );

</script>