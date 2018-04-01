<?php $this->load->view('include_auth/header'); ?>
<?php 
if(isset($message)){echo '<p>'. $message .'</p>';}
?>
<div class="row">
<div class="col-lg-6">
<h3>Welkom op Torrent Empire</h3>
<p>Meer text hier......</p>
</div>
<div class="col-lg-6">
<form id="register-form" action="<?php base_url('auth/signup');?>" method="post" role="form">
            <div class="form-group">    
                <label for="username">Gebruikersnaam</label>
                <?php echo form_input($username); ?>
            </div>

            <div class="form-group">    
                <label for="email">Email</label>
                <?php echo form_input($email); ?>
            </div>

            <div class="form-group">    
                <label for="country">Land</label>
                <?php echo $country; ?>
            </div>

            <div class="form-group">    
                <label for="password">Wachtwoord</label>
                <?php echo form_input($password); ?>
            </div>


            <div class="form-group">    
                <label for="password_again">Normaals Wachtwoord</label>
                <?php echo form_input($password_confirm); ?>
            </div>

            <input type="submit" name="submit" value="Registreren!" class="btn btn-primary btn-sm" />
	<?php echo form_close(); ?>

	</div>
</div>
<?php $this->load->view('include_auth/footer'); ?>
