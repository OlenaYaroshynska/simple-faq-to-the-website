<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXFFI_Admin_Main
{

	// list of model names used in the plugin
	public $models_collection = [
		'MXFFI_Main_Page_Model'
	];

	/*
	* MXFFI_Admin_Main constructor
	*/
	public function __construct()
	{

	}

	/*
	* Additional classes
	*/
	public function mxffi_additional_classes()
	{

		// enqueue_scripts class
		mxffi_require_class_file_admin( 'enqueue-scripts.php' );

		MXFFI_Enqueue_Scripts::mxffi_register();

		// CPT class
		mxffi_require_class_file_admin( 'cpt.php' );

		MXFFICPTclass::createCPT();

		// metaboxes
		mxffi_require_class_file_admin( 'metabox-creation.php' );

		MXFFI_Metabox_Creation::metaboxesCreation();

	}

	/*
	* Models Connection
	*/
	public function mxffi_models_collection()
	{

		// require model file
		foreach ( $this->models_collection as $model ) {
			
			mxffi_use_model( $model );

		}		

	}

	/**
	* registration ajax actions
	*/
	public function mxffi_registration_ajax_actions()
	{

		// ajax requests to main page
		MXFFI_Main_Page_Model::mxffi_wp_ajax();

	}

	/*
	* Routes collection
	*/
	public function mxffi_routes_collection()
	{

		// sub settings menu item
		MXFFI_Route::mxffi_get( 'MXFFI_Main_Page_Controller', 'settings_menu_item_action', 'NULL', [
			'menu_title' => 'Simple FAQ',
			'page_title' => 'Simple FAQ'
		], 'settings_simple_faq', true );

	}

}

// Initialize
$initialize_admin_class = new MXFFI_Admin_Main();

// include classes
$initialize_admin_class->mxffi_additional_classes();

// include models
$initialize_admin_class->mxffi_models_collection();

// ajax requests
$initialize_admin_class->mxffi_registration_ajax_actions();

// include controllers
$initialize_admin_class->mxffi_routes_collection();