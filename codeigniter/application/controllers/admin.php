<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index()
	{
		
	}

	public function users()
	{
    	$input['newmask'] = $this->session->userdata('user_perms');
    	$this->load->library('permlib');
		$this->permlib->SetMask($input);
    	if ($this->permlib->InvokePermission(Permlib::ADMINISTRATOR) != 0 || $this->permlib->InvokePermission(Permlib::MODERATOR) != 0)
    	{
    		// todo: perms being passed correctly to db model so that only correct users are shown
    		$perms = 14; // for now, 15 is the highest a person can be without being a profile or voucher mod.
            $this->load->model('listusers');
    		$input['theusers'] = $this->listusers->get_users($perms);
    		$this->load->view('header');
            $this->load->view('adminlistusers',$input);
            $this->load->view('footer');
    	}
	}
}