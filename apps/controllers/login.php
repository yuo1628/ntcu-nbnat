<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoginController extends MY_Controller {

	/**
	 * Index Page for Login controller.
	 */
	public function index()
	{
		$this->layout->setLayout('layout/login');
		$this->layout->view('view/login/default');
	}
}
