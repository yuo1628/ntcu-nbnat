<?php

define('CI_DREAMON', true);

/**
 * Static class to handle loading of libraries.
 *
 * @package  CodeIgniter.DreamOn
 * @author   Miles
 *
 * @since    1.0
 */
abstract class DLoader
{
	/**
	 * Container for already imported library paths.
	 *
	 * @var    array
	 * @since  1.0
	 */
	protected static $classes = array();

	/**
	 * Cache for already imported library paths.
	 *
	 * @var    array
	 * @since  1.0
	 */
	protected static $imported = array();

	/**
	 * Method to get the list of registered classes.
	 *
	 * @return  array  The array of class.
	 *
	 * @since   1.0
	 */
	public static function getClassList()
	{
		return self::$classes;
	}

	/**
	 * Loads a class from specified directories.
	 *
	 * @param   string   The class name to look for (dot notation).
	 * @param   string   Search base path.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   1.0
	 */
	public static function import($key, $base = null)
	{
		// Only import the library if not already attempted.
		if (!isset(self::$imported[$key]))
		{
			// Initial variables.
			$success = false;
			$parts = explode('.', $key);
			$class = array_pop($parts);
			$base = !empty($base) ? $base : dirname(__FILE__);
			$path = str_replace('.', DIRECTORY_SEPARATOR, $key);

			$class = ucfirst($class);

			if (strpos($path, 'dreamon') === 0)
			{
				$class = 'D' . $class;
			}

			if (is_file($base . DIRECTORY_SEPARATOR . $path . '.php'))
			{
				self::$classes[strtolower($class)] = $base . DIRECTORY_SEPARATOR . $path . '.php';
				$success = (bool) include_once $base . DIRECTORY_SEPARATOR . $path . '.php';
			}

			self::$imported[$key] = $success;
		}

		return self::$imported[$key];
	}
}

/**
 * File importer.
 *
 * @param   string  $path  A dot syntax path.
 *
 * @return  boolean  True on success.
 *
 * @since   1.0
 */
function dimport($path)
{
	return DLoader::import($path);
}
