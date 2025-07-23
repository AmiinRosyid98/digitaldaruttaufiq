<?php

class Auth_admin extends CI_Model
{
    private $_table = "admin";
    const SESSION_KEY = 'admin_id';

    public function rules()
    {
        return [
            [
                'field' => 'username',
                'label' => 'Username or Email',
                'rules' => 'required'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|max_length[255]'
            ]
        ];
    }

    public function login($username, $password, $role)
    {
        $this->db->where('email', $username)->or_where('username', $username)->where('role', $role);
        $query = $this->db->get($this->_table);
        $user = $query->row();
        if (!$user) {
            return FALSE; // User dengan peran yang dimasukkan tidak ditemukan
        }

        if (!password_verify($password, $user->password)) {
            return FALSE; // Password tidak cocok
        }

        // Simpan data sesi atau token
        $token = bin2hex(random_bytes(16)); 
        $this->session->set_userdata('admin_token', $token);
        $this->session->set_userdata('admin_id', $user->id);
        $this->session->set_userdata('admin_role', $user->role);
        $this->_update_last_login($user->id);
    
        return TRUE;
    }

    public function current_user()
    {
        if (!$this->session->has_userdata(self::SESSION_KEY)) {
            return null;
        }

        $user_id = $this->session->userdata(self::SESSION_KEY);
        $query   = $this->db->get_where($this->_table, ['id' => $user_id]);
        return $query->row();
    }

    private function _update_last_login($id)
    {
        $data = [
            'last_login' => date("Y-m-d H:i:s"),
        ];
        return $this->db->update($this->_table, $data, ['id' => $id]);
    }

    public function logout()
    {
        $this->session->unset_userdata(self::SESSION_KEY);
        $this->session->unset_userdata('admin_role');
        delete_cookie('admin_token');
        return !$this->session->has_userdata(self::SESSION_KEY);
    }
}
