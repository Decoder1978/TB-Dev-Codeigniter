<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php if(isset($pagetitle)){ echo 'Torrent Empire || '. $pagetitle .''; } else { echo 'Torrent Empire'; } ?></title>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">

	<!-- Optional theme -->
	<!--<link rel="stylesheet" href="https://bootswatch.com/slate/bootstrap.css">-->
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

	<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">


    <script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>

	<!-- Latest compiled and minified JavaScript -->
	<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
	<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>	
	<?php echo put_headers(); ?>
  </head>
  <body>
	<div class="main_container">
	<!--<header>
	  <div class="">
		<div class="container"></div>
	  </div>
	</header>-->

  <div class="sub-header">
	<div class="container" style="padding-left: 0px; padding-right: 0px;">
		<div class="row">
			<div class="col-xs-8 logo-div" style="margin-top: -15px;">
				Torrent Empire
			</div>
			<div class="col-xs-4">
				<form class="form" type="post" action="<?php echo base_url('torrents/search') ?>">
				  <div class="form-group">
					 <div class="input-group col-xs-12">
					  <input type="text" class="form-control" name="searchquery" placeholder="Torrents....">
					  <div class="input-group-addon"><button type="submit" class="btn btn-xs btn-link" style="padding: 0px 5px;">Zoeken</button></div>
					</div>
				  </div>
				  
				</form>	
			</div>
		</div>	
	</div>
  </div>
  
  
  
<div class="container" style="background: rgba(255,255,255, 0.95); margin-top: -52px; margin-bottom: 50px; padding-bottom: 20px; border: 1px solid #bbb;">
<div class="row" style="">


	  <nav class="navbar navbar-inverse navbar-static-top" style=" margin-bottom: 0px;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
<?php 
			foreach($query->result() as $menu)
			{
				
				if($this->uri->segment(1)==''. $menu->url .'')
				{
					$active = 'class="active_menu"';
				}else{
					$active = '';
				}
				echo '<li><a '. $active .' href="'. base_url(''. $menu->url .'').'"><span class="glyphicon '. $menu->icon .'" aria-hidden="true"></span> '. $menu->name .'</a></li>';
			}
							if($this->uri->segment(1)=='forum')
				{
					$active = 'class="active_menu"';
				}else{
					$active = '';
				}
				
			echo '<li><a '. $active .' href="'. base_url('forum').'"><span class="glyphicon glyphicon-search aria-hidden="true"></span> Forum</a></li>';
			

			

			echo '<li><a '. $active .' href="'. base_url('staff').'"><span class="glyphicon '. $menu->icon .'" aria-hidden="true"></span> Staff</a></li>';
			
			if ($this->member->get_user_class() >= UC_MODERATOR)
			{
				echo '<li><a '. $active .' href="'. base_url('moderator').'"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Moderator</a></li>';
			}
?>

      </ul>
	  
	        <ul class="nav navbar-nav navbar-right">
			<?php $this->load->view('partials/sidebar-top-message'); ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->userdata('username');?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
			<ul class="list-group" style="width: 240px; margin: 10px;">
			  <li class="list-group-item"><span class="badge"><?php echo $new_messages;?></span>Nieuwe berichten</li>
			  <li class="list-group-item">Dapibus ac facilisis in</li>
			  <li class="list-group-item">Morbi leo risus</li>
			  <li class="list-group-item">Porta ac consectetur ac</li>
			  <li class="list-group-item">Vestibulum at eros</li>
			</ul> 
          </ul>
        </li>
		<li><a class="" data-toggle="logout" data-placement="left" title="Uitloggen" href="<?php echo base_url('auth/logout')?>"><span class="glyphicon glyphicon-off text-danger" aria-hidden="true"></span></a></li>
		<script>
		$(function () {
		  $('[data-toggle="logout"]').tooltip()
		})
		</script>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<?php echo $this->breadcrumb->output(); ?>



<div class="col-xs-12">
	
			<?php if(isset($site_message))
		{
			echo $site_message['text'];
		}
		$ratio = number_format((($user->downloaded > 0) ? ($user->uploaded / $user->downloaded) : 0),2);
		
		if ($user->donor == 'no' && $ratio > 0.1 && $ratio < 0.6)
		{
		echo "<div class='alert alert-danger'><center>** UW RATIO IS LAGER DAN IS TOEGESTAAN, DOE HIER SNEL IETS AAN !!! ** </center></div>";	
		}
			
		if ($user->donor == 'no' && $user->warned == 'yes')
		{
		echo "<div class='alert alert-danger'><center> ** U BENT GEWAARSCHUWD VOOR HET NIET HOUDEN AAN DE REGELS !!! ** </center></div>";	
		}
			
		?>
		<?php $this->load->view('include/flashdata');?>


