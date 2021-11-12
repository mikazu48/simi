<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('M_login');
	}

	public function index()
	{
		$this->load->view('login/V_register');
	}

}