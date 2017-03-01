<?php

namespace jtmce\models;

use jtmce\core\FilesDataLayer;
use jtmce\core\Model;

class Preset extends Model
{
	public $preset_file;
	public $overwrite;

	/**
	 * Import style formats from "presets" folder inside the plugin
	 *
	 * @return bool
	 */
	public function import()
	{
		if ( !$this->validate() ) return false;

		$preset_src = plugin_dir_path(__FILE__) . '/../presets/' . $this->preset_file;
		$data = FilesDataLayer::readFormatsFile($preset_src);
		if ( empty($data) ) {
			$this->addError('preset_file_error');
		}

		if ( ! $this->overwrite ) {
			$current_formats = $this->_dL->getFormats();
			$data = array_merge($current_formats, $data);
		}

		$model = new Formats();
		$model->formats = $data;
		if ( $model->save() ) {
			$this->maybeEnableItemType($model->formats);
			$this->addMessage('imported');
			return true;
		}
		else {
			$this->addError('import_failed');
			return false;
		}
	}

	/**
	 * Validate that preset_file is set and file really exists inside the plugin folder
	 *
	 * @return bool
	 */
	public function validate()
	{
		if ( empty($this->preset_file) ) {
			$this->addError('empty_preset');
			return false;
		}

		$preset_src = plugin_dir_path(__FILE__) . '/../presets/' . $this->preset_file;
		if ( !is_file($preset_src) ) {
			$this->addError('preset_file_missing');
			return false;
		}

		return true;
	}

	/**
	 * Check that formats special types, so type field is required in settings
	 *
	 * @param array $formats
	 */
	public function maybeEnableItemType($formats)
	{
		$item_type_required = false;

		foreach ($formats as $row => $format) {
			if ( isset($format['type']) && $format['type'] != Formats::TYPE_ITEM ) {
				$item_type_required = true;
				break;
			}
		}

		if ( $item_type_required ) {
			$settings = new Settings();
			$settings->features = Settings::getFeaturesEnabled();
			if ( !in_array('type', $settings->features) ) {
				array_unshift($settings->features, 'type');
				return $settings->updateFeatures();
			}
		}
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
			'empty_preset' => __('<strong>Error!</strong> Please select preset to continue.', \JustTinyMceStyles::TEXTDOMAIN),
			'preset_file_missing' => __('<strong>Error!</strong> Could not read chosen preset file.', \JustTinyMceStyles::TEXTDOMAIN),
			'preset_file_error' => __('<strong>Error!</strong> Preset file is corrupted.', \JustTinyMceStyles::TEXTDOMAIN),
			'import_failed' => __('<strong>Error!</strong> Could not write new settings to current storage.', \JustTinyMceStyles::TEXTDOMAIN),
			'imported' => __('<strong>Congratulations!</strong> You have imported the preset.', \JustTinyMceStyles::TEXTDOMAIN),
		);
	}
}