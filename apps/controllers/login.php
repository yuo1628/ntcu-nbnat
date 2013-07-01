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
	
	public function setSessionValue() {
		$value = $this->input->post("value");
		$key = $this->input->post("key");
		
		$this->session->set_userdata($key, $value);
		echo $this->session->userdata($key);
	}
	
	public function getSessionValue() {
		$key = $this->input->post("key");
		if($this->session->userdata($key))
		{
			echo $this->session->userdata($key);
		}
		else {
			echo '0';
		}
	}
	
}
