<?php

/**
 * Function for autoloading
 */
function __autoload($class)
{
	$ds = DIRECTORY_SEPARATOR;
	if (file_exists( APPPATH . 'core' . $ds . strtolower($class) . EXT))
	{
		include_once APPPATH . 'core' . $ds . strtolower($class) . EXT;
	}
	elseif (file_exists( APPPATH . 'models' . $ds . strtolower($class) . EXT))
	{
		include_once APPPATH . 'models' . $ds . strtolower($class) . EXT;
	}
}
