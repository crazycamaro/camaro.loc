<h4>upload your image</h4>


<?//= $album_id;?>

<?php
if(!empty($error))
{
    echo $error['error'] ;
}

?>

<?php echo form_open_multipart('upload/do_upload_for_albums/'.$album_id);?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="Загрузить" />

</form>