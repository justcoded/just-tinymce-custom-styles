<?php

namespace jtmce\components;

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
		// TODO: load from settings

		// Define the style_formats array
		$style_formats = array(
			// Each array child is a format with it's own settings
			array(
				'title' => 'My super link',
				'selector' => 'a',
				'classes' => 'my-super-link',
			),
			array(
				'title' => 'Blue header',
				'selector' => 'h2',
				'classes' => 'blue-header',
			),
			array(
				'title' => 'Custom format',
				'inline' => 'span',
				'classes' => 'ololo',
				'attrributes' => '',
			),
		);
		// Insert the array, JSON ENCODED, into 'style_formats'
		$init_array['style_formats'] = json_encode( $style_formats );

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
		// TODO: check that we have CSS rules first

		$stylesheets .= ',' . get_admin_url(null, 'admin-ajax.php') . '?action=jtmce_editor_css';
		return $stylesheets;
	}

	/**
	 * Generate custom css rules for custom style formats if present in configuration
	 */
	public function customFormatsCss()
	{
		// TODO: Load from settings

		header("Content-Type: text/css; charset=" . get_bloginfo('charset'));
		?>
		a.my-super-link { display:block; border: 1px solid #a00; padding: 10px; }
		h2.blue-header { color: #00f; }
		<?php
	}

}
