
<!--//stuga u het ta sax nkarnery, aysinqn sax nkarnery pti stana $var -mej u heto for ciklov hana-->

<form action="<?= base_url().'image/delete_checked_photos/'.$album_id?>" method="post">
    <?php
    foreach($all_photo_name as $photo_name) :?>
       <div style="float: left;height: 230px;width: 300px; text-align: center;padding: 10px">

        <img src= "../../upload/albums/<?= $email;?>/<?= $album_id;?>/<?= $photo_name->name;?>" alt="picture" width="300" height="200" >
            <?php if($current_user_email==$email):?>
                <p>
                    <a href=<?= base_url().'image/delete_photo/'.$photo_name->name."/".$album_id?>>delete</a>
                    <input type="checkbox" name="check_list[]" value="<?= $photo_name->name?>" >
                </p>
            <?php endif;?>
       </div>
     <?php endforeach;?>
    <?php if($current_user_email == $email):?>
    <button style="position: absolute;right: 0;top: 220px" type="submit" name="submit">delete checked photos</button>
<?php endif;?>

</form>


<div style="float: right; position: absolute;top: auto;right: 0px;">
 <hr>
<a href=<?= base_url()."user/members"?>>Back to Dashboard</a>

    <?php if($current_user_email == $email):?>

  <div >
        <hr>
        <a href=<?php echo base_url()."upload/index_for_album/".$album_id; ?>>Download new image</a><br>




        <hr>
        <a href=<?= base_url()."album/delete_album/".$album_id?>>Delete Album</a>

      <hr>


  </div>
<?php endif;?>
</div>
