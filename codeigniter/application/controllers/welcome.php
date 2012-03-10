<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('header');
		$this->load->view('welcome');
		$this->load->view('footer');
		$this->load->library('permlib');
		$input['user_id']="36";
		$this->permlib->RefreshMyPerms();
	}
}