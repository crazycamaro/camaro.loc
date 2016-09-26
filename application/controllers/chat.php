<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller
{
     function __construct()
    {
        parent::__construct();
        $this->load->model('chat_model');
    }

    public function index($chat_id)
    {
        if(!$this->session->userdata('logged_in'))
        {
            redirect('user/login');
        }

             $data = array(
                 'main_content'=> 'chat/chat_view',
                 'chat_id'=>$chat_id,
                 'user_id'=>$this->session->userdata('user_id')
             );

        $this->session->set_userdata('last_message_id_'.$data['chat_id'],0);
            $this->load->view('template',$data);
    }

    public function ajax_add_chat_message()
    {


        $chat_id = $this->input->post('chat_id');
        $user_id = $this->input->post('user_id');
        $chat_message_content = $this->input->post('chat_message_content',TRUE);

      $this->chat_model->add_chat_message($chat_id,$user_id,$chat_message_content);

        echo $this-> _get_chat_messages($chat_id);

    }

    public function ajax_get_chat_messages()
    {
        $chat_id = $this->input->post('chat_id');
       echo $this-> _get_chat_messages($chat_id);
    }


    public function _get_chat_messages($chat_id)
    {

        $last_message_id = (int)$this->session->userdata('last_message_id_'.$chat_id);

       $chat_messages =  $this->chat_model->get_chat_messages($chat_id,$last_message_id);

        if($chat_messages->num_rows() > 0)
        {
            //store last message id
            $last_message_id = $chat_messages->row($chat_messages->num_rows()-1)->chat_message_id;
            $this->session->set_userdata('last_message_id_'.$chat_id,$last_message_id);
            //we have some chat
            $chat_messages_html = '<ul>';

            foreach($chat_messages->result() as $chat_message)
            {
                $chat_messages_html .= '<li>'.$chat_message->chat_message_content.' by <span style="font-size:90%; color: #585858">'.$chat_message->email.'</span></li>';
            }

            $chat_messages_html .= '</ul>';
            $result = array('status'=>'ok','content'=>$chat_messages_html);
            return json_encode($result);
            exit();
        }
        else{
            // we dont have chat yet

            $result = array('status'=>'ok','content'=>'');
           return json_encode($result);
            exit();
        }

    }


    public function show_chat_users()
    {
        $this->load->model('chat_model');
        $this->load->model('user_model');
        $current_user = $this->user_model->current_user();
        $chat_users_and_chat_id = $this->user_model->show_chat_users($current_user);

        //chat_id -  hamar fral foreach u hanel chatery


           // var_dump($one_array['chat_id']);
           $chat_id_with_unseen_messages =  $this->chat_model->show_messages_with_chat_id($chat_users_and_chat_id);


//        foreach($chat_id_with_unseen_messages as $message_count)
//        {
//            echo $message_count['chat_id'];
//            echo $message_count['count'];
//
//        }
//////////////////////////////////////////
        $data = array(
            'main_content' => 'chat/chat_users_view',
            'chat_users_and_chat_id' =>$chat_users_and_chat_id,
            'current_user'=>$current_user,
            'chat_id_with_unseen_messages'=>$chat_id_with_unseen_messages
        );
        $this->load->view('template',$data);
    }


    public function make_single_chat()
    {
        $current_user_id = $this->uri->segment(3);
        $other_user_id  = $this->uri->segment(4);


        $this->load->model('chat_model');

        $chat_id = $this->chat_model->make_single_chat($current_user_id,$other_user_id);



        $this->chat_model->change_status($other_user_id,$chat_id);

       //stugel et chat_id-n hamapatasxanuma namak groxnerin?
        $this->index($chat_id);



    }







































}