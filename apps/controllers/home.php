<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HomeController extends MY_Controller {

	/**
	 * Index Page for Home controller.
	 */
	public function index()
	{
		$this->layout->view('view/home/default');
	}
}
