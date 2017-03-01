<?php
/*
Plugin Name: Just TinyMCE Custom Styles
Description: Adds dropdown options for custom css classes and attributes for tags in WordPress TinyMCE Editor
Tags: tinymce, editor, link class, custom styles, styles, tag class, link attributes, tag attributes, custom editor
Version: 1.2
Author: JustCoded / Alex Prokopenko
Author URI: http://justcoded.com/
License: GPL2
*/

define('JTMCE_ROOT', dirname(__FILE__));
require_once( JTMCE_ROOT . '/core/helpers.php' );
require_once( JTMCE_ROOT . '/core/Autoload.php' );

use jtmce\core;
use jtmce\components;
use jtmce\controllers;

class JustTinyMceStyles extends core\Singleton
{
	/**
	 * Textual plugin name
	 * 
	 * @var string 
	 */
	public static $pluginName;

	/**
	 * Current plugin version
	 * 
	 * @var float
	 */
	public static $version;

	/**
	 * Plugin text domain for translations
	 */
	const TEXTDOMAIN = 'just-tiny-mce-styles';

	/**
	 * Plugin main entry point
	 * 
	 * protected constructor prevents creating another plugin instance with "new" operator
	 */
	protected function __construct()
	{
		// init plugin name and version
		self::$pluginName = __('Just TinyMCE Custom Styles', JustTinyMceStyles::TEXTDOMAIN);
		self::$version = 1.2;

		// init features, which this plugin is created for
		if ( !is_admin() ) return;
		new components\TinyMceExt();
		new controllers\FormatsController();
		new controllers\SettingsController();
		new controllers\PresetsController();
	}
	
	/**
	 * Checks WordPress version to be greater or equal to the control point
	 * 
	 * @global string $wp_version		method uses global WP var
	 * @param  string $control_version version to compare with
	 * 
	 * @return boolean		true if WordPress version meets the requirements
	 */
	public static function wpVersion( $control_version )
	{
		global $wp_version;
		return ( version_compare($wp_version, $control_version) >= 0 );
	}

}

JustTinyMceStyles::run();
