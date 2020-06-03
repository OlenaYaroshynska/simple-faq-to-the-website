<?php
/*
Plugin Name: Simple FAQ To The Website
Plugin URI: https://github.com/ElenaIar/simple-faq-to-the-website
Description: This plugin allows you to place the FAQ system to your website.
Author: olenaiaroshynska
Version: 1.0
Author URI: https://github.com/ElenaIar
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
* Unique string - MXFFI
*/

/*
* Define MXFFI_PLUGIN_PATH
*
* E:\OpenServer\domains\my-domain.com\wp-content\plugins\faq-for-iile\faq-for-iile.php
*/
if ( ! defined( 'MXFFI_PLUGIN_PATH' ) ) {

	define( 'MXFFI_PLUGIN_PATH', __FILE__ );

}

/*
* Define MXFFI_PLUGIN_URL
*
* Return http://my-domain.com/wp-content/plugins/faq-for-iile/
*/
if ( ! defined( 'MXFFI_PLUGIN_URL' ) ) {

	define( 'MXFFI_PLUGIN_URL', plugins_url( '/', __FILE__ ) );

}

/*
* Define MXFFI_PLUGN_BASE_NAME
*
* 	Return faq-for-iile/faq-for-iile.php
*/
if ( ! defined( 'MXFFI_PLUGN_BASE_NAME' ) ) {

	define( 'MXFFI_PLUGN_BASE_NAME', plugin_basename( __FILE__ ) );

}

/*
* Define MXFFI_TABLE_SLUG
*/
if ( ! defined( 'MXFFI_TABLE_SLUG' ) ) {

	define( 'MXFFI_TABLE_SLUG', 'mxffi_table_slug' );

}

/*
* Define MXFFI_PLUGIN_ABS_PATH
* 
* E:\OpenServer\domains\my-domain.com\wp-content\plugins\faq-for-iile/
*/
if ( ! defined( 'MXFFI_PLUGIN_ABS_PATH' ) ) {

	define( 'MXFFI_PLUGIN_ABS_PATH', dirname( MXFFI_PLUGIN_PATH ) . '/' );

}

/*
* Define MXFFI_PLUGIN_VERSION
*/
if ( ! defined( 'MXFFI_PLUGIN_VERSION' ) ) {

	// version
	define( 'MXFFI_PLUGIN_VERSION', '03.06.20' ); // Must be replaced before production on for example '1.0'

}

/*
* Define MXFFI_MAIN_MENU_SLUG
*/
if ( ! defined( 'MXFFI_MAIN_MENU_SLUG' ) ) {

	// version
	define( 'MXFFI_MAIN_MENU_SLUG', 'mxffi-faq-for-iile-menu' );

}

/**
 * activation|deactivation
 */
require_once plugin_dir_path( __FILE__ ) . 'install.php';

/*
* Registration hooks
*/
// Activation
register_activation_hook( __FILE__, array( 'MXFFI_Basis_Plugin_Class', 'activate' ) );

// Deactivation
register_deactivation_hook( __FILE__, array( 'MXFFI_Basis_Plugin_Class', 'deactivate' ) );


/*
* Include the main MXFFIFAQForIile class
*/
if ( ! class_exists( 'MXFFIFAQForIile' ) ) {

	require_once plugin_dir_path( __FILE__ ) . 'includes/final-class.php';

	/*
	* Translate plugin
	*/
	add_action( 'plugins_loaded', 'mxffi_translate' );

	function mxffi_translate()
	{

		load_plugin_textdomain( 'mxffi-domain', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	}

}