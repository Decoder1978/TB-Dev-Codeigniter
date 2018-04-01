		<div  id="sidebar-wrapper" style="bottom: 0px; height: 100%; width: 250px; border-right: 1px solid #bbb;">
		<div class="logopanel" style="margin-right: -1px;">
        	<h1><a href="<?php echo base_url(); ?>"> <?php echo $this->config->item('site_name') ?> <span>v1.0</span></a></h1>
        </div>
			<div class="sub-header" style="margin-top: 0px; margin-right: -1px;">
				<div class="time-date"  style=""><?php echo date("Y-m-d | H:i:sa"); ?></div>
			</div>
			
			<div class="">
				<div class="sidebar-top-box">
					<div class="sidebar-top-box-item">
						<a href="<?php echo base_url('auth/logout'); ?>"><span class="text-danger top-transform glyphicon glyphicon-off" style=""></span></a>
					</div>	
					<div class="sidebar-top-box-item"><span class="glyphicon glyphicon-cog"></span></div>	
					<div class="sidebar-top-box-item"><?php $this->load->view('partials/sidebar-top-user'); ?></div>	
					<div class="sidebar-top-box-item"><?php $this->load->view('partials/sidebar-top-message'); ?></div>	
				</div>

				
				<div class="" style="position: relative;">
				<span class="sidebar-user-avatar"><?php echo $this->member->get_username($this->session->userdata('user_id')) ?></span>
				<span class="sidebar-user-rank"><?php echo $this->member->get_user_class_name($this->session->userdata('class')) ?></span>
				<?php echo $this->member->get_user_avatar($this->session->userdata('user_id')) ?>
				
				</div>

				
            <ul class="sidebar-nav">
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
			
			if ($this->member->get_user_class() >= UC_UPLOADER)
			{
				if($this->uri->segment(1) == 'torrents' && $this->uri->segment(2) == 'upload')
				{	
				$active = 'class="active_menu"';
				}else{
				$active = '';
				}
				echo '<li><a '. $active .' href="'. base_url('torrents/upload').'"><span class="glyphicon glyphicon-transfer aria-hidden="true"></span> Torrent uploaden</a></li>';
			}
			

			echo '<li><a '. $active .' href="'. base_url('staff').'"><span class="glyphicon '. $menu->icon .'" aria-hidden="true"></span> Staff</a></li>';
			
			if ($this->member->get_user_class() >= UC_MODERATOR)
			{
				echo '<li class="list-group-item-success" style="border-right: 1px solid #bbb;"><a '. $active .' href="'. base_url('moderator').'"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Moderator</a></li>';
			}
			?>
			</ul>
			</div>
			
			<div class="sidebar-footer" style="">
			sidebar footer block
			</div>
		</div>
		