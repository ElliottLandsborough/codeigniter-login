<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Minify extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->driver('minify');
	}

	public function example()
	{
		//$file = '../codeigniter/resources/js/script.js';
		//echo $this->minify->js->min($file);
		//include($file);
	}

}