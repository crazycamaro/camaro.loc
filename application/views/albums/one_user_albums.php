

<?php foreach($albums as $album)   :?>
     <a href="<?php echo base_url().'album/inside_album/'.$album->id; ?>"> <?= $album->name;?></a>
<?php endforeach;?>