<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class People extends CI_Controller {

	public function index()
	{
		
	}

	public function browse()
	{
    	$input['newmask'] = $this->session->userdata('user_perms');
    	$this->load->library('permlib');
		$this->permlib->SetMask($input);
    	if ($this->permlib->InvokePermission(Permlib::ACCESS) != 0)
    	{
            $this->load->model('listusers');
            $input['theusers'] = $this->listusers->get_users()->result_array();
            // manipulate $input depending on perms
            print_r($input['theusers']);
            $this->load->view('header');
            $this->load->view('listusers',$input);
            $this->load->view('footer');
    	}
	}
}