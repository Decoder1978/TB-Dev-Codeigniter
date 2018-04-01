<?php 
	$row7 = $this->db->query("SELECT * FROM massa_bericht_torrents WHERE torrent_id=$torrentid")->row_array();
	{
	if ($row7)
		{
		echo begin_frame('Massa bericht verzonden door '. $this->member->get_username($row7['sender'])." op ".$row7['added']." aan ".$row7['aantal'].' gebruikers.','default');
		echo $row7['msg'];
		echo end_frame();
		}
	}
	
echo begin_frame($row['name'], 'primary');
?>

	<p>Hier kunt u als uploader of hoger een bericht versturen naar alle gebruikers die met dezelfde torrent bezig zijn.<br>
	LET OP: Deze optie wijs gebruiken en niet voor onnodige zaken.</p>
	
	<?php $totaal = $this->db->where('torrent', $torrentid)->get('downup')->num_rows();?>

	<p>Dit bericht wordt dus naar <?php echo $totaal?> gebruikers verstuurd die:<br />
	<ul>
		<li>Iedereen die deze torrent momenteel aan het ontvangen zijn.
		<li>Iedereen die deze torrent aan de torrent compleet ontvangen hebben.
		<li>Iedereen die deze torrent aan het delen is, dus ook de uploader.
		<li>Iedereen die deze torrent ooit met deze torrent is begonnen.
	</ul>
	</p>
	<p>NIET voor vragen om bedankjes en NIET voor pakken en wegwezen (misbruik wordt bestraft).</p>
	<p>
	<form class="form" name="save_new" method="post" action='<?php echo base_url('torrents/torrent_mass_message/'.$torrentid.'');?>'>
		<input type="hidden" name="action" value="sendmessage">
		<input type="hidden" name="torrentid" value="<?php echo $torrentid?>">
		<textarea name="message" class="form-control" rows="15"><?php echo htmlspecialchars($sjabloon)?></textarea>
		<br><br>
		<input type="submit" class="btn btn-default" value='Berichten versturen'>
	</form>
	</p>
<?php echo end_frame()?>






