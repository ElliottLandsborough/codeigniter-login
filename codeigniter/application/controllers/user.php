<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function index()
	{
		
	}

	public function showregister($data=null)
	{

	}

	public function register()
	{
		if ($this->session->userdata('logged_in') != TRUE)
		{
			if ($this->input->post('doregister'))
			{
				$form['login'] = $this->input->post('username');
				$form['email'] = $this->input->post('email');
				$form['pass'] = $this->input->post('password');
				$form['hash'] = $this->_passcrypt($form['pass']);
				$form['datetime'] = date("Y-m-d H:i:s");
				$form['key'] = $this->_genrandomstring();
				$this->load->model('Usermodel');
				if($this->Usermodel->adduser($form))
				{
					echo 'Please verify your email <a href="activate/'.$form['key'].'">here</a>.';
				}
			}
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[26]|is_unique[users.user_name]');
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[26]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[32]|is_unique[users.user_email');
			//$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|min_length[6]|max_length[32]');
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('user_regform');
			}
			else
			{
				$this->load->view('form_success_generic');
			}
		}
	}

	public function activate($key=null)
	{
		$this->load->model('Usermodel');
		if($this->Usermodel->activateuser($key))
		{
			echo 'done!';
		}
	}

	public function close()
	{
		
	}

	public function logout()
	{
		$this->session->set_userdata('logged_in', FALSE);
		$this->session->sess_destroy();
	}

	public function login($data=null)
	{
		if ($this->session->userdata('logged_in') != TRUE)
		{
			echo $this->session->userdata('logged_in');
			$form['login'] = $this->input->post('username');
			$form['pass'] = $this->input->post('password');
			echo $this->_checklogin($form);
			if (!$this->_checklogin($form))
			{
				$data['loginerror'] = TRUE;
			}
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			//$this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[26]|is_unique[users.user_name]');
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[26]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[32]');
			//$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
			//$this->form_validation->set_rules('email', 'Email', 'required|min_length[6]|max_length[32]');
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('user_loginform', $data);
			}
			else
			{
				$this->load->view('user_loginform_success');
			}
		}
	}

	private function _checklogin($form)
	{
		$this->load->model('Usermodel');
		$hash = $this->Usermodel->gethash($form['login']);
		if (!$hash)
		{
			$this->logout();
			return false;
		}
		else
		{
			$csalt = substr($hash, 0, 16);
			$check = $this->_passcrypt($form['pass'],$csalt);
			if ($hash == $check && $form['login'] != '')
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
	 - the codeigniter encryption key salt
	 - a salt stored in the db
	 - trixy coding so it looks like it's an md5 hash
	 - sha512
	 - probably slower than other stuff but secure as fuck
	
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
			$salt = substr($this->_genrandomstring(), 0, 16); 
	    }
	    // make a codeigniter-key-salted-sha512 hash of $password.$salt
		$securehash = hash_hmac('sha512', $password . $salt, $site_key);
		// return 16-char-salt.16-char-hash to store in db
		// so it just looks like a standard md5 hash
		return $salt . substr(md5(sha1($securehash)), 0, 16);
	}

	private function _genrandomstring()
	{ // return 32 randomish characters
		// stick with md5 because of speed
		return md5(uniqid(rand(), true));
		//return hash_hmac('sha512', uniqid(rand(), true), $site_key);
	}
}