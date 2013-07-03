<?php if (!defined('CI_DREAMON')) exit('No direct script access allowed');

/**
 * Object Class.
 *
 * @author     Miles
 * @copyright  Copyright (c) 20011 - 2013, DreamOn, Inc.
 */
class DObject
{
	/**
	 * Variable for public access.
	 *
	 * @var    array
	 *
	 * @since  1.0
	 */
	private $_properties = array ();

	/**
	 * Constructor.
	 *
	 * @param   mixed  $properties
	 *
	 * @since   1.0
	 */
	public function __construct($properties = null)
	{
		if (is_array($properties) || is_object($properties))
		{
			foreach ((array) $properties as $k => $v)
			{
				$this->set($k, $v);
			}
        }
	}

	/**
	 * To String Magic Method.
	 *
	 * @return  string  The classname.
	 *
	 * @since   1.0
	 */
	public function __toString()
	{
		return get_class($this);
	}

	/**
	 * Get Magic Method.
	 *
	 * @param   string  $property  The name of the property.
	 *
	 * @return  mixed
	 *
	 * @since   1.0
	 */
	public function __get($property)
	{
		if ($this->__isset($property))
		{
			return $this->_properties[$property];
		}
	}

	/**
	 * Set Magic Method.
	 *
	 * @param   string  $property  The name of the property.
	 * @param   mixed   $value     The value of the property to set.
	 *
	 * @since   1.0
	 */
	public function __set($property, $value)
	{
		$this->_properties[$property] = $value;
	}

	/**
	 * Isset Magic Method.
	 *
	 * @param   string  $property  The name of the property.
	 *
	 * @return  boolean
	 *
	 * @since   1.0
	 */
	public function __isset($property)
	{
		return isset ($this->_properties[$property]);
	}

	/**
	 * Unset Magic Method.
	 *
	 * @param   string  $property  The name of the property.
	 *
	 * @since   1.0
	 */
	public function __unset($property)
	{
		if ($this->__isset($property))
		{
			unset ($this->_properties[$property]);
		}
	}

	/**
	 * Returns a property of the object.
	 *
	 * @param   string  $property  The name of the property.
	 * @param   mixed   $default   The default value.
	 *
	 * @return  mixed    The value of the property.
	 *
	 * @since  1.0
	 */
	public function get($property = null, $default = null)
	{
		if ($property === null)
		{
			return $this->_properties;
		}
		if ($this->__isset($property))
		{
			return $this->__get($property);
		}
		return $default;
	}

	/**
	 * Set a property of the object.
	 *
	 * @param   string  $property  The name of the property.
	 * @param   mixed   $value     The value of the property to set.
	 *
	 * @return  mixed   Previous value of the property.
	 *
	 * @since  1.0
	 */
	public function set($property, $value = null)
	{
		$previous = $this->__get($property);
		$this->__set($property, $value);
		return $previous;
	}
}
