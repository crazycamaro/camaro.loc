<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Album_image_model extends CI_Model
{
     public function insert_album_photo_name($image_name,$album_id)
     {

         $this->db->insert('images',array('name' =>$image_name,'album_id'=>$album_id));
            return true;
     }

    public function all_photos_from_album($album_id)
    {

        $this->db->select('*');
        $this->db->where('album_id',$album_id);
        $all_images = $this->db->get('images');
        $result = $all_images->result();

        return $result;
    }
}




//$this->db->select('users.id, albums.*');
//$this->db->from('albums');
//$this->db->join('users','users.id = albums.user_id');
//$this->db->where('email',$this->session->userdata('email'));