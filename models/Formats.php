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
	const TYPE_GROUP = 'group';
	const TYPE_ITEM = 'item';
	const TYPE_WRAPPER = 'wrapper';

	public $formats;

	public function __construct()
	{
		parent::__construct();
		
		$this->formats = $this->_dL->getFormats();
	}

	public static function getFeaturesList()
	{
		return array(
			'type' => __("You can create \"Group title\", single \"Style rule\" or a HTML \"Wrapper\" of block elements. For example a div wrapper or a blockquote.\n By default you're creating \"Style rules\"."),
			'selector' => __("CSS 3 selector pattern to find elements within the selection by. This can be used to apply classes to specific elements or complex things like odd rows in a table. Note that if you combine both selector and block then you can get more nuanced behavior where the button changes the class of the selected tag by default, but adds the block tag around the cursor if the selected tag isn't found."),
			'inline' => __("Name of the inline element to produce for example “span”. The current text selection will be wrapped in this inline element."),
			'block' => __("Name of the block element to produce for example “h1″. Existing block elements within the selection gets replaced with the new block element."),
			'classes' => __("Space separated list of classes to apply to the selected elements or the new inline/block element."),
			'styles' => __("Name/value object with CSS style items to apply such as color etc."),
			'attributes' => __("Name/value object with attributes to apply to the selected elements or the new inline/block element."),
			'exact' => __("Disables the merge similar styles feature when used. This is needed for some CSS inheritance issues such as text-decoration for underline/strikethrough."),
			'editor_css' => __("CSS 3 rules to apply to the TinyMCE editor to display your format in special way."),
		);
	}

	public static function getFeaturesControls()
	{
		return array(
			'type' => array( __('Type'), 'select', 'items' => array(
				self::TYPE_ITEM => 'Style format',
				self::TYPE_WRAPPER => 'Tag wrapper',
				self::TYPE_GROUP => 'Group title' )
			),
			'title' => array( __('Title'), 'text' ),
			'selector' => array( __('Tag Selector'), 'text' ),
			'inline' => array( __('Inline Tag name'), 'text' ),
			'block' => array( __('Block Tag name'), 'text' ),
			'classes' => array( __('Class Attribute value'), 'text' ),
			'styles' => array( __('Style Attribute value'), 'text' ),
			'attributes' => array( __('HTML Attributes'), 'text'  ),
			'exact' => array( __('Merge styles'), 'select', 'items' => array(
				0 => 'Merge Styles',
				1 => 'Do not merge Styles' )
			),
			'editor_css' => array( __('Editor additional CSS rules'), 'textarea' ),
		);
	}

	/**
	 * error messages
	 *
	 * @return array
	 */
	public function messageTemplates()
	{
		return array(
			'updated' => __('<strong>Style Formats</strong> configuration has been updated.', \JustTinyMceStyles::TEXTDOMAIN),
		);
	}

	/**
	 * save formats to dataLayer with validation
	 *
	 * @return bool
	 */
	public function save()
	{
		if ( !$this->validateFormats() )
			return false;
		
		$this->_dL->setFormats($this->formats);
		if ( $this->_dL->save() ) {
			$this->addMessage('updated');
			return true;
		}
		return false;
	}

	/**
	 * Validate $formats properly
	 */
	public function validateFormats()
	{
		if ( empty($this->formats) || !is_array($this->formats) ) {
			$this->formats = array();
			return true;
		}

		// clean up empty values
		$this->formats = array_values($this->formats);
		foreach ($this->formats as $row => $format) {
			foreach ( $format as $key => $value ) {
				$value = trim($value);
				if ( empty($value) )
					unset($format[$key]);
			}

			// set default type
			if ( !isset($format['type']) ) {
				$format['type'] = self::TYPE_ITEM;
			}
			// set wrapper parameter based on type
			if ( $format['type'] == self::TYPE_WRAPPER ) {
				$format['wrapper'] = 1;
			}

			$this->formats[$row] = $format;
		}

		// validate input
		foreach ($this->formats as $row => $format) {
			$row_human = $row + 1;
			$row_error = false;
			$selector_features = array_intersect(array('selector', 'inline', 'block'), array_keys($format));
			$attributes_features = array_intersect(array('classes', 'styles', 'attributes'), array_keys($format));
			$type = isset($format['type'])? $format['type'] : self::TYPE_ITEM;

			if ( empty($format['title']) ) {
				$row_error = true;
				$this->addError(strtr(__("<strong>Row {row}:</strong> Title is empty."), array('{row}' => $row_human)));
			}
			if ( empty($selector_features) && $type != self::TYPE_GROUP ) {
				$row_error = true;
				$this->addError(strtr(__("<strong>Row {row}:</strong> Please set selector/inline/block field."), array('{row}' => $row_human)));
			}
			if ( empty($attributes_features) && $type != self::TYPE_GROUP ) {
				$row_error = true;
				$this->addError(strtr(__("<strong>Row {row}:</strong> Please set one of html modificator fields."), array('{row}' => $row_human)));
			}

			if ( $row_error ) {
				$this->formats[$row]['_hasError'] = true;
			}
		}

		return !$this->hasErrors();
	}
}