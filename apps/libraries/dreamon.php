<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class to load library's loader.
 */
class DreamOn
{
	public function __construct()
	{
		require_once APPPATH . 'libraries/dreamon/loader.php';
	}
}