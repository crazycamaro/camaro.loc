$(document).ready(function(){

 // setInterval(function(){get_chat_messages();}, 1000);

$('#chat_message').keypress(function(e){



   if(e.which==13)
   {
       $('#submit_message').click();
       return false;
   }
});


        $('#submit_message').click(function(){
            var chat_message_content = $('#chat_message').val();
            if(chat_message_content==''){return false;}

            $.ajax({
                type: 'POST',
                data: {chat_message_content: chat_message_content,chat_id: chat_id,user_id: user_id},
                url: base_url +"chat/ajax_add_chat_message",
                success: function(data){
                    var json = JSON.parse(data);
                    if(json.status == 'ok')
                    {

                        var current_content  =  $('#chat_viewport').html();

                        $('#chat_viewport').html(current_content + json.content);

                    }
                    else
                    {
                        alert(' not ok');
                    }
                }
            },"json");

            $('#chat_message').val('');

            return false;
        });


    function get_chat_messages()
    {

        $.ajax({
            type: 'POST',
            data: {chat_id: chat_id},
            url: base_url+'chat/ajax_get_chat_messages',
            success: function(data){
                var json = JSON.parse(data);
                if(json.status == 'ok')
                {
                    var current_content  =  $('#chat_viewport').html();

                    $('#chat_viewport').html(current_content + json.content);
                }
                else
                {
                    alert(' not ok');
                }
            }
        },"json");


    }

    get_chat_messages();



});