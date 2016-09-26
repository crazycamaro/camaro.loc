


<?php foreach($all_albums as $album) :?>

    <a href="<?php echo base_url().'album/inside_album/'.$album->id; ?>"> <?= $album->name;?></a>

<?php endforeach;?>


<hr>
<div style="float: right"><a href=<?php echo base_url()."album/index"; ?>>Create Album</a></div>

<a href="<?php echo base_url().'user/members'; ?>">Back to Dashboard</a>



