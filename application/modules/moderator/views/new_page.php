<form class="form-horizontal" method="post" action="<?php echo base_url('moderator/add_new_page') ?>">

   <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Naam</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="name" id="inputEmail3" placeholder="Naam....">
	  <p class="help-block">De naam die zichtbaar is op de knop.</p>
    </div>
  </div>    
  
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">url</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="url" id="inputEmail3" placeholder="Url">
	  <p class="help-block">Naar welke functie moet deze knop verwijzen?</p>
    </div>
  </div>  
  
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Icoontje</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="img" id="inputEmail3" placeholder="Icoontje">
	  <p class="help-block">Welk icoontje krijgt deze knop?</p>
    </div>
  </div>  
  
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Class</label>
    <div class="col-sm-10">
    <?php echo $select;?>
	<p class="help-block">Selecteer een class voor welke deze knop zichtbaar is.</p>
    </div>
  </div>  
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label"></label>
    <div class="col-sm-10">
    <input class="btn btn-primary" type="submit" value="Pagina Verzenden">
    </div>
  </div>
<?php 

			print"</form>";  
			end_frame();	
			?>
