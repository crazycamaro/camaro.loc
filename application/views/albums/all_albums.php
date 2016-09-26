<h1 style="text-align: center">All Albums</h1>
<hr>


<?php foreach ($users as $user) :?>
    <a href=<?= base_url().'album/one_user_albums/'.$user->id?>> <?= $user->email?></a><br>


<?php endforeach;?>


