<?php

if ($this->member->get_user_class() < UC_MODERATOR)
	site_error_message("Foutmelding", "Deze pagina is alleen voor Moderator en hoger.");



/*
if ($action == "del_peers")
	{
	$user_id = 0 + $_POST['user_id'];
	mysql_query("DELETE FROM peers WHERE userid=$user_id") or sqlerr(__FILE__, __LINE__);
	$extra_text = "Bronnen verwijderd.";
	$action = "view";
	}

if ($action == "invite_list")
	{
	if (get_user_class() < UC_SYSOP)
		site_error_message("Foutmelding", "Deze optie is alleen voor de beheerders en hoger.");
	$user_id = 0 + $_POST['user_id'];
	mysql_query("UPDATE users SET invited_by=0 WHERE invited_by=$user_id") or sqlerr(__FILE__, __LINE__);
	$extra_text = "Uitnodigingen lijst geleegd.";
	$action = "view";
	}

if ($action == "invites_null")
	{
	if (get_user_class() < UC_SYSOP)
		site_error_message("Foutmelding", "Deze optie is alleen voor de beheerders en hoger.");
	$user_id = 0 + $_POST['user_id'];
	mysql_query("UPDATE users SET invites = 0 WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	$extra_text = "Uitnodigingen verwijderd.";
	$action = "view";
	}

	if ($action == "flush_torrents"){
	if (get_user_class() < UC_ADMINISTRATOR)
		site_error_message("Foutmelding", "Deze optie is alleen voor de administrators en hoger.");
	$user_id = 0 + $_POST['user_id'];
	$deadtime = deadtime();
   	mysql_query("DELETE FROM peers WHERE last_action < FROM_UNIXTIME($deadtime) AND userid=$user_id");
   	$effected = mysql_affected_rows();
	$extra_text = "Succesvol $effected ghost torrents " . ($effected ? 's' : '') ." zijn succesvol opgeruimd.";
	$action = "view";
}

if ($action == "super_seeder")
	{
	$user_id = 0 + $_POST['user_id'];
	$waarde = $_POST['waarde'];
	if ($waarde == "yes")
		$msg = "Hallo " . get_username($user_id) . ",\n\nU heeft met onmiddelijke ingang de status 'Super Deler' gekregen.\n\nDaar er is geconstateerd dat u met een hogere uploadsnelheid heeft dan 1 mbit.\n\nDit geeft geen extra voordelen, behalve dat u niet meer geregistreerd wordt voor vals spel.\n\nMet vriendelijke groeten,\n\n" . $CURUSER['username'];
	else
		$msg = "Hallo " . get_username($user_id) . ",\n\nDe status 'Super Deler' is u ontnomen.\n\n" . $CURUSER['username'];

	$waarde = sqlesc($waarde);
	mysql_query("UPDATE users SET super_seeder = $waarde WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);

	$message =	sqlesc($msg);
	$added = sqlesc(get_date_time());
	$sender = $CURUSER['id'];
	mysql_query("INSERT INTO messages (sender, receiver, msg, added) VALUES ($sender, $user_id, $message, $added)") or sqlerr(__FILE__, __LINE__);

	$action = "view";
	}

if ($action == "reset_passkey")
	{
	$user_id = 0 + $_POST['user_id'];
//	mysql_query("UPDATE users SET passkey = 'leeg' WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	$res = mysql_query("SELECT * FROM users WHERE id=$user_id") or sqlerr(__FILE__, __LINE__);
	$row = mysql_fetch_array($res);
	if ($row)
		{
		$passkey = md5($row['username'].get_date_time().$row['passhash']);
		mysql_query("UPDATE users SET passkey='$passkey' WHERE id=$row[id]");
		$extra_text = "Reset passkey gelukt.";
		}
	else
		$extra_text = "Reset passkey NIET gelukt.";

	$action = "view";
	}
*/
//if ($action == "view")
	//{

	$user_id = $this->uri->segment(3);
	$row = $this->db->select('*')->where('id', $user_id)->get('users')->result_array();

	//var_dump($this->db->last_query());
	//var_dump($row);

	if ($this->member->get_user_class() <= $row)
		//$this->session->set_flashdata('danger', 'Oprotten wat wil je nou doen ?? !');
		//redirect('members/details/'. $user_id.'');

	//site_header("Moderator");
	//tabel_top("Moderator opties voor gebruiker ".get_username($user_id)."");
	//begin_frame();
	//print"<div id='content_info'></div>";
	//if ($extra_text)
	//	print "<b>" . $extra_text . "</b><br>";
