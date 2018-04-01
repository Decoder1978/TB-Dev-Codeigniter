    <div class="navbar navbar-inverse navbar-static-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url();?>">Torrent Empire</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-left">
			  
			  	<!--<li><a class="btn btn-link" href="#" data-toggle="modal" data-target="#myModal">Torrent uploaden</a></li>-->
		</ul>
          <ul class="nav navbar-nav navbar-right">
		  <li></li>
				<li>
				     <a>
						  <img src="<?php echo base_url('/assets/img/Actions-arrow-up-icon.png');?>" alt="Uploaded"  height="16" width="16"> <?php echo byte_format($user->uploaded); ?> 
						  <img src="<?php echo base_url('/assets/img/Actions-arrow-down-icon.png');?>" alt="Downloaded"  height="16" width="16"> <?php echo byte_format($user->downloaded); ?> 
				    </a>
		          </li>
		     
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $user->username; ?> <b class="caret"></b></a>
                <ul class="dropdown-menu" role="menu">
                    
                        <li class="dropdown-header">Admin panel</li>
                        <li>
		                    <a href="{$getConfigs.baseurl}/admincp?tokenAdmin={$smarty.cookies.tokenAdmin}">
		                    	<i class="fa fa-cogs"></i> Instellingen
		                    </a>
                        </li>
                        <li>
		                    <a href="{$getConfigs.baseurl}/admincp/users/?tokenAdmin={$smarty.cookies.tokenAdmin}">
		                    	<i class="fa fa-user"></i> Gebruikers
		                    </a>
                        </li>
                        <li>
		                    <a href="{$getConfigs.baseurl}/admincp/usersgroups/?tokenAdmin={$smarty.cookies.tokenAdmin}">
		                    	<i class="fa fa-users"></i> Groepen
		                    </a>
                        </li>
                        <li>
		                    <a href="<?php  echo base_url('categories');?>">
		                    	<i class="fa fa-sort-amount-asc"></i> Categories
		                    </a>
                        </li>
                        <li>
		                    <a href="{$getConfigs.baseurl}/admincp/themes/?tokenAdmin={$smarty.cookies.tokenAdmin}">
		                    	<i class="fa fa-picture-o"></i> Themes management
		                    </a>
                        </li>
                        <li>
		                    <a href="{$getConfigs.baseurl}/admincp/plugins/?tokenAdmin={$smarty.cookies.tokenAdmin}">
		                    	<i class="fa fa-cubes"></i> Plugins 
		                    </a>
                        </li>      
                        <li class="divider"></li>   
                        
                        <li class="dropdown-header">User panel</li>
                        <li>
		                    <a href="{$getConfigs.baseurl}/account?token={$smarty.cookies.token}">
		                    	<i class="fa fa-cog"></i> Account
		                    </a>
                        </li>
                        <li>
		                    <a href="{$getConfigs.baseurl}/index.php?page=logout">
		                    	<i class="fa fa-power-off"></i> uitloggen
		                    </a>
                        </li>
                       
                </ul>
              </li>
 
             

 
          </ul>          
        </div>
      </div>
    </div>
