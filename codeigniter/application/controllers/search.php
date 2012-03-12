<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	public function people($key=null)
	{
		$this->load->view('header');
		
		echo $key;

		$this->load->view('footer');
	}

}