<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Layout Class
 * 
 * @author     Miles
 * @copyright  Copyright (c) 20011 - 2013, DreamOn, Inc.
 */
class Layout
{
	protected $ci;
	protected $layout;

	/**
	 * Constructor.
	 * 
	 * @param String Default layout file.
	 */
	public function __construct($layout = "layout/default")
	{
		$this->ci =& get_instance();
		$this->layout = $layout;
	}
	
	/**
	 * Set layout file.
	 * 
	 * @param String The layout file in 'views' folder.
	 */
	public function setLayout($layout)
	{
		$this->layout = $layout;
	}
	
	/**
	 * View the views file.
	 * 
	 * @param  String  The view file in 'views' folder.
	 * @param  Array   The data assign to view.
	 * @param  Boolean Return
	 * @return Mixed   Return string when $return is true. 
	 */
	public function view($view, $data = null, $return = false)
	{
		$data['content'] = $this->ci->load->view($view, $data, true);
		
		if ($return)
		{
			$output = $this->ci->load->view($this->layout, $data, true);
			return $output;
		}
		else
		{
			$this->ci->load->view($this->layout, $data, false);				
		}
	}
}

/* End of file layout.php */
/* Location: apps/libraries/layout.php */