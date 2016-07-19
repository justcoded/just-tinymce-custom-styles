<?php

namespace jtmce\core;

/**
 * Main Model
 */
class Model
{
	/**
	 * @var array
	 */
	protected $_errors;

	/**
	 * @var array
	 */
	protected $_messages;

	/**
	 * @var array
	 */
	protected $_msgTpls = null;

	/**
	 * @var \jtmce\core\DataLayer
	 */
	protected $_dL;

	/**
	 * Model constructor.
	 * generate DataLayer object (file system or DB settings storage)
	 */
	public function __construct()
	{
		$this->_dL = DataLayerFactory::create();
	}

	/**
	 * Special method to return pre-defined error messages in specific model.
	 * You can use keys to easily set errors by keys
	 *
	 * @return array
	 */
	public function messageTemplates()
	{
		return array();
	}

	/**
	 * Set errors
	 * @param string $error
	 */
	public function addError( $error )
	{
		if ( is_null($this->_msgTpls) ) $this->_msgTpls = $this->messageTemplates();

		if ( isset($this->_msgTpls[$error]) ) $error = $this->_msgTpls[$error];
		$this->_errors[] = $error;

		add_action('jtmce_print_admin_notice', array( $this, 'printMessages' ));
	}

	/**
	 * Set messages
	 * @param string $message
	 */
	public function addMessage( $message )
	{
		if ( is_null($this->_msgTpls) ) $this->_msgTpls = $this->messageTemplates();

		if ( isset($this->_msgTpls[$message]) ) $message = $this->_msgTpls[$message];
		$this->_messages[] = $message;

		add_action('jtmce_print_admin_notice', array( $this, 'printMessages' ));
	}

	public function getErrors()
	{
		return $this->_errors;
	}

	/**
	 * Check errors
	 */
	public function hasErrors()
	{
		return !empty($this->_errors);
	}

	/**
	 * Render notices 
	 * @param array $args
	 * @return html
	 */
	public function printMessages( $args = array() )
	{
		if ( empty($this->_messages) && empty($this->_errors) )
			return;

		global $wp_version;
		include( JTMCE_ROOT . '/views/_notices.php');
	}

	/**
	 * Set request params
	 * @param array $params
	 * @return boolean
	 */
	public function load( $params )
	{
		if ( !empty($params) ) {
			$this->setAttributes($params);
			return true;
		}
		return false;
	}

	/**
	 * Set default values for attributes which are null
	 *
	 * @param $params
	 */
	public function loadDefaults( $params )
	{
		if ( !empty($params) ) {
			$this->setAttributes($params, true);
		}
	}

	/**
	 * Set attributes to model
	 * @param array $params
	 * @param boolean $defaults
	 */
	public function setAttributes( $params, $defaults = false )
	{
		$self = get_class($this);
		foreach ( $params as $key => $value ) {
			if ( property_exists($self, $key) && (!$defaults || is_null($this->$key)) )
				$this->$key = is_array($value) ? $value : strip_tags(trim($value));
		}
	}

}
