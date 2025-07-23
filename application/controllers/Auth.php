<?php

class Auth extends CI_Controller
{
    public function index()
    {
        show_404();
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
        $data['profil'] = $this->Model_landing->get_site();
        $this->load->view('login_admin', $data);
    }




    public function loginbendahara()
    {
        $this->load->model('Model_landing');
        $this->load->model('Auth_admin');
        $this->load->library('form_validation');
        $data['profil'] = $this->Model_landing->get_site();

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('role', 'Role', 'required'); // Tambahkan aturan validasi untuk peran

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message_login_error', '<span style="color: #000000;"><strong>Username, password, dan role harus diisi</strong></span>');
                redirect('auth/loginadmin');
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
                    switch ($role) {
                        case 'admin':
                            redirect('admin/dashboard');
                            break;
                        case 'bendahara':
                            redirect('bendahara/dashboard');
                            break;
                        case 'bk':
                            redirect('bk/dashboard');
                            break;
                        default:
                            redirect('auth/loginbendahara');
                    }
                } else {
                    $this->session->set_flashdata('message_login_error', '<span style="color: #000000;"><strong>Pastikan username, password, dan role benar</strong></span>');
                    redirect('auth/loginbendahara');
                }
            }
        }

        $this->load->view('login_bendahara', $data);
    }




    public function loginbk()
    {
        $this->load->model('Model_landing');
        $this->load->model('Auth_admin');
        $this->load->library('form_validation');
        $data['profil'] = $this->Model_landing->get_site();

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('role', 'Role', 'required'); // Tambahkan aturan validasi untuk peran

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message_login_error', '<span style="color: #000000;"><strong>Username, password, dan role harus diisi</strong></span>');
                redirect('auth/loginbk');
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
                    switch ($role) {
                        case 'admin':
                            redirect('admin/dashboard');
                            break;
                        case 'bendahara':
                            redirect('bendahara/dashboard');
                            break;
                        case 'bk':
                            redirect('bk/dashboard');
                            break;
                        default:
                            redirect('auth/loginbk');
                    }
                } else {
                    $this->session->set_flashdata('message_login_error', '<span style="color: #000000;"><strong>Pastikan username, password, dan role benar</strong></span>');
                    redirect('auth/loginbk');
                }
            }
        }

        $this->load->view('login_bk', $data);
    }


    public function loginptk()
    {
        $this->load->model('Model_landing');
        $this->load->model('Auth_ptk');
        $this->load->library('form_validation');
        $data['profil'] = $this->Model_landing->get_site();

        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message_login_error', 'Username dan password tidak boleh kosong');
                redirect('auth/loginptk');
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
                    redirect('ptk/dashboard');
                } else {
                    $this->session->set_flashdata('message_login_error', 'Pastikan username dan password benar');
                    redirect('auth/loginptk');
                }
            }
        }

        $this->load->view('login_ptk', $data);
    }



    public function loginsiswa()
    {
        $this->load->model('Model_landing');
        $this->load->model('auth_siswa');
        $this->load->library('form_validation');
        $data['profil'] = $this->Model_landing->get_site();

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

        $this->load->view('login_siswa', $data);
    }




    public function logout_admin()
    {
        $this->load->helper('cookie');
        $this->load->model('Auth_admin');
        $this->Auth_admin->logout();
        delete_cookie('admin_token');
        redirect('Auth/loginadmin');
    }

    public function logout_bendahara()
    {
        $this->load->helper('cookie');
        $this->load->model('Auth_admin');
        $this->Auth_admin->logout();
        delete_cookie('admin_token');
        redirect('Auth/loginbendahara');
    }

    public function logout_bk()
    {
        $this->load->helper('cookie');
        $this->load->model('Auth_admin');
        $this->Auth_admin->logout();
        delete_cookie('admin_token');
        redirect('Auth/loginbk');
    }


    public function logout_ptk()
    {
        $this->load->helper('cookie');
        $this->load->model('auth_ptk');
        $this->auth_ptk->logout();
        delete_cookie('ptk_token');
        redirect('Auth/loginptk');
    }

    public function logout_siswa()
    {
        $this->load->model('auth_siswa');
        $this->auth_siswa->logout();
        redirect('/');
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
