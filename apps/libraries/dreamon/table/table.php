<?php if (!defined('CI_DREAMON')) exit('No direct script access allowed');

// Import require libraries.
dimport('dreamon.object.object');

/**
 * MY_Table Class.
 *
 * @author     Miles
 * @copyright  Copyright (c) 20011 - 2013, DreamOn, Inc.
 * @since   1.0
 */
class DTable extends DObject
{
	/**
	 * Table name.
	 *
	 * @var    string
	 * @since  1.0
	 */
	protected $_table;

	/**
	 * Primary key of table.
	 *
	 * @var    string
	 * @since  1.0
	 */
	protected $_table_key;

	/**
	 * Database object
	 *
	 * @var    CI_DB_driver
	 * @since  1.0
	 */
	protected $_db;

	/**
	 * Indicator that the tables have been locked.
	 *
	 * @var    boolean
	 * @since  1.0
	 */
	protected $_locked = false;

	/**
	 * Constructor.
	 *
	 * @param  String        Table name.
	 * @param  String        Primary key of table.
	 * @param  CI_DB_driver  Database object.
	 *
	 * @since  1.0
	 */
	public function __construct($table, $key, $db)
	{
		// Initial internal variables.
		$this->_table = $table;
		$this->_table_key = $key;
		$this->_db = $db;
	}

	/**
	 * Get th columns from databse table.
	 *
	 * @return  mixed  Array of the field name, or false if an error occurs.
	 *
	 * @since   1.0
	 */
	public function getFields()
	{
		static $cache = null;

        if ($cache === null)
        {
            $fields = $this->_db->list_fields($this->_table);
            $cache = $fields;
        }

        return $cache;
	}

	/**
	 * Get an instance of a DTable class.
	 *
	 * @param   string  $type     The type of the DTable.
	 * @param   string  $prefix   An optional prefix for the table class name.
	 * @param   array   $config   An optional array of configuration values.
	 *
	 * @return  mixed   A DTable  obejct if found or false if could not be found.
	 *
	 * @since   1.0
	 */
	public static function getInstance($type, $config = array ())
	{
		$type = preg_replace('/[^A-Z0-9_\.-]/i', '', $type);
		$tableClass = ucfirst($type) . 'Table';

        if (!class_exists($tableClass))
        {
			// Use the fixed path in CodeIgniter.
			$path = APPPATH . 'tables' . DIRECTORY_SEPARATOR . strtolower($type) . EXT;

            if (is_file($path))
            {
                include_once $path;
            }
			else
			{
				return false;
			}
        }

        // Instantiate a new table class and return it.
        return new $tableClass();
	}

	/**
	 * Get DB Object instance.
	 *
	 * @return  CI_DB_driver
	 *
	 * @since   1.0
	 */
	public function getDbo()
	{
		return $this->_db;
	}

	/**
	 * Reset data.
	 *
	 * @since   1.0
	 */
	public function reset()
	{
		$fields = $this->getFields();
		if ($fields)
		{
			foreach ($fields as $name)
			{
				$this->set($name, null);
			}
		}
	}

	/**
	 * Load one data into property by key(s).
	 *
	 * @param   $key     mixed  Key(s)
	 *
	 * @return  Boolean
	 *
	 * @since   1.0
	 */
	public function load($key)
	{
		// Create shortcut.
		$db = $this->getDbo();

		$query = $db->where($this->_table_key, $key);
		$query = $query->get($this->_table);
		$result = $query->result();

		// Return false when no data
		if (empty($result))
		{
			return false;
		}

		// Do after load process.
		$result = $this->_onAfterLoad($result[0]);

		$this->bind($result);

		// Free result.
		$query->free_result();

		return true;
	}

	/**
	 * Do process after load.
	 *
	 * @param   $result  array
	 *
	 * @return  array  Result after processed.
	 *
	 * @since   1.0
	 */
	protected function _onAfterLoad($result)
	{
		return $result;
	}

	/**
	 * Do process before save.
	 *
	 * @param   $data  array
	 *
	 * @return  array  Result after processed.
	 *
	 * @since   1.0
	 */
	protected function _onBeforeSave($result)
	{
		return $result;
	}

	/**
	 * Save data.
	 *
	 * @return  Boolean
	 *
	 * @since   1.0
	 */
	public function save()
	{
		// Check readonly flag.
		if ($this->_locked)
		{
			return false;
		}

		// Do model custom check.
		if (!$this->check())
		{
			return false;
		}

		// Create shortcut.
		$db   = $this->_db;
		$data = $this->_onBeforeSave($this->get());

		if (isset($data[$this->_table_key]))
		{
			$pk = $data[$this->_table_key];

			// Process data
			unset ($data[$this->_table_key]);

			$db->where($this->_table_key, $pk);
			$db->update($this->_table, $data);
		}
		else
		{
			$db->insert($this->_table, $data);
		}

		return true;
	}

	/**
	 * Check data.
	 *
	 * @return  Boolean  Default value is true.
	 *
	 * @since   1.0
	 */
	public function check()
	{
		return true;
	}

	/**
	 * Bind data.
	 *
	 * @param   Mixed    Data.
	 *
	 * @return  Boolean
	 *
	 * @since   1.0
	 */
	public function bind($data)
	{
		if ($data instanceof stdClass)
		{
			$data = get_object_vars($data);
		}

		if (is_array($data))
		{
			foreach ($data as $key => $value)
			{
				$this->set($key, $value);
			}
		}
		return true;
	}

	/**
	 * Delete bind data form database.
	 *
	 * @return  Boolean
	 *
	 * @since   1.0
	 */
	public function delete($key = null)
	{
		// Check readonly flag.
		if ($this->_locked)
		{
			return false;
		}

		// Create shortcut.
		$db = $this->getDbo();

		$pk = ($key === null)? $this->get($this->_table_key) : $key;

		var_dump($this->get('id'));

		$db->where($this->_table_key, $pk);
		$db->delete($this->_table);

		// Clear data.
		$this->reset();

		return true;
	}
}
