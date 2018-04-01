<form id="login-form" class="form-horizontal" method="post" action="<?php base_url('auth/login');?>">
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
