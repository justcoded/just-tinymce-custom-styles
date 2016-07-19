<?php

namespace jtmce\models;

use jtmce\core\FilesDataLayer;
use jtmce\core\Model;

class Settings extends Model
{
	const CONF_SOURCE_DB = 'database';
	const CONF_SOURCE_THEME = 'theme';

	const OPT_SOURCE = 'jtmce_source_settings';
	const OPT_THEME_FILE = 'jtmce_source_theme_path';
	const OPT_FEATURES_ENABLED = 'jtmce_features';

	public $source;
	public $source_theme_file;
	public $features;

	/**
	 * Get source settings
	 * @return string
	 */
	public static function getDataSourceType()
	{
		return get_site_option(self::OPT_SOURCE, self::CONF_SOURCE_DB);
	}

	/**
	 * Get enabled features flags
	 * @return string
	 */
	public static function getFeaturesEnabled()
	{
		$opt = get_site_option(self::OPT_FEATURES_ENABLED, '');

		$features = array();
		if ( !empty($opt) ) {
			$features = explode(',', $opt);
		}
		return $features;
	}

	/**
	 * Get source settings
	 * @return string
	 */
	public static function getDataSourceThemeFile()
	{
		return get_site_option(self::OPT_THEME_FILE, 'editor-formats.json');
	}

	/**
	 * pre-load settings from DB
	 * @param $params
	 */
	public function loadDefaults($params)
	{
		$params['source'] = self::getDataSourceType();
		$params['source_theme_file'] = self::getDataSourceThemeFile();
		$features = self::getFeaturesEnabled();
		if ( !empty($features) ) {
			$params['features'] = $features;
		}
		parent::loadDefaults($params);
	}

	/**
	 * Save settings
	 * @return boolean
	 */
	public function save()
	{
		if ( !$this->validateDataSource() || !$this->validateFeatures() ) {
			return false;
		}

		return $this->updateDataSource() && $this->updateFeatures();
	}

	/**
	 * Update source data
	 * @return boolean
	 */
	protected function updateDataSource()
	{
		if ( !$this->validateDataSource() )
			return false;

		update_site_option(self::OPT_SOURCE, $this->source);
		if ( self::CONF_SOURCE_THEME == $this->source ) {
			update_site_option(self::OPT_THEME_FILE, $this->source_theme_file);
		}
		$this->addMessage('source_updated');
		return true;
	}

	/**
	 * error messages
	 *
	 * @return array
	 */
	public function messageTemplates()
	{
		return array(
			'empty_source' => __('<strong>Settings storage update FAILED!</strong>. Choose an option for the data storage', \JustTinyMceStyles::TEXTDOMAIN),
			'empty_features' => __('<strong>Features update FAILED!</strong>. Please choose features to use.', \JustTinyMceStyles::TEXTDOMAIN),
			'empty_selector_features' => __('<strong>Features update FAILED!</strong>. Please choose at least one selector/inline/block.', \JustTinyMceStyles::TEXTDOMAIN),
			'empty_attributes_features' => __('<strong>Features update FAILED!</strong>. Please choose at least one feature which modify html attributes.', \JustTinyMceStyles::TEXTDOMAIN),
			'invalid_source_theme_file' => __('<strong>Settings storage update FAILED!</strong>. Check that you specified .json file name for theme file path', \JustTinyMceStyles::TEXTDOMAIN),
			'theme_not_writable' => __('<strong>Settings storage update FAILED!</strong>. Check that directory is writable: ' . dirname(get_stylesheet_directory().'/'.$this->source_theme_file), \JustTinyMceStyles::TEXTDOMAIN),

			'source_updated' => __('<strong>Settings storage</strong> configurations has been updated.', \JustTinyMceStyles::TEXTDOMAIN),
			'features_updated' => __('<strong>Features</strong> configuration has been updated.', \JustTinyMceStyles::TEXTDOMAIN),
		);
	}

	/**
	 * Validate current value of source attribute
	 * @return bool
	 */
	public function validateDataSource()
	{
		if ( empty($this->source) ) {
			$this->addError('empty_source');
			return false;
		}

		if ( self::CONF_SOURCE_THEME == $this->source ) {
			$this->source_theme_file = trim($this->source_theme_file);
			$this->source_theme_file = ltrim($this->source_theme_file, '/');

			if ( empty($this->source_theme_file) || !preg_match('/\.json$/', strtolower($this->source_theme_file)) ) {
				$this->addError('invalid_source_theme_file');
			}
			else {
				$parent_dir = dirname( FilesDataLayer::getFilePath($this->source_theme_file) );
				if (!wp_mkdir_p($parent_dir) || !is_writable($parent_dir)) {
					$this->addError('theme_not_writable');
				}
			}
		}

		return ! $this->hasErrors();
	}

	/**
	 * Validate that features are not empty and selected at least one tag-selector feature and at least one attribute modificator feature
	 *
	 * @return bool
	 */
	public function validateFeatures()
	{
		if ( empty($this->features) || !is_array($this->features) ) {
			$this->addError('empty_features');
			return false;
		}

		$selector_features = array_intersect(array('selector', 'inline', 'block'), $this->features);
		$attributes_features = array_intersect(array('classes', 'styles', 'attributes'), $this->features);

		if ( empty($selector_features) ) {
			$this->addError('empty_selector_features');
		}
		if ( empty($attributes_features) ) {
			$this->addError('empty_attributes_features');
		}

		return !$this->hasErrors();
	}

	/**
	 * Write feature settings to DB
	 *
	 * @return bool
	 */
	public function updateFeatures()
	{
		if ( !$this->validateFeatures() ) {
			return false;
		}

		$value = implode(',', $this->features);
		if ( update_site_option(self::OPT_FEATURES_ENABLED, $value) ) {
			$this->addMessage('features_updated');
			return true;
		}

		return false;
	}
}
