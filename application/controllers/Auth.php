<?php

class Auth extends CI_Controller
{
    public function index()
    {
        show_404();
    }

    public function dologin()
    {
        if($this->input->is_ajax_request()) {
            $role = $this->input->post('role');
            if($role == "admin"){
                $this->loginadmin();
            } else if($role == "bendahara"){
                $this->loginbendahara();
            } else if($role == "bk"){
                $this->loginbk();
            } else if($role == "guru"){
                $this->loginptk();
            } else if($role == "siswa"){
                $this->loginsiswa();
            }
        }
    }

    public function loginadmin()
    {
        $this->load->model('Model_landing');
        $this->load->model('Auth_admin');
        $this->load->library('form_validation');

        // Jika request AJAX
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('role', 'Role', 'required');

            if ($this->form_validation->run() == FALSE) {
                $response = [
                    'success' => false,
                    'message' => 'Username, password, dan role harus diisi'
                ];
            } else {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $role = $this->input->post('role');

                if ($this->Auth_admin->login($username, $password, $role)) {
                    $token = $this->session->userdata('admin_token');

                    // Set cookie
                    $cookie = array(
                        'name'   => 'admin_token',
                        'value'  => $token,
                        'expire' => '3600',
                        'secure' => TRUE
                    );
                    $this->input->set_cookie($cookie);

                    // Check role consistency
                    if ($this->session->userdata('admin_role') != $role) {
                        $response = [
                            'success' => false,
                            'message' => 'Role tidak sesuai'
                        ];
                    } else {
                        // Determine redirect URL
                        $redirect_url = '';
                        switch ($role) {
                            case 'admin':
                                $redirect_url = 'admin/dashboard';
                                break;
                            case 'bendahara':
                                $redirect_url = 'bendahara/dashboard';
                                break;
                            case 'perpustakaan':
                                $redirect_url = 'perpustakaan/dashboard';
                                break;
                            default:
                                $redirect_url = 'auth/loginadmin';
                        }

                        $response = [
                            'success' => true,
                            'message' => 'Login berhasil',
                            'redirect' => base_url($redirect_url)
                        ];
                    }
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'Pastikan username, password, dan role benar'
                    ];
                }
            }

            // Send JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

