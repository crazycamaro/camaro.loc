<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{

//    public function all_info()
//    {
//         $all_users['all'] =  $this->db->get('users');
//         $this->load->view('members_view',$all_users);
//    }

    public function can_log_in()
    {
        $this->db->where('email',$this->input->post('email'));
        $this->db->where('password',sha1($this->input->post('password')));

        $query = $this->db->get('users');

        if($query->num_rows() == 1)
        {
            $row = $query->row();
                if($row->status == 1){

                    return true;
                }
                else{
                      redirect('user/not_activated');
                      return false;

                }
        }
        else{
            return false;
        }
    }

    public function add_temp_user($pass_key)
    {
        $data = array(
            'email' => $this->input->post('email'),
            'password' => sha1($this->input->post('password')),
            'pass_key' => $pass_key
        );

       $query =  $this->db->insert('users',$data);
        if($query)
        {
            return true;
        }else{
            return false;
        }
    }


    public function change_temp_user($pass_key,$change_email)
    {

           $this->db->where('email',$change_email);
           $this->db->update("users",array('pass_key' => $pass_key));
           return true;



//           if($change->num_rows() == 1 ){
//
//            $this->db->update("users",array('pass_key' => $pass_key));
//            return true;
//         }

    }


    public function is_key_valid($pass_key)
    {

        $this->db->where('pass_key',$pass_key);
        $query = $this->db->get('users');

        if($query->num_rows()==1){

            return true;
        }else{
            return false;
        }
    }

    public function add_user($pass_key)
    {
        /////updating status///////
        $this->db->where('pass_key',$pass_key);
        $this->db->update("users",array('status'=>1));
        /////geting email for that user//////
        $this->db->select('email');
        $this->db->where('pass_key',$pass_key);
        $query  = $this->db->get('users');
        $row = $query->result();
        foreach($row as $r)
        {
            return $r->email;
        }



    }







    public function insert_photo_name($pic_name)
    {
        $this->db->where('email',$this->session->userdata('email'));
        $this->db->update("users",array('pic_name' => $pic_name));
        return $this->session->userdata('email');
    }





   public function show_image($email)
   {
        $this->db->where('email',$email);
        $query = $this->db->get('users');
        $row = $query->row();
       $this->session->set_userdata('user_id',$row->id);
      return $row->pic_name;


   }




    public function show_other_users()
    {
        $this->db->where('email !=',$this->session->userdata('email'));
        $query = $this->db->get('users');
        $row = $query->result();
        return $row;
    }


    public function show_chat_users($current_user_id)
    {

        //// mery qunem chat_id_n steic pti stanam, urish dzev chka gandoooony!!!
        $this->db->select('*');
        $this->db->where('email !=',$this->session->userdata('email'));
        $query = $this->db->get('users');
        $row = $query->result();


$sub = array();
$main = array();


       foreach($row as $other_user_id)
       {

           $this->db->select('chat_id');
           $this->db->where('current_user_id',$current_user_id);
           $this->db->where('other_user_id',$other_user_id->id);
           $this->db->or_where('current_user_id',$other_user_id->id);
           $this->db->where('other_user_id',$current_user_id);
           $query_2 = $this->db->get('chats')->result();
          foreach($query_2 as $chat_id)
          {

              $sub['email'] =  $other_user_id->email;
              $sub['other_user_id'] = $other_user_id->id;
              $sub['chat_id'] = $chat_id->chat_id;
              $main[] = $sub;
          }

       }

        return $main;

    }

    public function current_user()
    {
        $this->db->select('id');
        $this->db->where('email',$this->session->userdata('email'));
        $query = $this->db->get('users');
        $row = $query->result();
        foreach($row as $user_id)
        {
            return $user_id->id;
        }
    }




}





















