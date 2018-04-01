<?php 
	defined('BASEPATH') OR exit('No direct script access allowed'); 
if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}
		
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php if(isset($pagetitle)){ echo 'Torrent Empire || '. $pagetitle .''; } else { echo 'Torrent Empire'; } ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url('assets/css/simple-sidebar.css');?>" rel="stylesheet">    
	<link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">
	<!--<link href="https://bootswatch.com/slate/bootstrap.min.css" rel="stylesheet">-->
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.js"></script>

	<?php echo put_headers(); ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<script>
	$(document).ready(function() {
	$('.summernote').summernote({height: 350,
  toolbar: [
    //[groupname, [button list]]
     
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']],
	['insert',['video','table','hr']]
  ]
});	});
	
	
	

	
	
	</script>
</head>

<body>


<div class="main_container" id="wrapper">
<?php echo $this->load->view('partials/sidebar');?>
	<div class="section">		
		
		<div  id="page-content-wrapper">
		<div class="headerpanel">
		<a href="#menu-toggle" class="showmenu" id="menu-toggle"><span class="glyphicon glyphicon-menu-hamburger"></span></a>
			<div class="headerright">
				<div class="dropdown userinfo">
                    <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#">Hoi, <?php echo $this->session->userdata('username');?>! <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url('members/profile/'. $this->session->userdata('username') .'');?>"><span class="glyphicon glyphicon-edit"></span> Profiel aanpassen</a></li>
                        <li class="divider"></li>
                        <li><a href=""><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Instelingen</a></li>
                        <li><a href=""><span class="glyphicon glyphicon-eye-open"></span> Privacy Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url('auth/logout'); ?>"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Uitloggen</a></li>
                    </ul>
                </div><!--dropdown-->
    		
            </div>
		</div>
			<div class="sub-header" style="">
			
			<?php echo $this->breadcrumb->output(); ?>
			</div>
			
			
		<div class="pagetitle" style="">
		<?php if(isset($pagetitle)){?>
        	<h1><?php echo $pagetitle ?></h1> <span><?php echo $pagedescription ?></span>
		<?php }else{ ?>
		    <h1>Omschrijfing</h1> <span>Je moet nog een omschrijfing laatsen suflul !!</span>
		<?php } ?>
        </div>
		<div class="content-box">
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
			
			
			
			