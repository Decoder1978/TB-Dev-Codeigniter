
<?php echo $error;?>
<?php echo form_open_multipart('torrents/do_upload/'. $id.'');?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="hidden" name="torrent_id" value="<?php echo $id; ?>" />
<input type="submit" value="upload" />

</form>