<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image_model extends CI_Model
{
    public function delete($photo_name)
    {
        $this->db->where('name',$photo_name);
        $this->db->delete('images');

        @unlink('upload/albums/'.$photo_name);

        return true;
    }


    public function delete_cheked_photos($all_checked_photos)
    {
        foreach($all_checked_photos as $checked)
        {
            @unlink('upload/albums/'.$checked);
        }

        if (!empty($all_checked_photos))
        {
            $this->db->where_in('name', $all_checked_photos);
            $this->db->delete('images');
            return true;
        }

    }
}