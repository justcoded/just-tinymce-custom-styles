<?php

namespace jtmce\core;

/**
 * Base class for plugin features and components.
 * 
 * Contains global methods which can help you inside your features
 */
class Component
{

	/**
	 * Render view file with extracted params
	 * 
	 * @param string $view    view name to be rendered
	 * @param array  $params  view params 
	 */
	public function render( $path, $params = null )
	{
		$__view = JTMCE_ROOT . '/views/' . $path . '.php';
		if ( !is_file($__view) ) {
			$ml_message = __('{class}::render() : Unable to load {file}', \JustTinyMceStyles::TEXTDOMAIN);
			$ml_message = strtr($ml_message, array(
				'{class}' => get_class($this),
				'{file}' => $__view,
			));
			throw new \Exception($ml_message);
		}

		if ( !empty($params) && is_array($params) ) {
			extract($params);
		}

		include( $__view );
	}

}
