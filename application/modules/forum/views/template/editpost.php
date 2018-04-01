<?php echo begin_frame('Bewerk post','primary'); ?>
<form method="post" action="<?php echo base_url('forum/edit/'. $postid.'/'. $topicid.'') ?>">
<table class="table table-bordered">
<tr><td>
<textarea class="form-control summernote" name="body"  rows="24"><?php echo stripslashes(htmlspecialchars($arr["body"])) ?></textarea>
</td></tr>
<tr><td><input type="submit" name="submit" value="Bewerk" class="btn btn-primary btn-sm"></td></tr>
</table>
</form>
<?php echo end_frame(); ?>