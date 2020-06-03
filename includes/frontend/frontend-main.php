<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXFFI_FrontEnd_Main
{

	/*
	* MXFFI_FrontEnd_Main constructor
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
		mxffi_require_class_file_frontend( 'enqueue-scripts.php' );

		MXFFI_Enqueue_Scripts_Frontend::mxffi_register();

		// add shortcodes class
		mxffi_require_class_file_frontend( 'add-shortcodes.php' );

			// shortcode of FAQ's form
			MXFFI_Add_Shortcodes::mx_add_shortcodes();

		// ajax
		mxffi_require_class_file_frontend( 'database-talk.php' );

			MXFFI_Database_Talk::mxffi_db_ajax();

	}

}

// Initialize
$initialize_admin_class = new MXFFI_FrontEnd_Main();

// include classes
$initialize_admin_class->mxffi_additional_classes();