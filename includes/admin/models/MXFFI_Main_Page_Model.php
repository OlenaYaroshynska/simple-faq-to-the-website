<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Main page Model
*/
class MXFFI_Main_Page_Model extends MXFFI_Model
{

	/*
	* Observe function
	*/
	public static function mxffi_wp_ajax()
	{

		// save email
		add_action( 'wp_ajax_mx_change_admin_email', array( 'MXFFI_Main_Page_Model', 'mx_change_admin_email' ), 10, 1 );

		// save link
		add_action( 'wp_ajax_mx_changev_agree_link', array( 'MXFFI_Main_Page_Model', 'mx_changev_agree_link' ), 10, 1 );

		// save site key
		add_action( 'wp_ajax_mx_changev_site_key', array( 'MXFFI_Main_Page_Model', 'mx_changev_site_key' ), 10, 1 );
	}

	/*
	* save admin email
	*/
	public static function mx_change_admin_email()
	{
		
		// Checked POST nonce is not empty
		if( empty( $_POST['nonce'] ) ) wp_die( '0' );

		// Checked or nonce match
		if( wp_verify_nonce( $_POST['nonce'], 'mxvjfepcdata_nonce_request_admin' ) ){

			$email = sanitize_email( $_POST['email'] );

			$saved = update_option( '_mx_simple_faq_admin_email', $email );

			if( $saved ) {
				echo 'saved';
			} else {
				echo 'failed';
			}

		}

		wp_die();

	}

	/*
	* save link
	*/
	public static function mx_changev_agree_link()
	{
		
		// Checked POST nonce is not empty
		if( empty( $_POST['nonce'] ) ) wp_die( '0' );

		// Checked or nonce match
		if( wp_verify_nonce( $_POST['nonce'], 'mxvjfepcdata_nonce_request_admin' ) ){

			$agree_link = esc_url_raw( $_POST['agree_link'] );

			$saved = update_option( '_mx_simple_faq_agree_link', $agree_link );

			if( $saved ) {
				echo 'saved';
			} else {
				echo 'failed';
			}

		}

		wp_die();

	}

	/*
	* save site key
	*/
	public static function mx_changev_site_key()
	{
		
		// Checked POST nonce is not empty
		if( empty( $_POST['nonce'] ) ) wp_die( '0' );

		// Checked or nonce match
		if( wp_verify_nonce( $_POST['nonce'], 'mxvjfepcdata_nonce_request_admin' ) ){

			$site_key = esc_html( $_POST['site_key'] );

			$saved = update_option( '_mx_simple_faq_recaptcha_site_key', $site_key );

			if( $saved ) {
				echo 'saved';
			} else {
				echo 'failed';
			}
		}

		wp_die();

	}
			
}