<?php
echo begin_frame('Forum overzicht','primary');
echo "<table class='table table-bordered'>";
echo "<tr><th>Naam</th>
		  <th style='width: 100px;'>Topics</th>
		  <th style='width: 100px;'>Posts</th>
		  <th style='width: 100px;'>Lezen</th>
		  <th style='width: 100px;'>Posten</th>
		  <th style='width: 100px;'>Aanmaken</th>
		  <th style='width: 100px;'>Bewerk</th></tr>";
		  
		  $this->db->select('*');
		  $this->db->order_by('sort', 'ASC');
		  $result = $this->db->get('forums');

	if ($result->num_rows() > 0) 
		{
			foreach($result->result_array() as $row) 
			{
			echo "<tr><td><a href=forums.php?action=viewforum&forumid=".$row["id"]."><b>".$row["name"]."</b></a><br>".$row["description"]."</td>";
			echo "<td>".$row["topiccount"]."</td>
				  <td>".$row["postcount"]."</td>
				  <td>" . $this->member->get_user_class_name($row["minclassread"]) . "</td>
				  <td>" . $this->member->get_user_class_name($row["minclasswrite"]) . "</td>
				  <td>" . $this->member->get_user_class_name($row["minclasscreate"]) . "</td>";
				  echo "<td><a class='btn btn-info btn-sm' href='". base_url('forum/forum_edit/'.$row['id'].'') ."'><span class='glyphicon glyphicon-pencil'></span></a>&nbsp;|&nbsp;";
				  echo "<a class='btn btn-danger btn-sm' href='". base_url('forum/forum_delete/'.$row['id'].'') ."'><span class='glyphicon glyphicon-trash'></span></a></td></tr>";
			?>

			<?php
			} 
		} 
		else 
		{
		print "<tr><td>Sorry, Niks Gevonden!</td></tr>";
		}      
	echo "</table>";
	
	echo '<div class="row">';
	echo '<div class="col-xs-12"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Nieuwe forum aanmaken</button></div>';
	?>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Maak nieuwe forum</h4>
      </div>
      <div class="modal-body">
        <?php $this->load->view('template/add_forum_modal');?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Annuleren</button>
		</div>
    </div>
  </div>
</div>
<?php 
	echo '</div>';
echo end_frame();	
?>
