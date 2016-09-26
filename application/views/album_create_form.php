<h4>Create new Album</h4>

<form action=<?php echo base_url()."album/create"; ?> method="post">

    <p>
        <p>Album Name</p>
    <input type="text" name="album_name">
    </p>

    <p>
        <button type="submit">Create</button>
    </p>

</form>