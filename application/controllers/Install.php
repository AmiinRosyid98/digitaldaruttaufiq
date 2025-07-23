<?php

class Install extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_landing');
        $this->load->helper('url');
        $this->load->library('session');

        // Kunci akses yang sederhana
        $this->access_key = 'Excode123';
    }

    public function index()
    {
        if (!$this->session->userdata('has_access')) {
            redirect('install/access');
        }

        if ($this->Model_landing->is_installed()) {
            $data['message'] = 'Installation is already completed.';
            $this->load->view('install/installed_view', $data);
        } else {
            $data['message'] = $this->session->flashdata('message');
            $this->load->view('install/install_view', $data);
        }
    }

    public function execute()
    {
        if (!$this->session->userdata('has_access')) {
            redirect('install/access');
        }

        if ($this->Model_landing->is_installed()) {
            $this->session->set_flashdata('message', 'Installation is already completed.');
            redirect('install');
        }

        $file_path = 'mnt/data/u1699475.sql';
        if ($this->Model_landing->execute_sql_file($file_path)) {
            $this->session->set_flashdata('message', 'SQL file executed successfully.');
        } else {
            $this->session->set_flashdata('message', 'Failed to execute SQL file.');
        }

        redirect('install');
    }

    public function access()
    {
        if ($this->input->post()) {
            $access_key = $this->input->post('access_key');
            if ($access_key === $this->access_key) {
                $this->session->set_userdata('has_access', true);
                redirect('install');
            } else {
                $this->session->set_flashdata('message', 'Invalid access key.');
                redirect('install/access');
            }
        }

        $this->load->view('install/access_view');
    }

    public function logout()
    {
        $this->session->unset_userdata('has_access');
        redirect('install/access');
    }
}
