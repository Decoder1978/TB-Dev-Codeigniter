<?php $this->load->view('include_auth/header'); ?>
	<a class="btn btn-primary btn-lg btn-block" href="" data-toggle="modal" data-target="#myModal">Inloggen - Aanmelden</a>
	<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Login - Signup</h4>
      </div>
      <div class="modal-body">
    <p><?php echo lang('login_subheading'); ?></p>

    <?php if(!empty($message)) echo '<div id="infoMessage" class="alert alert-warning"><i class="fa fa-warning"></i> '.$message.'</div>';?>

    <?php echo form_open("auth/login", array('class' => 'form-horizontal')); ?>
    <?php $error = (isset($field['name'])) ? form_error($field['name']) : NULL; ?>
    <div class="control-group <? if (!empty($error)): ?>error<? endif; ?>">
        <div class="form-group">
            <?php echo form_label($this->lang->line('login_identity_label'), 'identity', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-12"><?php echo form_input($identity, NULL, 'class="form-control"'); ?></div>
        </div>

        <div class="form-group">
            <?php echo form_label($this->lang->line('login_password_label'), 'password', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-12"><?php echo form_input($password, NULL, 'class="form-control"'); ?></div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
            <div class="checkbox">
            <label>
                <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?> <?php echo $this->lang->line('login_remember_label'); ?>
            </label>
            </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12"><?php echo form_submit(array('class' => 'btn btn-primary btn-large', 'name' => 'login', 'value' => 'Login')); ?></div>
        </div>
    </div>
    <?php echo form_close(); ?>

    <p><a href="forgot_password"><?php echo lang('login_forgot_password'); ?></a></p>       
      </div>

    </div>
  </div>
</div>    



<?php $this->load->view('include_auth/footer'); ?>
