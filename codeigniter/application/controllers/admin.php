<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function index()
	{
		
	}

	public function users()
	{
    	
    	$this->load->library('permlib');
		$this->permlib->setmask();
		/*ACCESS,EDIT_SELF,DISABLE_SELF,VIEW_VOUCHERS,OWN_VOUCHERS,GLOBAL_VOUCHERS,GLOBAL_VIEW,GLOBAL_EDIT,GLOBAL_DISABLE,SUPERADMIN*/
    	if ($this->permlib->InvokePermission(Permlib::SUPERADMIN) != 0 || $this->permlib->InvokePermission(Permlib::GLOBAL_VIEW) != 0)
    	{
    		$this->load->model('listusers');
    		// todo: perms being passed correctly to db model so that only correct users are shown
    		$perms = 15;
    		$input['theusers'] = $this->listusers->get_users($perms);
    		$this->load->view('adminlistusers',$input);
    	}
	}
}