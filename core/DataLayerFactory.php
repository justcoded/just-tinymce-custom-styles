<?php

namespace jtmce\core;
use jtmce\models\Settings;


/**
 * Class DataLayerFactory
 * Factory to create DataLater object based on plugin settings
 */
class DataLayerFactory
{

	/**
	 * Create data layer object
	 * @param string $layer  database|fs_theme|fs_global / similar to models\Settings::CONF_SOURCE_*
	 * @return \jcf\models\DataLayer
	 */
	public static function create( $source_type = null )
	{
		if ( is_null($source_type) ) {
			$source_type = Settings::getDataSourceType();
		}
		
		$layer_class = ($source_type == Settings::CONF_SOURCE_DB) ? 'DBDataLayer' : 'FilesDataLayer';
		$layer_class = '\\jtmce\\core\\' . $layer_class;
		return new $layer_class();
	}

}
