<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shoutbox extends MY_Controller {
	
	function __construct() {
        parent::__construct();
		
		$this->load->language('shoutbox/shoutbox_msg');
	}


	public function index() 
	{
		$data['shouts'] = $this->db->get('shoutbox');
		$this->template('table', $data);
	}

	public function add()
	{
		$data = array(
			'user_id' => $this->input->post('user_id'),
			'username' => $this->input->post('username'),
			'content' => $this->input->post('content'),
			'created_at' => get_date_time(),
		);
		$this->db->insert('shoutbox', $data);
		
		//$this->session->set_flashdata('info', 'bericht toegevoegd !');
		//redirect('shoutbox');
	}

	public function show($id)
	{
		
	}

	public function edit($id)
	{
		
	}

	public function delete($id)
	{
	$this->db->query("DELETE FROM shoutbox WHERE id=$id");
	echo '<div class="alert alert-success">Regel verwijderd !!</div>';
	}

	public function updateUsers()
	{
		$user_seen = $this->session->userdata('user_id');//CURUSER['id'];
		$seen = $this->db->escape(get_date_time());
		//$action = $_POST['action'];


		$aantal = 0;

			$active1 = $this->db->query("SELECT * FROM users WHERE last_page='shoutbox' ORDER BY username");
			$activeusers = "";
									   
		foreach($active1->result_array() as $arr)
			{
				  if ($activeusers) $activeusers .= "";
				  switch ($arr["class"])
				  {
				case 'UC_GOD':
					 $arr["username"] = "" . $arr["username"] . "";
					 break;
				case 'UC_BEHEERDER':
					 $arr["username"] = "" . $arr["username"] . "";
					 break;
				
				case 'UC_ADMINISTRATOR':
					 $arr["username"] = "" . $arr["username"] . "";
					 break;
				case 'UC_MODERATOR':
					 $arr["username"] = "" . $arr["username"] . "";
					 break;
				case 'UC_UPLOADER':
					 $arr["username"] = "" . $arr["username"] . "";
					 break;
				case 'UC_VIP':
					 $arr["username"] = "" . $arr["username"] . "";
					 break;
				 case 'UC_POWER_USER':
					 $arr["username"] = "" . $arr["username"] . "";
					 break;
				 case 'UC_USER':
					 $arr["username"] = "" . $arr["username"] . "";
					 break;

				  }
			  $aantal += 1;

			$activeusers .= '<li class="list-group-item">'. $this->member->get_username($arr['id']) .'</li>';
			}
			


		if (!$activeusers)
		  $activeusers = "Er zijn geen actieve gebruikers in de chat aanwezig.....";

		echo $activeusers ;		
	}	
	
	public function get_shouts()
	{
		$res = $this->db->query("SELECT * FROM shoutbox ORDER BY created_at DESC LIMIT 20");
		
		foreach($res->result_array() as $row)
		{	
		$datum = "<font color=gray>". timespan(human_to_unix($row['created_at']),'',1) ."</font>";
		$tekst = stripslashes($row['content']); 
		$tekst = htmlspecialchars($tekst);
		

		$class = $this->member->get_user_class($row['user_id']);
		//$class = '';
		if($class['class'] == UC_BEHEERDER)
		{
		$color = "red";
		}
		elseif($class['class'] == UC_GOD)
		{
		$color = "blue";
		}
		else
		{
		$color = "";
		}
		?>
		<div class="media" style="border: 1px solid #bbb; padding: 10px; box-shadow: 1px 1px 6px 1px #ccc;">
		<!--  <div class="media-left">
			<a href="#">
			  <img class="media-object" src="http://placehold.it/60x60" alt="...">
			</a>
		  </div>-->

		  <div class="media-body">
			<h5 class="media-heading">
			<div class="row">
			<div class="col-xs-8"><?php echo $this->member->get_username($row["user_id"]) ?></div>
			<div class="col-xs-4">
			<small>
			<?php if ($this->member->get_user_class() >= UC_ADMINISTRATOR)
			{?>
			<span class="pull-right"><button class="btn btn-default btn-xs" style="margin-left: 5px;" onclick="deleterow(<?php echo $row['id']?>)">&times;</button></span>
			<?php } ?>
			<span class="pull-right"><?php echo $datum ?></span>

			</small></div>
			</div>
			</h5>
			<?php echo "<font color='$color'>".$tekst ."</font>" ?>
		  </div>
		</div>
		<script>
		function deleterow(str){
	var id = str;
	$.ajax({
		type: "post",
		url: "<?php echo base_url('shoutbox/delete/"+id+"') ?>"
	}).done(function(data){
		$('#ack').html(data);
		//viewdata();
	})
}
		</script>
		<?php 
		
		}
	}
	
}
