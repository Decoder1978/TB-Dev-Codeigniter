<?php $this->load->view('include/header');?>
<div class="container">
    	<div class="row">
			<div class="col-md-6 col-md-offset-3" style="margin-top: -100px;">
				<div class="panel panel-default" style="box-shadow: 0px 1px 13px #000;">
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-12">
								<span class="pull-left"><a href="#" class="active btn btn-default" id="login-form-link">Aanmelden</a></span>
								<span class="pull-right"><a href="#" class=" btn btn-default" id="register-form-link">Registreren</a></span>
							</div>							
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<?php $this->load->view('signup_form'); ?>
								<form id="register-form" action="<?php base_url('auth/signup');?>" method="post" role="form" style="display: none;">
								<?php echo modules::run('auth/signup');?>
								</form>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script>
	$(function() {

    $('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});

});

	</script>
<?php $this->load->view('include/footer');?>