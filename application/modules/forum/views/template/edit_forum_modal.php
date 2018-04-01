<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Forum aanpassen</h4>
      </div>
      <div class="modal-body">

<?php

//begin_frame();
$result = $this->db->query("SELECT * FROM forums where id = '$id'");
	foreach($result->result_array() as $row)
		{
		?>

		<form method=post action="<?php echo base_url('forum/forum_admin');?>">
		<table class='table table-bordered'>

		<tr><td>Forum naam</td><td><input class="form-control" name="name" type="text" size="20" maxlength="60" value="<?=$row["name"];?>"></td></tr>
		<tr> <td>Forum omschrijving  </td><td><input class="form-control" name="desc" type="text" size="30" maxlength="200" value="<?=$row["description"];?>"></td></tr>
		<tr><td>Minimale lees rang </td><td>
			<select class="form-control" name=readclass>
			<?
				 $maxclass = $this->member->get_user_class();
			  for ($i = 0; $i <= $maxclass; ++$i)
				print("<option value=$i" . ($row["minclassread"] == $i ? " selected" : "") . ">" . $this->member->get_user_class_name($i) . "\n");
		?>
			</select>
			</td>
		  </tr>
		  <tr>
			<td>Minimale post rang </td>
			<td><select class="form-control" name=writeclass>\n
			<?
				  $maxclass = $this->member->get_user_class();
			  for ($i = 0; $i <= $maxclass; ++$i)
				print("<option value=$i" . ($row["minclasswrite"] == $i ? " selected" : "") . ">" . $this->member->get_user_class_name($i) . "\n");
		?>
			</select></td>
		  </tr>
		  <tr>
			<td>Minimale aanmaak topic rang </td>
			<td><select class="form-control" name=createclass>\n
			<?
				$maxclass = $this->member->get_user_class();
			  for ($i = 0; $i <= $maxclass; ++$i)
				print("<option value=$i" . ($row["minclasscreate"] == $i ? " selected" : "") . ">" . $this->member->get_user_class_name($i) . "\n");
		?>
			</select></td>
		  </tr>
			<tr>
			<td>Forum rang </td>
			<td>
			<select class="form-control" name=sort>\n
			<?
		$res = $this->db->query("SELECT sort FROM forums");
		$nr = $res->num_rows();
				$maxclass = $nr + 1;
			  for ($i = 0; $i <= $maxclass; ++$i)
				print("<option value=$i" . ($row["sort"] == $i ? " selected" : "") . ">$i \n");
		?>
			</select>
			
			
			</td>
		  </tr>
		  
		  <tr align="center">
			<td colspan="2"><input type="hidden" name="action" value="editforum"><input type="hidden" name="id" value="<?=$id;?>"><input type="submit" name="Submit" value="Bewerk forum"></td>
		  </tr>
		  </form>
		</table>

		<?
		}    

//end_frame();
//}
		
?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Annuleren</button>
		</div>
    </div>
  </div>
</div>

<script type="text/javascript">
<!--
$('#editModal').modal('show');
//-->
</script>