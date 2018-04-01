<?php echo $paginas; ?>
<table class="table table-hover table-bordered">
	<tr><th class="col-md-6">Naam</th><th>Formaat</th><th>Delers</th><th>Ontvangers</th><th>Datum</th></tr>

<?php for ($x = 0; $x <= 10; $x++) { ?>
<tr><td>Naam</td><td>Formaat</td><td>Delers</td><td>Ontvangers</td><td>Datum</td></tr>
<?php } ?> 
<?php foreach ($torrent->result() as $row) { ?>
<tr><td><?php echo $row->name ?></td><td><?php echo $row->size ?></td><td><?php echo $row->seeders ?></td><td><?php echo $row->leechers ?></td><td><?php echo $row->added ?></td></tr>
<?php } ?> 

</table>