        // Jika bukan AJAX (tampilkan view biasa)
        // $data['profil'] = $this->Model_landing->get_site();
        // $this->load->view('login_admin', $data);
        redirect('login');
    }




    public function loginbendahara()
    {
        $this->load->model('Model_landing');
        $this->load->model('Auth_admin');
        $this->load->library('form_validation');
        $data['profil'] = $this->Model_landing->get_site();
        if($this->input->is_ajax_request()) {
            
        
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');
                $this->form_validation->set_rules('role', 'Role', 'required'); // Tambahkan aturan validasi untuk peran

                if ($this->form_validation->run() == FALSE) {
                    $response = [
                        'success' => false,
                        'message' => 'Username, password, dan role harus diisi'
                    ];
                } else {
                    $username = $this->input->post('username');
                    $password = $this->input->post('password');
                    $role = $this->input->post('role'); // Ambil peran dari inputan

                    if ($this->Auth_admin->login($username, $password, $role)) {
                        $token = $this->session->userdata('admin_token');
                        $cookie = array(
                            'name'   => 'admin_token',
                            'value'  => $token,
                            'expire' => '3600',
                            'secure' => TRUE
                        );
                        $this->input->set_cookie($cookie);

                        // Redirect ke dashboard yang sesuai dengan peran pengguna
                        $redirect_url = '';
                        switch ($role) {
                            case 'admin':
                                $redirect_url = 'admin/dashboard';
                                break;
                            case 'bendahara':
                                $redirect_url = 'bendahara/dashboard';
                                break;
                            case 'bk':
                                $redirect_url = 'bk/dashboard';
                                break;
                            default:
                                $redirect_url = 'auth/loginbendahara';
                        }
                        $response = [
                            'success' => true,
                            'message' => 'Login berhasil',
                            'redirect' => base_url($redirect_url)
                        ];
                    } else {
                        $this->session->set_flashdata('message_login_error', '<span style="color: #000000;"><strong>Pastikan username, password, dan role benar</strong></span>');
                        // redirect('auth/loginbendahara');
                        $response = [
                            'success' => false,
                            'message' => 'Pastikan username dan password benar'
                        ];
                    }
                }
            }
            // Send JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

        redirect('login');


        // $this->load->view('login_bendahara', $data);
    }




    public function loginbk()
    {
        $this->load->model('Model_landing');
        $this->load->model('Auth_admin');
        $this->load->library('form_validation');
        $data['profil'] = $this->Model_landing->get_site();

        if($this->input->is_ajax_request()) {
            
        
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');
                $this->form_validation->set_rules('role', 'Role', 'required'); // Tambahkan aturan validasi untuk peran

                if ($this->form_validation->run() == FALSE) {
                    $response = [
                        'success' => false,
                        'message' => 'Username, password, dan role harus diisi'
                    ];
                } else {
                    $username   = $this->input->post('username');
                    $password   = $this->input->post('password');
                    $role       = $this->input->post('role'); // Ambil peran dari inputan

                    if ($this->Auth_admin->login($username, $password, $role)) {
                        $token = $this->session->userdata('admin_token');
                        $cookie = array(
                            'name'   => 'admin_token',
                            'value'  => $token,
                            'expire' => '3600',
                            'secure' => TRUE
                        );
                        $this->input->set_cookie($cookie);

                        // Redirect ke dashboard yang sesuai dengan peran pengguna
                        $redirect_url = '';
                        switch ($role) {
                            case 'admin':
                                $redirect_url = 'admin/dashboard';
                                break;
                            case 'bendahara':
                                $redirect_url = 'bendahara/dashboard';
                                break;
                            case 'bk':
                                $redirect_url = 'bk/dashboard';
                                break;
                            default:
                                $redirect_url = 'auth/loginbk';
                        }
                        $response = [
                            'success' => true,
                            'message' => 'Login berhasil',
                            'redirect' => base_url($redirect_url)
                        ];
                    } else {
                        $this->session->set_flashdata('message_login_error', '<span style="color: #000000;"><strong>Pastikan username, password, dan role benar</strong></span>');
                        $response = [
                            'success' => false,
                            'message' => 'Pastikan username dan password benar'
                        ];
                    }
                }
            }

            // $this->load->view('login_bk', $data);
            // Send JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

        redirect('login');

    }


    public function loginptk()
    {
        $this->load->model('Model_landing');
        $this->load->model('Auth_ptk');
        $this->load->library('form_validation');
        $data['profil'] = $this->Model_landing->get_site();
        // var_dump($this->input->server('REQUEST_METHOD'));die;
        if($this->input->is_ajax_request()) {
            
        
            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');

                if ($this->form_validation->run() == FALSE) {
                    $response = [
                        'success' => false,
                        'message' => 'Username dan password tidak boleh kosong'
                    ];
                } else {
                    $username = $this->input->post('username');
                    $password = $this->input->post('password');

                    if ($this->Auth_ptk->login($username, $password)) {
                        $token = $this->session->userdata('ptk_token');
                        $cookie = array(
                            'name'   => 'ptk_token',
                            'value'  => $token,
                            'expire' => '3600',
                            'secure' => TRUE
                        );
                        $this->input->set_cookie($cookie);
                        // redirect('ptk/dashboard');
                        $response = [
                            'success' => true,
                            'message' => 'Login berhasil',
                            'redirect' => base_url('ptk/dashboard')
                        ];
                    } else {
                        $this->session->set_flashdata('message_login_error', 'Pastikan username dan password benar');
                        $response = [
                            'success' => false,
                            'message' => 'Pastikan username dan password benar'
                        ];
                    }
                }
                
            }

            // $this->load->view('login_ptk', $data);
            // Send JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }

        redirect('login');

    }



    public function loginsiswa()
    {
        $this->load->model('Model_landing');
        $this->load->model('auth_siswa');
        $this->load->library('form_validation');
        $data['profil'] = $this->Model_landing->get_site();

        if($this->input->is_ajax_request()) {
            
        

            if ($this->input->server('REQUEST_METHOD') == 'POST') {
                $this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('password', 'Password', 'required');

                if ($this->form_validation->run() == FALSE) {
                    $error_message = 'Username dan password harus diisi';

                    if ($this->input->is_ajax_request()) {
                        $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode([
                                'success' => false,
                                'message' => $error_message
                            ]));
                        return;
                    } else {
                        $this->session->set_flashdata('message_login_error', '<span style="color: #ffffff;"><strong>' . $error_message . '</strong></span>');
                        redirect('landing');
                    }
                } else {
                    $username = $this->input->post('username');
                    $password = $this->input->post('password');

                    if ($this->auth_siswa->login($username, $password)) {
                        $token = $this->session->userdata('member_token');
                        $cookie = array(
                            'name'   => 'member_token',
                            'value'  => $token,
                            'expire' => '3600',
                            'secure' => TRUE
                        );
                        $this->input->set_cookie($cookie);

                        if ($this->input->is_ajax_request()) {
                            $this->output
                                ->set_content_type('application/json')
                                ->set_output(json_encode([
                                    'success' => true,
                                    'message' => 'Login berhasil',
                                    'redirect' => base_url('siswa/dashboard')
                                ]));
                            return;
                        } else {
                            redirect('siswa/dashboard');
                        }
                    } else {
                        $error_message = 'Username atau password salah';

                        if ($this->input->is_ajax_request()) {
                            $this->output
                                ->set_content_type('application/json')
                                ->set_output(json_encode([
                                    'success' => false,
                                    'message' => $error_message
                                ]));
                            return;
                        } else {
                            $this->session->set_flashdata('message_login_error', '<span style="color: #ffffff;"><strong>' . $error_message . '</strong></span>');
                            redirect('landing');
                        }
                    }
                }
            }
        }

        redirect('login');

        // $this->load->view('login_siswa', $data);
    }




    public function logout_admin()
    {
        $this->load->helper('cookie');
        $this->load->model('Auth_admin');
        $this->Auth_admin->logout();
        delete_cookie('admin_token');
        // redirect('Auth/loginadmin');
        redirect('login');
    }

    public function logout_bendahara()
    {
        $this->load->helper('cookie');
        $this->load->model('Auth_admin');
        $this->Auth_admin->logout();
        delete_cookie('admin_token');
        // redirect('Auth/loginbendahara');
        redirect('login');
    }

    public function logout_bk()
    {
        $this->load->helper('cookie');
        $this->load->model('Auth_admin');
        $this->Auth_admin->logout();
        delete_cookie('admin_token');
        // redirect('Auth/loginbk');
        redirect('login');
    }


    public function logout_ptk()
    {
        $this->load->helper('cookie');
        $this->load->model('auth_ptk');
        $this->auth_ptk->logout();
        delete_cookie('ptk_token');
        // redirect('Auth/loginptk');
        redirect('login');
    }

    public function logout_siswa()
    {
        $this->load->model('auth_siswa');
        $this->auth_siswa->logout();
        // redirect('/');
        redirect('login');

    }

    public function registermember()
    {
        $this->load->model('auth_member'); // Mengarahkan ke model 'auth_member'
        $this->load->library('form_validation');

        // Atur aturan validasi untuk formulir pendaftaran
        $this->form_validation->set_rules('name', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[admin.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

        // Jalankan validasi formulir
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan kembali formulir pendaftaran
            $this->load->view('register_member');
        } else {
            // Jika validasi berhasil, tambahkan pengguna ke dalam database
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $registration_data = array(
                'name' => $name,
                'email' => $email,
                'password' => $hashed_password
                // Anda juga dapat menambahkan kolom lain yang perlu disimpan
            );

            // Panggil model 'auth_member' untuk menambahkan pengguna ke dalam database
            $registration_result = $this->auth_member->registermember($registration_data);

            if ($registration_result) {
                // Jika pendaftaran berhasil, arahkan pengguna ke halaman loginmember
                redirect('auth/loginmember');
            } else {
                // Jika pendaftaran gagal, tampilkan pesan kesalahan
                echo "Gagal mendaftar. Silakan coba lagi.";
            }
        }
    }
}
