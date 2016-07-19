<?php
namespace jtmce\core;

/**
 * Data layer to store data inside active theme
 */
class DBDataLayer extends DataLayer
{
	const OPT_NAME = 'jtmce_style_formats';

	/**
	 * Method to find style formats from data storage
	 *
	 * @param boolean $refresh  ignore cache
	 * @return array
	 */
	public function getFormats($refresh = false)
	{
		if ( !is_null($this->_formats) & !$refresh ) {
			return $this->_formats;
		}

		$this->_formats = array();
		if ( $value = get_option(self::OPT_NAME) ) {
			$value = @base64_decode($value);
			$value = @unserialize($value);
			if ( $value ) {
				$this->_formats = $value;
			}
		}

		return $this->_formats;
	}

	/**
	 * Method to save all settings into the storage collector
	 *
	 * @return boolean
	 */
	public function save()
	{
		$value = serialize($this->_formats);
		$value = base64_encode($value);
		return update_option(self::OPT_NAME, $value);
	}

}
