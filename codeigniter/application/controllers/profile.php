<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function index()
	{
		$this->me();
	}

	public function me()
	{
		$this->view($this->session->userdata('user_id'));
	}

	public function view($user)
	{
		$query = $this->db->get_where('users', array('user_id' => $user));
		if ($query->num_rows() == 0)
		{
			$query = $this->db->get_where('users', array('user_name' => $user));
		}
		if ($query->num_rows() == 1)
		{
			$this->profileview($query);
			/*
			user
				
			brand
				
			mod

			admin
			*/
		}
	}

}