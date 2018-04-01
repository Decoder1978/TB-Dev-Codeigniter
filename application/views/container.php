<?php if(isset($links)):?>
<div class="row">
	<div class="btn-group" role="group" aria-label="..." style="margin-bottom: 20px; margin-left: 15px;">
	<?php foreach($links as $item):?>
	<?php echo $item ?>
	<?php endforeach; ?> 
	</div>
</div>
<?php endif;?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
		<?php echo $title ?>
        </h3>
	</div>
    <div class="panel-body">
	<?php echo $comment ?>
    </div>
</div>

