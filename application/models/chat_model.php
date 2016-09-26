<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model
{
     function __construct()
    {
        parent::__construct();
    }

    public function add_chat_message($chat_id,$user_id,$chat_message_content)
    {
       $data = array(
           'chat_id' =>$chat_id,
           'user_id' =>$user_id,
           'chat_message_content'=>$chat_message_content
       );
        $this->db->insert('chat_messages',$data);



    }

    public function get_chat_messages($chat_id,$last_message_id = 0)
    {
        $this->db->select('users.*, chat_messages.*');
        $this->db->where('chat_messages.chat_id',$chat_id);
        $this->db->where('chat_messages.chat_message_id >',$last_message_id);
        $this->db->from('chat_messages');
        $this->db->join('users', 'users.id = chat_messages.user_id');
        $this->db->order_by('chat_messages.chat_message_id');
        $query = $this->db->get();
        return $query;

    }

    public function make_single_chat($current_user_id,$other_user_id)
    {
       $data = array(
           'current_user_id' => $current_user_id,
           'other_user_id' =>   $other_user_id
       );

        $this->db->select('chat_id');
        $this->db->where('current_user_id',$current_user_id);
        $this->db->where('other_user_id',$other_user_id);
        $this->db->or_where('other_user_id',$current_user_id);
        $this->db->where('current_user_id',$other_user_id);
        $query = $this->db->get('chats')->result();
        if($query)
        {
            //echo 'ka senc chat';
        return $chat_id =  $query[0]->chat_id;

        }
        else{
            $this->db->insert('chats',$data);
            $chat_id = $this->db->insert_id();
             return $chat_id;
        }

    }



    public function show_messages_with_chat_id($chat_users_and_chat_id)
    {
         $main_data = array();
         $sub_data = array();
         $id =$this->user_model->current_user();
         $this->load->model('user_model');

        foreach($chat_users_and_chat_id as $one_array)
        {
            $chat_id = $one_array['chat_id'];
            $this->db->select('seen');
            $this->db->where('chat_id',$chat_id);
            $this->db->where('seen',0);
            $query =  $this->db->get('chat_messages')->result();
//////////////////////////stananq chat_id - verjin namaky

            $sub_data['chat_id'] = $chat_id;

            $this->db->select('user_id');

            $this->db->order_by("chat_message_id", "desc");
            $this->db->limit(1);
            $this->db->where('chat_id',$chat_id);
            $last_user = $this->db->get('chat_messages')->result();



            foreach($last_user as $user_id_for_check)
            {
               $last_user_id =  $user_id_for_check->user_id;
            }



            if(!empty($last_user_id))
            {
                if($last_user_id  != $id)
                {
                    $sub_data['count']  =  count($query);
                }
            }







            $main_data[] = $sub_data;

        }

           return $main_data;
//
    }


    public function change_status($current_user_id,$chat_id)
    {

        // petqa nayev chat_id

        $data['seen'] = 1;
        $this->db->where('user_id ',$current_user_id);
        $this->db->where('chat_id ',$chat_id);
        $this->db->update('chat_messages',$data);
        return true;
    }
















}
