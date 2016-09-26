<div style="float: right">
<br>
    <a href=<?php echo base_url()."user/logout"; ?>>Logout</a><br>


</div>

<h1>Members Page</h1>

<!--WELCOME-->
<?php
echo "<pre>";
echo 'Welcome ';
print_r($this->session->userdata('email'));
echo "</pre>";

?>
<!---->


<!--PROFILE PICTURE-->
<div style="width: 150px;height: 100px;border: 2px dotted black;text-align: center; ">

    <?php if(is_dir('upload/'.$user_folder)) :?>
        <img src= "../upload/<?=$user_folder?>/<?= $pic_name;?>" alt="Profile Pic" height="100" width="150">
        <?php else: ?>
        <img src= "../upload/temp.jpg" alt="Profile Pic" height="100" width="150">
    <?php endif;?>


    <a href=<?php echo base_url()."upload/index"; ?>>change photo</a>
</div>

<!---->



<!--MY ALBUMS-->

<div style="text-align: center">
    <p>
        <a href="<?php echo base_url()."chat/show_chat_users"; ?>">Chat</a><br>
        <a href="<?php echo base_url()."album/show"; ?>">My Albums</a><br>
        <a href="<?php echo base_url()."user/show"; ?>">Other Users Albums</a><br>

    </p>
</div>

<!---->