/*
	if ($this->member->get_user_class() >= UC_BEHEERDER)
		{
			
		echo '<div class="panel panel-default">';
		echo '<div class="panel-heading">Oprichter opties voor gebruiker '. $this->member->get_username($user_id).'</div>';
		echo '<div class="panel-body">';
		echo 'Oprichter opties voor gebruiker '. $this->member->get_username($user_id).'';
		echo '</div>';
		
		print "<table class='table table-bordered'>";
		print "<tr><td class='col-xs-3'><form method=get action=". base_url('moderator/user_add_credits') .">";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit class='btn btn-default btn-block' value='Krediet toevoegen'></form>";
		print "</td><td>Krediet geven aan <font color=red><b>".$this->member->get_username($user_id)."</b></font>.</td></tr>";


        print "<tr><td><form method=get>";
		print "<input type=hidden name=userid value=" . $user_id . ">";
		print "<input type=submit class='btn btn-default btn-block' value='Gegevens'></form>";
		print "</td><td>Gebruiker-history <font color=red><b>".$this->member->get_username($user_id)."</b></font>.</td></tr>";

		print "<tr><td><form method=get action=". base_url('moderator/user_credits_admin') .">";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit class='btn btn-default btn-block' value='Krediet gebruiken'></form>";
		print "</td><td>Krediet gebruiken voor <font color=red><b>".$this->member->get_username($user_id)."</b></font>.</td></tr>";

		print "<tr><td><form method=get action=". base_url('moderator/user_donate_date') .">";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit class='btn btn-default btn-block' value='Gebruiker donatiedatum'></form>";
		print "</td><td>Gebruiker <font color=red><b>".$this->member->get_username($user_id)."</b></font> donatie datum aanpassen.</td></tr>";


		print "<tr><td><form method=get action=". base_url('moderator/user_donate_edit') .">";
		print "<input type=hidden name=id value=" . $user_id . ">";
		print "<input type=submit class='btn btn-default btn-block' value='Donatie gegevens'></form>";
		print "</td><td>Donatie gegevens wijzigen gebruiker.</td></tr>";


		print "<tr><td><form method=get action=". base_url('moderator/user_donate_edit_week') .">";
		print "<input type=hidden name=id value=" . $user_id . ">";
		print "<input type=submit class='btn btn-default btn-block' value='WEEK donatie'></form>";
		print "</td><td>WEEK donatie gegevens wijzigen gebruiker.</td></tr>";

		print "<tr><td><form class='form-inline' method=post action=". base_url('moderator/user_delete') .">";
		print "<input type=hidden name=userid value=" . $user_id . ">";
		print "<input type=hidden name=action value=verwijderen>";
		?>
		  <div class="checkbox">
    <label>
      <input type="checkbox" name="sure">
    </label>
  </div>
  <?php 
		//print "<input type=checkbox name=sure>";
		print "<input type=submit class='btn btn-danger' value='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Account verwijderen&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'></form>";
		print "</td><td>Gebruiker <font color=red><b>".$this->member->get_username($user_id)."</b></font> definitief verwijderen.</td></tr>";


		print "</table>";
		}
		echo '</div>';

*/


		if ($this->member->get_user_class() >= UC_BEHEERDER){?>
		<?php echo begin_frame('Beheerder opties voor gebruiker '. $this->member->get_username($user_id).'','primary');?>
		<div class="row">

			<div class="col-md-6 col-lg-4">
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php 
					echo "<form method=get action=". base_url('moderator/user_inbox_spy') .">";
		print "<input type=hidden name=id value=" . $user_id . ">";
		print "<input type=submit data-toggle='tooltip' data-placement='top' title='Postvak-in bekijken.' class='btn btn-default btn-block' value='Postvak-IN'></form>";
					?>
				</div>
			</div>
			
			
			
			
			<div class="col-md-6 col-lg-4">
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php 
					echo "<form method=get action=user_helpdesk.php>";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit data-toggle='tooltip' data-placement='top' title='Helpdesk instellingen aanpassen.' class='btn btn-default btn-block' value='Helpdesk instellingen'></form>";
					?>
				</div>
			</div>
			
			
			
			
			<div class="col-md-6 col-lg-4">
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php 
					echo "<form method=get action=". base_url('moderator/user_outbox_spy') .">";
		print "<input type=hidden name=out value=" . $user_id . ">";
		print "<input type=submit data-toggle='tooltip' data-placement='top' title='Postvak-uit bekijken.' class='btn btn-default btn-block' value='Postvak-UIT'></form>";
		?>
				</div>
			</div>
			
			
			
			
			<div class="col-md-6 col-lg-4">
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php 
					echo "<form method=get action=". base_url('moderator/user_gb_bonus') .">";
		print "<input type=hidden name=user_id value=" . $user_id . ">";
		print "<input type=submit data-toggle='tooltip' data-placement='top' title='Bonus geven in GigaBytes.' class='btn btn-default btn-block' value='Bonus in Gb'></form>";
		?>
				</div>
			</div>
			
			
			
			
		</div>
		<?php echo end_frame(); ?>
		<?php } 	
	

		
	if ($this->member->get_user_class() >= UC_ADMINISTRATOR){?>
		<?php echo begin_frame('Administrator opties voor gebruiker '. $this->member->get_username($user_id).'','info');?>
		<div class="row">
			<div class="col-md-6 col-lg-4">
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php 
					echo "<form method=get action=". base_url('moderator/user_gb_edit') .">";
					echo "<input type=hidden name=user_id value=" . $user_id . ">";
					echo "<input type=submit data-toggle='tooltip' data-placement='top' title='Totaal verzonden en totaal ontvangen aanpassen.' class='btn btn-default btn-block' value='GB totalen aanpassen'></form>";
					?>
				</div>
			</div>
				
				
				
			<div class="col-md-6 col-lg-4">				
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php 
					echo "<form method=post action=". base_url('moderator/user_change_name') .">";
					print "<input type=hidden name=userid value=" . $user_id . ">";
					print "<input type=submit data-toggle='tooltip' data-placement='top' title='Gebruikersnaam wijzigen, mits deze nog niet wordt gebruikt' class='btn btn-default btn-block' value='Gebruikersnaam wijzigen'></form>";
					?>
				</div>
			</div>
				
				
			<div class="col-md-6 col-lg-4">
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php 
					echo "<form method=post action=". base_url('moderator/user_edit_email') .">";
					print "<input type=hidden name=userid value=" . $user_id . ">";
					print "<input type=submit data-toggle='tooltip' data-placement='top' title='Email wijzigen, mits deze nog niet wordt gebruikt' class='btn btn-default btn-block' value='E-mail wijzigen'></form>";
					?>
				</div>
			</div>
				
			<div class="col-md-6 col-lg-4">
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php 
					echo "<form method=post action=". base_url('moderator/user_edit_password') .">";
					print "<input type=hidden name=user_id value=" . $user_id . ">";
					print "<input type=submit data-toggle='tooltip' data-placement='top' title='Wachtwoord wijzigen.' class='btn btn-default btn-block' value='Wachtwoord wijzigen'></form>";
					?>
				</div>
			</div>
				
				
			<div class="col-md-6 col-lg-4">
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php 
					echo "<form method=post action=". base_url('moderator/user_delete_warning') .">";
					print "<input type=hidden name=userid value=" . $user_id . ">";
					print "<input type=hidden name='returnto' value='userdetails.php?id=" . $user_id . "'>";
					print "<input type=hidden name=action value=disable_warning>";
					//print "<input type=checkbox name=sure>";
					print "<input type=submit  data-toggle='tooltip' data-placement='top' title='Waarschuwing verwijderen.' class='btn btn-warning btn-block' value='Waarschuwing verwijderen'></form>";
								?>
				</div>	
			</div>
				
				
			<div class="col-md-6 col-lg-4">
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php 
					echo "<form method=post action=". base_url('moderator/user_ip_ban') .">";
					print "<input type=hidden name=userid value=" . $user_id . ">";
					print "<input type=hidden name=action value=disable_ban>";
					//print "<input type=checkbox name=sure>";
					print "<input type=submit data-toggle='tooltip' data-placement='top' title='Gebruikers account uitschakelen met een ip-ban.' class='btn btn-danger btn-block' value='IP-BAN'></form>";
					?>
				</div>
			</div>
				
				
			<div class="col-md-6 col-lg-4">
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php 
					echo "<form method=post action=". base_url('moderator/user_class_edit') .">";
					print "<input type=hidden name=user_id value=" . $user_id . ">";
					print "<input type=submit data-toggle='tooltip' data-placement='top' title='Gebruikers status wijzigen.' class='btn btn-default btn-block' value='Gebruiker status'></form>";
					?>

				</div>
			</div>
				
				
			<div class="col-md-6 col-lg-4">
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php 
					echo "<form method=post action=". base_url('moderator/user_account_on') .">";
					print "<input type=hidden name=userid value=" . $user_id . ">";
					print "<input type=hidden name='returnto' value='userdetails.php?id=" . $user_id . "'>";
					print "<input type=hidden name=action value=enable_account>";
					///print "<input type=checkbox name=sure>";
					print "<input type=submit data-toggle='tooltip' data-placement='top' title='Gebruiker account aanzetten.' class='btn btn-default btn-block' value='Account AAN'></form>";
					?>
				</div>
			</div>
				
				
			<div class="col-md-6 col-lg-4">
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php 
					echo "<form method=get action=". base_url('moderator/alter_maxtorrents') .">";
					print "<input type=hidden name=user_id value=" . $user_id . ">";
					print "<input type=submit data-toggle='tooltip' data-placement='top' title='Aantal maxtorrents veranderen zodat deze persoon meer of minder actief kan hebben.' class='btn btn-default btn-block' value='Maxtorrent aantal veranderen'></form>";
					?>
				</div>
			</div>
				
				
			<div class="col-md-6 col-lg-4">
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php 
					echo "<form method=get action=". base_url('moderator/block_account') .">";
					print "<input type=hidden name=user_id value=" . $user_id . ">";
					print "<input type=submit data-toggle='tooltip' data-placement='top' title='Gebruikers account blokkeren, deze kan dan geen nieuwe torrents meer downloaden.' class='btn btn-default btn-block' value='Gebruikers account blokkeren'></form>";
					?>
				</div>
			</div>
				
				
			<div class="col-md-6 col-lg-4">
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php 
					echo "<form method=post action=". base_url('moderator/flush_torrents') .">";
					print "<input type=hidden name=user_id value=" . $user_id . ">";
					print "<input type=submit data-toggle='tooltip' data-placement='top' title='Ghost torrents verwijderen.' class='btn btn-default btn-block' value='Flush ghost torrents'></form>";
					?>
				</div>
			</div>
				
				
				
			</div>		
			
		<?php echo end_frame(); ?>
		<?php } ?>
		
		
		<?php if ($this->member->get_user_class() >= UC_MODERATOR){?>
		<?php echo begin_frame('Moderator opties voor gebruiker '. $this->member->get_username($user_id).'','info');?>
		<div class="row">
		
			<div class="col-md-6 col-lg-4">
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php echo form_open('moderator/del_peer_user/'. $user_id .'');?>
					<?php echo form_submit('','Bronnen verwijderen','data-toggle="tooltip" data-placement="top" title="Alle bronnen van verwijderen." class="btn btn-default btn-block"');?>
					<?php echo form_close();?>
				</div>
			</div>
			
			<div class="col-md-6 col-lg-4">
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php echo form_open('moderator/user_country/' . $user_id . '');?>
					<?php echo form_submit('','Land wijzigen','data-toggle="tooltip" data-placement="top" title="Land wijzigen." class="btn btn-default btn-block"');?>
					<?php echo form_close();?>
				</div>
			</div>
			
			<div class="col-md-6 col-lg-4">
				<div style="background: #f6f6f6; border: 1px solid #bbb; padding: 10px; margin-bottom: 10px;">
					<?php echo form_open('moderator/user_avatar/' . $user_id . '');?>
					<?php echo form_submit('','Avatar verwijderen','data-toggle="tooltip" data-placement="top" title="Avatar verwijderen inclusief een waarschuwing pm" class="btn btn-info btn-block"');?>
					<?php echo form_close();?>
				</div>
			</div>
			
		</div>
		<?php echo end_frame();?>
		<?php
	}
?>
<script>

  $('[data-toggle="tooltip"]').tooltip()

</script>