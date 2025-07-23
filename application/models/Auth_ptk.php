<?php

class Auth_ptk extends CI_Model
{
	private $_table = "ptk";
	const SESSION_KEY = 'ptk_id';

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

	public function login($username, $password)
	{
		$this->db->where('email', $username)->or_where('username', $username);
		$query = $this->db->get($this->_table);
		$user = $query->row();
		if (!$user) {
			return FALSE;
		}

		if (!password_verify($password, $user->password)) {
			return FALSE;
		}
	
		$token = bin2hex(random_bytes(16)); 
		
		$this->session->set_userdata('ptk_token', $token);
		$this->session->set_userdata('ptk_id', $user->id_guru);
		$this->_update_last_login($user->id_guru);
	
		return TRUE;
	}


	public function current_user()
	{
		if (!$this->session->has_userdata(self::SESSION_KEY)) {
			return null;
		}

		$user_id = $this->session->userdata(self::SESSION_KEY);
		$query   = $this->db->get_where($this->_table, ['id_guru' => $user_id]);
		return $query->row();
	}


	public function logout()
	{
		$this->session->unset_userdata(self::SESSION_KEY);
		delete_cookie('ptk_token');
		return !$this->session->has_userdata(self::SESSION_KEY);
	}
	

	private function _update_last_login($id_guru)
	{
		$data = [
			'last_login' => date("Y-m-d H:i:s"),
		];

		return $this->db->update($this->_table, $data, ['id_guru' => $id_guru]);
	}




}