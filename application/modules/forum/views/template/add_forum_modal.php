<form method="post" action="<?php echo base_url('forum/forum_admin');?>">
<table class='table table-bordered'>

<tr><td class="col-xs-4">Forum naam</td><td><input class="form-control" name="name" type="text" size="20" maxlength="60"></td></tr>
<tr><td>Forum omschrijving</td><td><input class="form-control" name="desc" type="text" size="30" maxlength="200"></td></tr>

<tr><td>Minimale lees rang </td><td>
    <select class="form-control" name=readclass>
    <?php 
        $maxclass = $this->member->get_user_class();
        for ($i = 0; $i <= $maxclass; ++$i)
        print("<option value=$i" . ($this->session->userdata('class') == $i ? " selected" : "") . ">" . $this->member->get_user_class_name($i) . "\n");
	?>
</select></td></tr>
	
<tr><td>Minimale post rang </td><td>
	<select class="form-control" name=writeclass>
    <?php 
          $maxclass = $this->member->get_user_class();
      for ($i = 0; $i <= $maxclass; ++$i)
        print("<option value=$i" . ($this->session->userdata('class') == $i ? " selected" : "") . ">" . $this->member->get_user_class_name($i) . "\n");
	?>
</select></td></tr>

<tr><td>Minimale aanmaak topic rang </td><td>
	<select class="form-control" name=createclass>
    <?php
        $maxclass = $this->member->get_user_class();
      for ($i = 0; $i <= $maxclass; ++$i)
        print("<option value=$i" . ($this->session->userdata('class') == $i ? " selected" : "") . ">" . $this->member->get_user_class_name($i) . "\n");
	?>
</select></td></tr>


<tr><td>Forum rang </td><td>
<select class="form-control" name=sort>
    <?php
	$res = $this->db->query("SELECT sort FROM forums");
	$nr = $res->num_rows();
        $maxclass = $nr + 1;
      for ($i = 0; $i <= $maxclass; ++$i)
        print("<option value=$i>$i \n");
?>
</select></td></tr>

<tr align="center"><td colspan="2"><input type="hidden" name="action" value="addforum"><input type="submit" name="Submit" value="Foum opslaan!" class='btn btn-success'></td></tr>
</table>
</form>