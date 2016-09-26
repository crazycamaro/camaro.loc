<h4>upload your image</h4>

<?php
if(!empty($error))
{
    echo $error['error'] ;
}

?>

<?php echo form_open_multipart('upload/do_upload');?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="Загрузить" />

</form>