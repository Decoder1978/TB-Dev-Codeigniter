	<?php if($this->session->flashdata('info')): ?> 
	<div class="alert alert-info alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php echo $this->session->flashdata('info'); ?>
	</div>
	<?php endif; ?>	
	
	<?php if($this->session->flashdata('message')): ?> 
	<div class="alert alert-info alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php echo $this->session->flashdata('message'); ?>
	</div>
	<?php endif; ?>	
	
	<?php if($this->session->flashdata('danger')): ?> 
	<div class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php echo $this->session->flashdata('danger'); ?>
	</div>
	<?php endif; ?>
	
	<?php if($this->session->flashdata('success')): ?> 
	<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<?php echo $this->session->flashdata('success'); ?>
	</div>
	<?php endif; ?>