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
		$model->load($_POST) && $model->save();

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
	 * Include styles
	 */
	public function addStyles()
	{
		wp_register_style('justcoded-multifield', plugins_url( '/assets/css/jcforms-multifield.css' , dirname(__FILE__) ) );
		wp_enqueue_style('justcoded-multifield');
	}
}
