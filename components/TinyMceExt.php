<?php

namespace jtmce\components;
use jtmce\models\Formats;

/**
 * Adds hooks and methods to extend TinyMCE WordPress editor
 */
class TinyMceExt extends \jtmce\core\Component
{
	/**
	 * initialize wordpress hooks
	 */
	public function __construct()
	{
		add_filter( 'mce_buttons_2', array($this, 'enableFormatButton') );
		add_filter( 'tiny_mce_before_init', array($this, 'setCustomFormats') );

		add_filter( 'mce_css', array($this, 'setCustomFormatsCssUrl') );
		add_action('wp_ajax_jtmce_editor_css', array( $this, 'customFormatsCss' ));
	}

	/**
	 * Enable Format button at the beginning of the second buttons row
	 *
	 * @param array $buttons
	 * @return array
	 */
	public function enableFormatButton( $buttons )
	{
		array_unshift( $buttons, 'styleselect' );
		return $buttons;
	}

	/**
	 * Adds style formats settings to the editor init settings
	 *
	 * @param array $init_array
	 * @return array
	 */
	public function setCustomFormats( $init_array )
	{
		$model = new Formats();
		if ( empty($model->formats) ) {
			return $init_array;
		}

		$formats = $model->formats;

		// detect groups and break all elements on groups
		$group_i = null;

		foreach ( $formats as $i => $item ) {
			$type = isset($item['type'])? $item['type'] : Formats::TYPE_ITEM;
			if ( $type == Formats::TYPE_GROUP ) {
				$formats[$i]['items'] = array();
				$group_i = $i;
				continue;
			}

			if ( !is_null($group_i) ) {
				$formats[$group_i]['items'][] = $item;
				unset($formats[$i]);
			}
		}

		// Insert the array, JSON ENCODED, into 'style_formats'
		$init_array['style_formats'] = json_encode( $formats );

		return $init_array;
	}

	/**
	 * Adds custom css path to the tinyMCE editor to be able to apply styles manually, without extra theme css file
	 *
	 * @param string $stylesheets
	 * @return string
	 */
	public function setCustomFormatsCssUrl($stylesheets)
	{
		$model = new Formats();
		if ( empty($model->formats) ) {
			return $stylesheets;
		}

		$stylesheets .= ',' . get_admin_url(null, 'admin-ajax.php') . '?action=jtmce_editor_css';
		return $stylesheets;
	}

	/**
	 * Generate custom css rules for custom style formats if present in configuration
	 */
	public function customFormatsCss()
	{
		$model = new Formats();
		if ( empty($model->formats) ) {
			return;
		}

		header("Content-Type: text/css; charset=" . get_bloginfo('charset'));
		foreach ( $model->formats as $style_format ) {
			if ( !empty($style_format['editor_css']) ) {
				echo $style_format['editor_css'] . "\n";
			}
		}
	}

}
