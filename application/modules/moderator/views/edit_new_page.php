<?php 
	if (get_user_class() < UC_BEHEERDER)
	{
	flash("error","Hackpoging gedetecteerd");
	exit();
	}
  
  $id = $_GET['id'];
  $res = mysql_query("SELECT * FROM admin_pages WHERE id=$id");
  $row = mysql_fetch_assoc($res);  
  tabel_top("Pagina ".$row['naam'] ." Bewerken");
  begin_frame();
  echo"<form method=post action=?action=edit_opslaan>";
  echo"<table class='table table-bordered'>";
  echo"<tr><td width=100px>Titel: </td><td><input class='input-block-level' type='text' name='titel' size='50' value='".$row['titel']."'></td></tr>";
  echo"<tr><td width=100px>Naam: </td><td><input class='input-block-level' type='text' name='naam' size='50' value='".$row['naam']."'></td></tr>";
  echo"<tr><td>Pagina: </td><td><input class='input-block-level' type='text' name='pagina' size='50' value=".$row['pagina']."></td></tr>";
  echo"<tr><td>Plaatje: </td><td><input class='input-block-level' type='text' name='img' size='50' value=".$row['img']."></td></tr>";
  echo"<input type=hidden name=id value=".$row['id'].">";
  echo"<tr><td>class: </td><td>";

	$classes = "";
	$maxclass = 7;

	for ($i = 0; $i <= $maxclass; ++$i)
    $classes .= "<option value=$i" . ($row["class"] == $i ? " selected" : "") . ">$prefix" . get_user_class_name($i) . "";

	echo "<select name=class>$classes</select>";
	  
  
  echo"</td></tr>";
  echo"<tr><td colspan=2><input type='submit' value='Verzenden' class='btn btn-success'></td></tr>";
  echo"</table></form>";  
  end_frame();
  ?>