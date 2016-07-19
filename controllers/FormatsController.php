<?php

namespace jtmce\controllers;

use jtmce\core\Controller;
use jtmce\models\Formats;
use jtmce\models\Settings;

class FormatsController extends Controller
{

	/**
	 * Init all wp-actions
	 */
	public function __construct()
	{
		parent::__construct();
		add_action('admin_menu', array( $this, 'adminMenu' ));

		if ( isset($_GET['page']) && strpos($_GET['page'], 'jtmce_') !== FALSE ) {
			add_action('admin_init', array( $this, 'addScripts' ));
			add_action('admin_init', array( $this, 'addStyles' ));
		}
	}

	/**
	 * Init menu item and index page for plugin
	 */
	public function adminMenu()
	{
		$page_title = __('TinyMCE Custom Styles');

		add_options_page($page_title, $page_title, 'manage_options', 'jtmce_formats', array( $this, 'actionIndex' ));
	}

	/**
	 * Render index page
	 */
	public function actionIndex()
	{
		$model = new Formats();
		$features = Settings::getFeaturesEnabled();

		// load template
		return $this->render('formats/index', array(
				'tab' => 'formats',
				'model' => $model,
				'features' => $features,
		));
	}

	/**
	 * Include scripts
	 */
	public function addScripts()
	{
		$slug = 'justcoded-multifield';
		wp_register_script(
			$slug,
			plugins_url( '/assets/js/jcforms-multifield.js' , dirname(__FILE__) ),
			array( 'jquery', 'json2', 'jquery-form', 'jquery-ui-sortable' )
		);
		wp_enqueue_script($slug);
	}

	/**
	 * JS localization text strings
	 /
	public function localizeScripts()
	{
		// add text domain
		$i18n_slug = 'just-custom-fields-i18n';
		wp_register_script($i18n_slug, WP_PLUGIN_URL . '/just-custom-fields/assets/jcf_i18n.js');
		wp_localize_script($i18n_slug, 'jcf_textdomain', jcf_get_language_strings());
		wp_enqueue_script($i18n_slug);
	}

	/**
	 * Include styles
	 */
	public function addStyles()
	{
		wp_register_style('justcoded-multifield', plugins_url( '/assets/css/jcforms-multifield.css' , dirname(__FILE__) ) );
		wp_enqueue_style('justcoded-multifield');
	}
}
