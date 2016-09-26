<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{



    function __construct()
    {
        parent::__construct();
        if ( ! $this->session->userdata('logged_in'))
        {
            // Allow some methods?
            $allowed = array(
                'login',
                'index',
                'signup',
                'restricted',
                'not_activated',
                'login_validation',
                'validate_credentials',
                'signup_validation',
                'register_user'
            );
            if ( ! in_array($this->router->fetch_method(), $allowed))
            {
                redirect('user/login');
            }
        }
    }

    public function restricted()
    {
        $data['main_content'] = 'restricted';
        $this->load->view('template',$data);
    }


    public function not_activated()
    {
        $data['main_content'] = 'not_activated_view';
        $this->load->view('template',$data);
    }


    public function login_validation()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email','Email','required|callback_validate_credentials');
        $this->form_validation->set_rules('password','Password','required|sha1');

        $this->session->set_userdata('email', $this->input->post('email'));
        if($this->form_validation->run())
        {


            $data = array(
                'email' => $this->input->post('email'),
                'logged_in' =>1
            );
            $this->session->set_userdata($data);


            redirect('user/members');
        }
        else{
            $data['main_content'] = 'login_view';
            $this->load->view('template',$data);
        }

    }

    public function validate_credentials(){
        $this->load->model('user_model');

        if($this->user_model->can_log_in()){
            return true;
        }
        else{
            $this->form_validation->set_message('validate_credentials','Incorrect username/password');
            return false;
        }

    }

    public function send_message_again()
    {
        //$this->session->sess_destroy();
        $this->send_message();
        $this->send_message();
        $this->email->to($this->session->userdata('email'));
        $pass_key = md5(sha1(uniqid()));


        $message = "<p>Thank You for signing up! </p>";
        $message .= "<p><a href='".base_url()."user/register_user/$pass_key'>Click here</a></p>";


        $this->email->message($message);


        if($this->user_model->change_temp_user($pass_key,$this->session->userdata('email')))
        {
            if($this->email->send()){

                $data['main_content'] = 'we_sent_confirm_link';
                $this->load->view('template',$data);
            }else echo 'We could not send link to your email, please try later';

        } else echo 'error occurred, please try later';




    }


    public function send_message()
    {
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'mailtrap.io',
            'smtp_port' => 2525,
            'smtp_user' => 'ea61323f8fc678',
            'smtp_pass' => '3de8ce1bcef81a',
            'mailtype'  => 'html',
            'crlf' => "\r\n",
            'newline' => "\r\n"
        );



        $this->load->model('user_model');
        $this->load->library('email',$config);
        $this->email->from('me@mysite.com','Goqor');
        //      $this->email->to($this->session->userdata('email'));
        $this->email->subject('Confirm your email');


//        $message = "<p>Thank You for signing up! </p>";

//        return $message;
    }

    public function signup_validation()
    {
        //$this->session->sess_destroy();
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email','Email:','required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password','Password:','required');
        $this->form_validation->set_rules('rpassword','Repeat Password:','required|matches[password]');

        $this->form_validation->set_message('is_unique','The email address already exist !');

        if($this->form_validation->run())
        {
            $this->send_message();

            $this->email->to($this->input->post('email'));
            $pass_key = sha1(uniqid());

            $message = "<p>Thank You for signing up! </p>";
            $message .= "<p><a href='".base_url()."user/register_user/$pass_key'>Click here</a></p>";


            $this->email->message($message);


            if($this->user_model->add_temp_user($pass_key))
            {
                if($this->email->send()){
                    $data['main_content'] = 'we_sent_confirm_link';
                    $this->load->view('template',$data);
                }else echo 'We could not send link to your email, please try later';

            } else echo 'error occurred, please try later';


        }
        else{

            $data['main_content'] = 'signup_view';
            $this->load->view('template',$data);
        }
    }

    public function register_user($pass_key)
    {
        $this->load->model('user_model');

        if($this->user_model->is_key_valid($pass_key))
        {
            if($email = $this->user_model->add_user($pass_key)){

                $data = array(
                    'email' =>$email ,
                    'logged_in' => 1
                );
                $this->session->set_userdata($data);
                redirect('user/members');

            }else echo 'failed to registration';
        }else echo 'invalid key';

    }

    public function members()
    {


       // if ($this->session->userdata('logged_in')) {

            $this->load->model('user_model');
            if ($pic_name = $this->user_model->show_image($this->session->userdata('email')))
                {

                    $data = array(
                        'main_content' =>'members_view',
                        'pic_name'=> $pic_name,
                        'user_folder' => $this->session->userdata('email')


                    );
                    $this->load->view('template', $data);
                }
           // else {
             //       redirect('user/restricted');
           // }
        //}
    }





    public function index()
    {
        $this->login();
    }

    public function login()
    {
        $data['main_content'] = 'login_view';
        $this->load->view('template',$data);
    }


    public function logout()
    {
        $this->session->sess_destroy();
        redirect('user/login');
    }

    public function signup()
    {
        $data['main_content'] = 'signup_view';
        $this->load->view('template',$data);
    }


public function show()
{
            $this->load->model('user_model');
            $users =  $this->user_model->show_other_users();

     $data = array(

         'main_content' => 'albums/all_albums',
         'users'=>$users
     );
    $this->load->view('template',$data);
}








}