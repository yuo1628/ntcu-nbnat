<?php 

/**
 * MY_Controller Class.
 * 
 * @author     Miles
 * @copyright  Copyright (c) 20011 - 2013, DreamOn, Inc.
 */
class MY_Controller extends CI_Controller
{
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		parent::__construct();	

		$this->load->library('layout');
		$this->layout->setLayout('layout/default');
	}
}
