<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Simple Sidebar - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>/assets/css/simple-sidebar.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="<?php echo base_url();?>/assets/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>/assets/js/bootstrap.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<style>
html { 
  background: url(<?php echo base_url();?>assets/img/background.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}
body{
	background-color: transparent;
}
	.spacer{
		margin-top: 15%;
	}

</style>
</head>

<body>
<div class="spacer">&nbsp;</div>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">


				<div class="" style="
								padding: 20px; 
								background: rgba(0,0,0, 0.6);
								color: white;">
				<h2><?php echo lang('login_heading');?></h2>
				<p><?php echo lang('login_subheading');?></p>
				<div id="infoMessage"><?php echo $message;?></div>
				
				<form class="form-horizontal" method="post" action="<?php base_url('auth/login');?>">
				  <div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
					  <?php echo form_input($identity);?>
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
					<div class="col-sm-10">
					   <?php echo form_input($password);?>
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					  <div class="checkbox">
						<label>
							<?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
							<?php echo lang('login_remember_label', 'remember');?>
						</label>
					  </div>
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					  <?php echo form_submit('submit', lang('login_submit_btn'),'class="btn btn-primary"');?>
					</div>
				  </div>
				</form>
				<p></p>
				<p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>

				</div>

		</div>
	</div>
</div>
</body>
</html>