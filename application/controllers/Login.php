<?php

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_landing');
    }
    public function index()
    {
        $data['data_site'] = $this->Model_landing->get_site()->result();
        $data['versi'] = $this->Model_landing->get_version()->result();
        $this->load->view('login',$data);
    }
}