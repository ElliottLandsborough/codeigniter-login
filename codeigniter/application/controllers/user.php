<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function index()
	{
		echo 'profile index';//profile index
	}

	public function register()
	{
		if ($this->session->userdata('logged_in') != TRUE)
		{
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 	'Username', 				'required|min_length[3]|max_length[26]|is_unique[users.user_name]|alpha_dash');
			$this->form_validation->set_rules('password', 	'Password', 				'required|min_length[6]|max_length[32]|matches[passconf]');
			$this->form_validation->set_rules('passconf', 	'Password Confirmation', 	'required');
			$this->form_validation->set_rules('email', 		'Email', 					'required|min_length[6]|max_length[32]|valid_email|is_unique[users.user_email]|matches[emailconf]');
			$this->form_validation->set_rules('email', 		'Email Confirmation',		'required');
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('user_regform');
			}
			else
			{
				$this->load->view('form_success_generic');
				if ($this->input->post('doregister'))
				{
					$this->load->library('userlib');
					$form['login'] = $this->input->post('username');
					$form['email'] = $this->input->post('email');
					$form['pass'] = $this->input->post('password');
					$form['hash'] = $this->userlib->passcrypt($form['pass']);
					$form['datetime'] = date("Y-m-d H:i:s");
					$form['key'] = $this->userlib->genrandomstring();
					if($this->userlib->adduser($form))
					{
						// to make into email
						$activationkey = $form['key'].mysql_insert_id();
						$message = 'Please verify your email <a href="activate/'.$activationkey.'">here</a>.';
						$this->load->library('email');
						$this->email->from('elliott@landsborough.co.uk', 'Elliott Landsborough');
						$this->email->to('elliott@landsborough.co.uk'); 
						$this->email->subject('Email Activation');
						$this->email->message($message);	
						$this->email->send();
						//echo $this->email->print_debugger();
						echo $message;
					}
				}
			}
		}
	}

	public function activate($key=null)
	{
		$this->load->library('userlib');
		if($this->userlib->activateuser($key))
		{
			echo 'done!';
		}
	}

	public function logout()
	{
		$this->load->library('userlib');
		$this->userlib->logout();
		$this->load->helper('url');
		redirect('/', 'refresh');
	}

	public function login($data=null)
	{
		$this->load->helper('url');
		if ($this->session->userdata('logged_in') != TRUE)
		{
			echo $this->session->userdata('logged_in');
			$form['login'] = $this->input->post('username');
			$form['pass'] = $this->input->post('password');
			$this->load->helper(array('form', 'url'));
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[26]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|max_length[32]');
			// UNCOMMENT TO ENABLE CAPTCHA
			//$this->form_validation->set_rules('recaptcha_response_field', 'Captcha', 'required|callback_recaptcha_validation');
			$this->form_validation->set_message('recaptcha_validation', 'Invalid ReCaptcha entry.');
			$this->load->helper('recaptcha');
			$pubkey = '6Le0wc4SAAAAAIqQv17QjVwaOGQq4JDPFo5121RY';
			$data['html_captcha'] = recaptcha_get_html($pubkey);
			if ($this->form_validation->run() == FALSE)
			{
				$this->load->view('user_loginform', $data);
			}
			else
			{
				$this->load->library('userlib');
				$this->userlib->checklogin($form);
				redirect('/', 'refresh');
				//return true;
			}
		}
		else
		{
			redirect('/', 'refresh');
			// return true;
		}

	}

	public function recaptcha_validation($string)
	{
		$this->load->helper('recaptcha');
		$privkey = '6Le0wc4SAAAAACQHyLcn0NaB3INfxuy-Nzv3qfA4';
		$return = recaptcha_check_answer($privkey,
										$_SERVER["REMOTE_ADDR"],
										$this->input->post("recaptcha_challenge_field"),
										$this->input->post("recaptcha_response_field"));
		if(!$return->is_valid) 
	    {
			return FALSE;
		}
		else 
	    {
			return TRUE;
		}
	}

}