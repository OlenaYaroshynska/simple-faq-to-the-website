<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXFFI_Enqueue_Scripts
{

	/*
	* MXFFI_Enqueue_Scripts
	*/
	public function __construct()
	{

	}

	/*
	* Registration of styles and scripts
	*/
	public static function mxffi_register()
	{

		// register scripts and styles
		add_action( 'admin_enqueue_scripts', array( 'MXFFI_Enqueue_Scripts', 'mxffi_enqueue' ) );

	}

		public static function mxffi_enqueue()
		{

			wp_enqueue_style( 'mxffi_font_awesome', MXFFI_PLUGIN_URL . 'assets/font-awesome-4.6.3/css/font-awesome.min.css' );

			wp_enqueue_style( 'mxffi_admin_style', MXFFI_PLUGIN_URL . 'includes/admin/assets/css/style.css', array( 'mxffi_font_awesome' ), MXFFI_PLUGIN_VERSION, 'all' );

			// include Vue.js
				// dev version
				wp_enqueue_script( 'mxvjfepc_vue_js', MXFFI_PLUGIN_URL . 'assets/vue_js/vue.dev.js', array(), '29.05.20', true );

				// production version
				//wp_enqueue_script( 'mxvjfepc_vue_js', MXFFI_PLUGIN_URL . 'assets/vue_js/vue.production.js', array(), '29.05.20', true );

			wp_enqueue_script( 'mxffi_admin_script', MXFFI_PLUGIN_URL . 'includes/admin/assets/js/script.js', array( 'mxvjfepc_vue_js', 'jquery' ), MXFFI_PLUGIN_VERSION, true );

			wp_localize_script( 'mxffi_admin_script', 'mxvjfepcdata_obj_admin', array(

				'nonce' => wp_create_nonce( 'mxvjfepcdata_nonce_request_admin' ),

				'ajax_url' => admin_url( 'admin-ajax.php' ),

				'texts' => array(
					'form_saved' => 'Success!',
					'form_failed' => 'Someting went wrong'
				)

			) );

		}

}