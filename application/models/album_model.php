<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Album_model extends CI_Model
{
    public function save($album_name)
    {
        ///////stananq user_id  sessioayi mijocov
        $this->db->where('email',$this->session->userdata('email'));
        $user_id =  $this->db->get('users')->row()->id;
        //////////////


        /////////////////// db->insert_id() talisa verjin add aracy db um konkret qayli hamar. po lyubomu mer albomnery anyndhat pti poxen id-nery
        $data =array(
            'name'=>$album_name,
            'user_id'=> $user_id
        );
       $this->db->insert('albums',$data);

       return true;
    }



    public function show_all_albums()
    {
        $this->db->select('users.id, albums.*');
        $this->db->from('albums');
        $this->db->join('users','users.id = albums.user_id');
        $this->db->where('email',$this->session->userdata('email'));

          $query = $this->db->get();
          $all = $query->result();


        return $all;

    }

////////////////////////////////////////////////////////////////////////
    public function album_user($album_id)
    {
        $this->db->select('users.email');
        $this->db->join('albums','albums.user_id = users.id');
        $this->db->where('albums.id',$album_id);
        $email = $this->db->get('users')->row();
        return $email->email;

//$this->db->select('users.id, albums.*');
//$this->db->from('albums');
//$this->db->join('users','users.id = albums.user_id');
//$this->db->where('email',$this->session->userdata('email'));
    }
////////////////////////////////////////////////////////////////////
    public function delete($album_id)
    {
        $this->db->select('name');
        $this->db->where('album_id',$album_id);
       $query =  $this->db->get('images');
        $names = $query->result();
       foreach($names as $name){
           @unlink('upload/albums/'.$name->name);
       }

      $this->db->where('id',$album_id);
       $query = $this->db->delete('albums');

      if($query)
      {return true;
       }else{return false;}
   }


            public function get_one_user_albums($id)
            {
                //menq unenq user-i id-n, vorov pti uxaki stananq ira sax albumnery
                   // echo $id;

                $this->db->select('albums.*');
                $this->db->join('users','users.id = albums.user_id');
                $this->db->where('users.id', $id);
                $query = $this->db->get('albums')->result();

                return $query;
            }



}


