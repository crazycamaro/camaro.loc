<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Album extends CI_Controller
{
 /////////miangamic sax controlleri vra stuguma..... user controllerum fraca hatik hatiki dzevy////////////////////
    function __construct()
    {
        parent::__construct();
        if ( ! $this->session->userdata('logged_in'))
        {
            redirect('user/login');
        }
    }
/////////////////////////////////////////////////////////////////////


    public function index()

    {
        if ($this->session->userdata('logged_in')) {
        $data['main_content']= 'album_create_form';
        $this->load->view('template',$data);

    }
else {
redirect('user/restricted');
}
    }

    public function create()
    {

       $this->load->model('album_model');
      if($this->album_model->save($this->input->post('album_name')))
      {
             redirect(base_url().'album/show');
      }
    }



    public function show()
    {
       // if ($this->session->userdata('logged_in')) {
            $this->load->model('user_model');
            $this->load->model('album_model');
            $all_albums = $this->album_model->show_all_albums();
            // {

            $data = array(
                'all_albums' => $all_albums,
                'main_content' => 'my_albums'
            );

            $this->load->view('template', $data);
            // }
      //  }
      //  else{
        //    redirect('user/restricted');
       // }
    }


    public function inside_album($album_id)
    {
        $this->load->model('album_image_model');
        $all_photo_name = $this->album_image_model->all_photos_from_album($album_id);
/////////email from album
        $this->load->model('album_model');
        $email = $this->album_model->album_user($album_id);
//////////// end email from album
        $data = array(
            'main_content'=>'albums/album_view',
            'album_id' =>$album_id,
            'all_photo_name'=>$all_photo_name,
            'current_user_email' => $this->session->userdata('email'),
            'email'=>$email
        );
        $this->load->view('template', $data);
    }


    public function delete_album($album_id)
    {

        $this->load->model('album_model');
        if($this->album_model->delete($album_id))
        {
            redirect(base_url().'album/show');
        }
        else{
            echo 'could not delete album';
        }
    }

    public function one_user_albums($id)
    {
        $this->load->model('album_model');
       $albums =  $this->album_model->get_one_user_albums($id);

        $data = array(
            'main_content'=>'albums/one_user_albums',
            'albums'=>$albums
        );
        $this->load->view('template',$data);
 }


public function qaq()
{
    echo $this->session->userdata('user_id');
    echo base_url();
}

}