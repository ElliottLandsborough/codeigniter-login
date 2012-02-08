<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function index()
	{
		
	}

	public function register()
	{
		
	}

	public function activate()
	{
		
	}

	public function close()
	{
		
	}

	public function logout()
	{
		$this->session->set_userdata('logged_in', FALSE);
		$this->session->sess_destroy();

	}

	public function showlogin($data=null)
	{
		$this->load->view('loginform', $data);
	}

	public function login($data=null)
	{
		$form['login'] = $this->input->post('username');
		$form['pass'] = $this->input->post('password');
		if (!$this->_checklogin($form))
		{
			$data['loginerror'] = TRUE;
		}
		$this->showlogin($data);
	}

	private function _checklogin($form)
	{
		$this->load->model('Usermodel');
		$hash = $this->Usermodel->gethash($form['login']);
		if (!$hash)
		{
			return false;
		}
		else
		{
			$csalt = substr($hash, 0, 16);
			$check = $this->_passcrypt($form['pass'],$csalt);
			if ($hash == $check)
			{
				$this->session->set_userdata('user_name', $form['login']);
				$this->session->set_userdata('logged_in', TRUE);
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	/*
	Password encryption function using two separately located salts:
	 - the codeigniter encryption key
	 - a salt stored in the db
	 - trixy coding so it looks like it's an md5 hash
	 - sha512

	To create the hash/salt:
	$newhash = _passcrypt('password');
	$salt = substr($string, 0, 16);
	$hash = substr($string, -16);

	To check 'password':
	$dbhash = mysql -> get hash from table where userid == x;
	$salt = substr($dbhash, 0, 16);
	$check = _passcrypt('password',$salt);
	$checkhash = substr($check, -16);
	*/
	private function _passcrypt($password,$salt=null)
	{
		$site_key = $this->config->item('encryption_key'); // get the codeigniter encryption key
	    if ($salt === null) // if the salt hasn's been set
	    { // get the first 16 chars of md5(randomshit) to use as salt for this user
			$salt = substr(md5(uniqid(rand(), true)), 0, 16); 
	    }
	    // make a codeigniter-key-salted-sha512 hash of $password.$salt
		$securehash = hash_hmac('sha512', $password . $salt, $site_key);
		// return 16-char-salt.16-char-hash to store in db
		// so it just looks like a standard md5 hash
		return $salt . substr(md5(sha1($securehash)), 0, 16);
	}
}