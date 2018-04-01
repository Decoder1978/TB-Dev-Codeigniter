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
								<form id="register-form" action="http://phpoll.com/register/process" method="post" role="form" style="display: none;">
									<div class="form-group">
										<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
									</div>
									<div class="form-group">
										<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
									</div>
									<div class="form-group">
										<input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password">
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-default" value="Register Now">
											</div>
										</div>
									</div>
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