
<hr>


<?php foreach($chat_id_with_unseen_messages as $chat_id) :?>
    <?php  foreach($chat_users_and_chat_id as $one_array) :?>
        <?php if($one_array['chat_id']== $chat_id['chat_id'] ) :?>

            <a href="<?= base_url();?>chat/make_single_chat/<?=$current_user;?>/<?=$one_array['other_user_id'];?>"><?=$one_array['email'];?> <?php if(!empty($chat_id['count'])){echo'chat: '.$chat_id['count'];} ?></a><br>

        <?php endif;?>
    <?php endforeach;?>
<?php endforeach;?>




<?php
//
//foreach($chat_id_with_unseen_messages as $chat_id){
//    echo $chat_id['chat_id']." ".$chat_id['count'].' <br>';
//}
//
//?>
