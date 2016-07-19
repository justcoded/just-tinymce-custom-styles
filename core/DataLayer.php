<?php

namespace jtmce\core;

/**
 * Abstract class for all data layers
 * Define methods to be defined in every child DataLayer
 */
abstract class DataLayer
{
	/**
	 * style formats settings
	 *
	 * @var array
	 */
	protected $_formats = null;

	/**
	 * DataLayer constructor.
	 */
	public function __construct()
	{
	}

	/**
	 * Method to find style formats from data storage
	 *
	 * @return array
	 */
	abstract public function getFormats();

	/**
	 * Method to save all settings into the storage collector
	 *
	 * @return mixed
	 */
	abstract public function save();

	/**
	 * Style formats settings setter
	 *
	 * @param array $formats
	 */
	public function setFormats($formats)
	{
		$this->_formats = $formats;
	}

}
