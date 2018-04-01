	  <nav class="navbar navbar-default navbar-fixed-top" style="">
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
				echo '<li><a '. $active .' href="'. base_url('moderator').'"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Moderator</a></li>';
			}
?>

      </ul>
	  
	        <ul class="nav navbar-nav navbar-right">
        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>