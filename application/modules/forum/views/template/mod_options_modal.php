<?php
    $res = $this->db->query("SELECT id,name,minclasswrite FROM forums ORDER BY name");
		
		$template = '';
	    $template .= "<div id='myModal' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>";

		$template .= '<div class="modal-dialog" role="document">';
		$template .= '<div class="modal-content">';
        $template .="<div class='modal-header'>";
		$template .="<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>*</button>";
		$template .="<h4 id='myModalLabel'>Moderator forum opties en beheer.</h4>";
		$template .="</div>";
		
		$template .="<div class='modal-body'>";
		$template .="<table class='table table-bordered'>";
	    $template .="<form method=post action=". base_url('forum/setsticky') ." class='form-horizontal form-inline'>";
	    $template .="<input type=hidden name=topicid value=$topicid>";
	    //$template .="<input type=hidden name=returnto value=>";
		$template .="<tr><td>Sticky:</td>";
		$template .="<td><input type=radio name=sticky value='yes' " . ($sticky ? " checked" : "") . "> Ja</td>";
		$template .="<td><input type=radio name=sticky value='no' " . (!$sticky ? " checked" : "") . "> Nee</td>";
		
			if($sticky){
			$template .="<td><input type=submit value='Sticky uit' class='btn btn-block btn-primary btn-sm'></td>";
			}
			else{
			$template .="<td><input type=submit value='Sticky aan' class='btn btn-block btn-danger btn-sm'></td>";
			}
			
		$template .="</tr>";
	    $template .="</form>";

	    $template .="<form method=post action=". base_url('forum/setlocked') ." class='form-horizontal form-inline'>";// begin------------------
		$template .="<input type=hidden name=topicid value=$topicid>";
	    //$template .="<input type=hidden name=returnto value=>";
        $template .="<tr><td>Gesloten:</td>";
		$template .="<td><input type=radio name=locked value='yes' " . ($locked ? " checked" : "") . "> Ja</td>";
		$template .="<td><input type=radio name=locked value='no' " . (!$locked ? " checked" : "") . "> Nee</td>";
		
		if($locked){
		$template .="<td><input type=submit value='Forum openen' class='btn btn-block btn-primary btn-sm'></td>";
		}
		else{
		$template .="<td><input type=submit value='Forum sluiten' class='btn btn-block btn-danger btn-sm'></td>";
		}
		$template .="</tr>";
	    $template .="</form>";

	    $template .="<form method=post action=". base_url('forum/renametopic') ." class='form-horizontal form-inline'>";
	    $template .="<input type=hidden name=topicid value=$topicid>";
	    //$template .="<input type=hidden name=returnto value=>";
        $template .="<tr>";
		$template .="<td><strong>Hernoem:</strong></td>";
		$template .="<td colspan=2><input class='form-control' type=text name=subject maxlength=300 value=\"" . htmlspecialchars($subject) . "\"></td>";
		$template .="<td><input class='btn btn-primary btn-block btn-sm' type=submit value='Hernoemen!'></td>";
		//print"<td></td>";
		$template .="</tr>";
	    $template .="</form>";

	    $template .="<form method=post action=". base_url('forum/movetopic') ." class='form-horizontal form-inline'>";
		$template .="<input type=hidden name=topicid value=$topicid>";
        $template .="<tr>";
		$template .="<td><strong>Verplaats topic naar:</strong></td>";
		$template .="<td colspan=2>";
	    $template .="<select class='form-control' name=forumid>";

	    foreach ($res->result_array() as $arr)
	      if ($arr["id"] != $forumid && $this->member->get_user_class() >= $arr["minclasswrite"])
	        $template .="<option value=" . $arr["id"] . ">" . $arr["name"] . "";

	    $template .="</select>";
		$template .="</td>";
		$template .="<td><input type=submit value='Verplaatsen!' class='btn btn-primary btn-block btn-sm'></td>";
		//print"<td></td>";
		$template .="</tr>";
		$template .="</form>";

		if ($this->member->get_user_class() >= UC_ADMINISTRATOR)
	    {
	    $template .="<form method=post action=". base_url('forum/deletetopic') ." class='form-inline'>";
	    //$template .="<input type=hidden name=action value=deletetopic>";
	    $template .="<input type=hidden name=topicid value=$topicid>";
	    $template .="<input type=hidden name=forumid value=$forumid>";
        $template .="<tr>";
		$template .="<td><strong>Verwijder topic:</strong></td>";
		$template .="<td><input type=checkbox name=sure value=1></td>";
		$template .="<td></td>";
		$template .="<td><input type=submit value='Verwijderen!' class='btn btn-danger btn-block'></td>";
		$template .="</tr>";
	    $template .="</form>";
		}
	$template .="</table>";  
	$template .="</div>";
    $template .="<div class='modal-footer'>";
	$template .="<button class='btn btn-primary' data-dismiss='modal' aria-hidden='true'>Moderator scherm sluiten</button>";
	$template .="</div>";	
	$template .="</div>";
	$template .="</div>";
    $template .="</div>";
	
	echo $template;
?>