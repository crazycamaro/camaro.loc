<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller
{


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    function index()

    {
        $data = array(
            'main_content' => 'upload_form',
        );
        $this->load->view('template', $data);
    }

    function do_upload()
    {
        if (!is_dir('upload/'.$this->session->userdata('email'))) {
            mkdir('upload/' . $this->session->userdata('email'));
        }

        $config['upload_path'] = 'upload/'.$this->session->userdata('email');
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '500';
        $config['max_width'] = '1224';
        $config['max_height'] = '768';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());


            $data = array(
                'main_content' => 'upload_form',
                'error' => $error
            );
            $this->load->view('template', $data);


        } else {
            $this->load->model('user_model');

            if ($this->user_model->insert_photo_name($this->upload->data('file_name'))) {

                redirect('user/members');
            } else {
                echo 'error';
            }


        }
    }

    public function index_for_album($album_id)
    {

        $data = array(
            'main_content' => 'albums/album_upload_form',
            'album_id'=>$album_id
        );
        $this->load->view('template', $data);

        //return $album_id;
    }


    public function do_upload_for_albums($album_id)
    {

        $upPath = "upload/albums/".$this->session->userdata('email')."/".$album_id;   // full path
        $tags = explode('/' ,$upPath);            // explode the full path
        $mkDir = "";

        foreach($tags as $folder) {
            $mkDir = $mkDir . $folder ."/";   // make one directory join one other for the nest directory to make
                   // this will show the directory created each time
            if(!is_dir($mkDir)) {             // check if directory exist or not
                mkdir($mkDir);            // if not exist then make the directory
            }
        }





        $config['upload_path'] = 'upload/albums/'.$this->session->userdata('email')."/".$album_id ;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '500';
        $config['max_width'] = '1224';
        $config['max_height'] = '768';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);


        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());

            $data = array(
                'main_content'=>'albums/album_upload_form',
                'error'=>$error
            );
            $this->load->view('template',$data );


        }
        else {
            $this->load->model('album_image_model');

            if ($this->album_image_model->insert_album_photo_name($this->upload->data('file_name'),$album_id))
            {
                $data = array(
                    '$user_folder' => $this->session->userdata('email')
                );
                redirect(base_url()."album/inside_album/".$album_id);
            } else {
                echo 'error';

            }


        }

    }







}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

