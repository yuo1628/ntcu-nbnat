<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Layout Class
 * 
 * @author     Miles
 * @copyright  Copyright (c) 20011 - 2013, DreamOn, Inc.
 */
class DLayout
{
	protected $ci;
	protected $layout;

	/**
	 * Array of linked scripts
	 *
	 * @var    array
	 * @since  1.0
	 */
	protected $_scripts = array();

	/**
	 * Array of scripts placed in the header
	 *
	 * @var    array
	 * @since  1.0
	 */
	protected $_script = array();

	/**
	 * Array of linked style sheets
	 *
	 * @var    array
	 * @since  1.0
	 */
	protected $_styleSheets = array();

	/**
	 * Array of included style declarations
	 *
	 * @var    array
	 * @since  1.0
	 */
	protected $_style = array();

	/**
	 * Constructor.
	 * 
	 * @param String Default layout file.
	 * 
	 * @since  1.0
	 */
	public function __construct($layout = "layout/default")
	{
		$this->ci =& get_instance();
		$this->layout = $layout;
	}
	
	/**
	 * Set layout file.
	 * 
	 * @param  string  The layout file in 'views' folder.
	 *
	 * @since  1.0
	 */
	public function setLayout($layout)
	{
		$this->layout = $layout;
	}

	/**
	 * Set layout file.
	 * 
	 * @return  string  The HTML String of head.
	 *
	 * @since   1.0
	 */
	public function fetchHead()
	{
		// Get line endings
		$lnEnd = "\12";
		$tab = "\11";
		$tagEnd = ' />';
		$buffer = '' . $lnEnd;

		// Generate stylesheet links
		foreach ($this->_styleSheets as $strSrc => $strAttr)
		{
			$buffer .= $tab . '<link rel="stylesheet" href="' . $strSrc . '" type="' . $strAttr['mime'] . '"';
			if (!is_null($strAttr['media']))
			{
				$buffer .= ' media="' . $strAttr['media'] . '" ';
			}
			$buffer .= $tagEnd . $lnEnd;
		}

		// Generate stylesheet declarations
		foreach ($this->_style as $type => $content)
		{
			$buffer .= $tab . '<style type="' . $type . '">' . $lnEnd;

			// This is for full XHTML support.
			if ($this->_mime != 'text/html')
			{
				$buffer .= $tab . $tab . '<![CDATA[' . $lnEnd;
			}

			$buffer .= $content . $lnEnd;

			// See above note
			if ($this->_mime != 'text/html')
			{
				$buffer .= $tab . $tab . ']]>' . $lnEnd;
			}
			$buffer .= $tab . '</style>' . $lnEnd;
		}

		// Generate script file links
		foreach ($this->_scripts as $strSrc => $strAttr)
		{
			$buffer .= $tab . '<script src="' . $strSrc . '"';
			if (!is_null($strAttr['mime']))
			{
				$buffer .= ' type="' . $strAttr['mime'] . '"';
			}
			if ($strAttr['defer'])
			{
				$buffer .= ' defer="defer"';
			}
			if ($strAttr['async'])
			{
				$buffer .= ' async="async"';
			}
			$buffer .= '></script>' . $lnEnd;
		}

		// Generate script declarations
		foreach ($this->_script as $type => $content)
		{
			$buffer .= $tab . '<script type="' . $type . '">' . $lnEnd;

			// This is for full XHTML support.
			if ($this->_mime != 'text/html')
			{
				$buffer .= $tab . $tab . '<![CDATA[' . $lnEnd;
			}

			$buffer .= $content . $lnEnd;

			// See above note
			if ($this->_mime != 'text/html')
			{
				$buffer .= $tab . $tab . ']]>' . $lnEnd;
			}
			$buffer .= $tab . '</script>' . $lnEnd;
		}

		return $buffer;
	}

	/**
	 * View the views file.
	 * 
	 * @param   string  The view file in 'views' folder.
	 * @param   array   The data assign to view.
	 * @param   boolean Return
	 * 
	 * @return  mixed   Return string when $return is true.
	 * 
	 * @since   1.0
	 */
	public function view($view, $data = null, $return = false)
	{
		$data['content'] = $this->ci->load->view($view, $data, true);
		$data['layout'] = $this;
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

	/**
	 * Adds a linked script to the page
	 *
	 * @param   string   $url    URL to the linked script
	 * @param   string   $type   Type of script. Defaults to 'text/javascript'
	 * @param   boolean  $defer  Adds the defer attribute.
	 * @param   boolean  $async  Adds the async attribute.
	 *
	 * @return  DLayout
	 *
	 * @since   1.0
	 */
	public function addScript($url, $type = "text/javascript", $defer = false, $async = false)
	{
		$this->_scripts[$url]['mime'] = $type;
		$this->_scripts[$url]['defer'] = $defer;
		$this->_scripts[$url]['async'] = $async;

		return $this;
	}

	/**
	 * Adds a script to the page
	 *
	 * @param   string  $content  Script
	 * @param   string  $type     Scripting mime (defaults to 'text/javascript')
	 *
	 * @return  DLayout
	 *
	 * @since   1.0
	 */
	public function addScriptDeclaration($content, $type = 'text/javascript')
	{
		if (!isset($this->_script[strtolower($type)]))
		{
			$this->_script[strtolower($type)] = $content;
		}
		else
		{
			$this->_script[strtolower($type)] .= chr(13) . $content;
		}

		return $this;
	}

	/**
	 * Adds a linked stylesheet to the page
	 *
	 * @param   string  $url      URL to the linked style sheet
	 * @param   string  $type     Mime encoding type
	 * @param   string  $media    Media type that this stylesheet applies to
	 *
	 * @return  DLayout
	 *
	 * @since   1.0
	 */
	public function addStyleSheet($url, $type = 'text/css', $media = null)
	{
		$this->_styleSheets[$url]['mime'] = $type;
		$this->_styleSheets[$url]['media'] = $media;

		return $this;
	}

	/**
	 * Adds a stylesheet declaration to the page
	 *
	 * @param   string  $content  Style declarations
	 * @param   string  $type     Type of stylesheet (defaults to 'text/css')
	 *
	 * @return  DLayout
	 *
	 * @since   1.0
	 */
	public function addStyleDeclaration($content, $type = 'text/css')
	{
		if (!isset($this->_style[strtolower($type)]))
		{
			$this->_style[strtolower($type)] = $content;
		}
		else
		{
			$this->_style[strtolower($type)] .= chr(13) . $content;
		}

		return $this;
	}
}
