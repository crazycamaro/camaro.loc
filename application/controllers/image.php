<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends CI_Controller
{
    public function delete_photo($photo_name,$album_id)
    {
        $this->load->model('image_model');
        if($this->image_model->delete($photo_name))
        {
            redirect(base_url()."album/inside_album/".$album_id);
        }
    }


    public function delete_checked_photos($album_id)
    {
        $this->load->model('image_model');
        $all_checked_photos = $_POST['check_list'];
        $this->image_model->delete_cheked_photos($all_checked_photos);


        redirect(base_url()."album/inside_album/".$album_id);
    }


}


