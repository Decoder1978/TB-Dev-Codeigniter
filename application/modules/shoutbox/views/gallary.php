	<div class="row">
		<?php for ($i = 0; $i < 6; $i++) { ?>
			<div class="col-xs-6 col-sm-6 col-md-4 col-lg-2 hidden-xs hidden-sm">
				<a id="example" href="#" class="thumbnail">
					<img class="img-responsive" src="http://lorempixel.com/500/620/people" alt="...">
				</a>
			</div>			
		<?php } ?> 
		 
		<script>
		$('#example').popover({
		trigger: 'hover',
		html: true,
		title: 'Spiderman III',
		content: 'Dit is dus de test block',
		template: '<div class="popover col-md-12" role="tooltip"><div class="arrow"></div><h2 class="popover-title"></h2><div class="popover-content"></div></div>'
		})
		</script>
	</div>