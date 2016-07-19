<?php

namespace jtmce\core;
use jtmce\models\Settings;

/**
 * Data layer to store data inside active theme
 */
class FilesDataLayer extends DataLayer
{

	/**
	 * Method to find style formats from data storage
	 *
	 * @return array
	 */
	public function getFormats()
	{}

	/**
	 * Method to save all settings into the storage collector
	 *
	 * @return boolean
	 */
	public function save()
	{}

	public static function getFilePath( $rel_file = null )
	{
		if ( is_null($rel_file) ) $rel_file = Settings::getDataSourceThemeFile();

		return get_stylesheet_directory() . '/' . ltrim($rel_file, '/');
	}
}
