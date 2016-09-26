<script type="text/javascript">
    var chat_id = "<?php echo $chat_id; ?>";
    var user_id = "<?php echo $user_id; ?>";
</script>




<h1>Chat to each other</h1>
<hr>
<style>
    #chat_viewport ul{
        list-style-type: none;
    }
</style>

<div id="chat_viewport" style="border: 2px solid #000000;height: 300px;width: 400px;"  >

</div>

<!--<form action="#" method="post">-->
<div id="chat_input">
    <input type="text" id="chat_message" name="chat_message" value="" tabindex="1"/>
<?php echo anchor('#','Send',array('id'=>'submit_message'));?>
<!--    <button type="submit" id="submit_message" name="submit_message">Send</button>-->

</div>
<!--</form>-->