<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 7/19/16
 * Time: 13:44
 */

namespace jtmce\models;


use jtmce\core\Model;

class Formats extends Model
{


	public static function getFeaturesList()
	{
		return array(
			'selector' => __("CSS 3 selector pattern to find elements within the selection by. This can be used to apply classes to specific elements or complex things like odd rows in a table. Note that if you combine both selector and block then you can get more nuanced behavior where the button changes the class of the selected tag by default, but adds the block tag around the cursor if the selected tag isn't found."),
			'inline' => __("Name of the inline element to produce for example “span”. The current text selection will be wrapped in this inline element."),
			'block' => __("Name of the block element to produce for example “h1″. Existing block elements within the selection gets replaced with the new block element."),
			'classes' => __("Space separated list of classes to apply to the selected elements or the new inline/block element."),
			'styles' => __("Name/value object with CSS style items to apply such as color etc."),
			'attributes' => __("Name/value object with attributes to apply to the selected elements or the new inline/block element."),
			'exact' => __("Disables the merge similar styles feature when used. This is needed for some CSS inheritance issues such as text-decoration for underline/strikethrough."),
			'wrapper' => __("State that tells that the current format is a container format for block elements. For example a div wrapper or blockquote."),
			'editor_css' => __("CSS 3 rules to apply to the TinyMCE editor to display your format in special way."),
		);
	}

	public static function getFeaturesControls()
	{
		return array(
			'title' => array( __('Title'), 'text' ),
			'selector' => array( __('Tag Selector'), 'text' ),
			'inline' => array( __('Inline Tag name'), 'text' ),
			'block' => array( __('Block Tag name'), 'text' ),
			'classes' => array( __('Class Attribute value'), 'text' ),
			'styles' => array( __('Style Attribute value'), 'text' ),
			'attributes' => array( __('HTML Attributes'), 'text'  ),
			'exact' => array( __('Merge styles'), 'select', 'items' => array( 0 => 'Merge Styles', 1 => 'Do not merge Styles' ) ),
			'wrapper' => array( __('Wrapper'), 'select', 'items' => array( 0 => 'Single format', 1 => 'Wrapper format' ) ),
			'editor_css' => array( __('Editor additional CSS rules'), 'textarea' ),
		);
	}
}