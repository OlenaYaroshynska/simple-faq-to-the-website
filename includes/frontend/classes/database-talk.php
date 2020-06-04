<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXFFI_Database_Talk
{

	/*
	* Registration of styles and scripts
	*/
	public static function mxffi_db_ajax()
	{

		// add a new question
		add_action( 'wp_ajax_mx_faq_iile', array( 'MXFFI_Database_Talk', 'add_new_faq' ) );

			add_action( 'wp_ajax_nopriv_mx_faq_iile', array( 'MXFFI_Database_Talk', 'add_new_faq' ) );

		// get count of faq items
		add_action( 'wp_ajax_mx_get_count_faq_items', array( 'MXFFI_Database_Talk', 'mx_get_count_faq_items' ) );

			add_action( 'wp_ajax_nopriv_mx_get_count_faq_items', array( 'MXFFI_Database_Talk', 'mx_get_count_faq_items' ) );

		// get faq items
		add_action( 'wp_ajax_mx_get_faq_items', array( 'MXFFI_Database_Talk', 'mx_get_faq_items' ) );

			add_action( 'wp_ajax_nopriv_mx_get_faq_items', array( 'MXFFI_Database_Talk', 'mx_get_faq_items' ) );

		// search items
		add_action( 'wp_ajax_mx_search_faq_items', array( 'MXFFI_Database_Talk', 'mx_search_faq_items' ) );

			add_action( 'wp_ajax_nopriv_mx_search_faq_items', array( 'MXFFI_Database_Talk', 'mx_search_faq_items' ) );
			

	}

		// add question
		public static function add_new_faq()
		{
			
			if( empty( $_POST['nonce'] ) ) wp_die();

			if( wp_verify_nonce( $_POST['nonce'], 'mxvjfepcdata_nonce_request_front' ) ) {

				$post_ID = wp_insert_post(

					array(

						'post_title' 	=> sanitize_text_field( $_POST['subject'] ),
						'post_content'	=> sanitize_textarea_field( $_POST['message'] ),
						'post_type' 	=> 'mxffi_iile_faq',
						'post_status' 	=> 'verification'

					)

				);

				if( gettype( $post_ID ) == 'integer' ) {

					// user name
					update_post_meta( $post_ID, '_mxffi_user_name', sanitize_text_field( $_POST['user_name'] ) );

					// user email
					update_post_meta( $post_ID, '_mxffi_user_email', sanitize_email( $_POST['user_email'] ) );

					$email = get_option( '_mx_simple_faq_admin_email' );

					if( !$email ) {

						$email = get_user_by( 'ID', 1 )->user_email;

					}

					$websit_name = get_bloginfo( 'name' );

					$websit_domain = get_site_url();

					$websit_domain = str_replace( 'http://', '', $websit_domain );

					$websit_domain = str_replace( 'https://', '', $websit_domain );

					$header  = 'From: ' . $websit_name .' <support@' . $websit_domain . '>' . "\r\n";
					$header .= 'Reply-To: support@' . $websit_domain . "\r\n";

					$header .= "Content-Type: text/html; charset=UTF-8\r\n";

					$subject = __( 'You\'ve received the new Question.', 'mxffi-domain' );

					$message = '<p>' . __( 'User', 'mxffi-domain' ) . ' <b>' . esc_html( $_POST['user_name'] ) . '</b> ' . __( 'has sent a question.', 'mxffi-domain' ) . '</p>';

					$message .= '<p><b>' . esc_html( $_POST['message'] ) . '</b></p>';					

					add_filter( 'wp_mail_content_type', array( 'MXFFI_Database_Talk', 'mx_send_html' ) );

					wp_mail( $email, $subject, $message, $header );

					remove_filter( 'wp_mail_content_type', array( 'MXFFI_Database_Talk', 'mx_send_html' ) );

				}

				echo gettype( $post_ID );

			}

			wp_die();

		}

		public static function mx_send_html()
		{
			return "text/html";
		}

		// get faq item
		public static function mx_get_faq_items()
		{

			if( empty( $_POST['nonce'] ) ) wp_die();

			if( wp_verify_nonce( $_POST['nonce'], 'mxvjfepcdata_nonce_request_front' ) ) {

				$query = sanitize_text_field( $_POST['query'] );

				$current_page = sanitize_text_field( $_POST['current_page'] );

				$current_page = intval( $current_page );

				$faq_per_page = sanitize_text_field( $_POST['faq_per_page'] );

				$current_page = ( $current_page * $faq_per_page ) - $faq_per_page;

				global $wpdb;

				$posts_table = $wpdb->prefix . 'posts';

				$posts_id_results = $wpdb->get_results(

					"SELECT ID, post_title, post_date, post_title, post_content FROM $posts_table
						WHERE post_type = 'mxffi_iile_faq'
							AND post_status = 'publish'
							AND ( post_title LIKE '%$query%'
								OR post_content LIKE '%$query%' )
						ORDER BY post_date DESC
						LIMIT $current_page, $faq_per_page"

				);

				foreach ( $posts_id_results as $key => $value ) {

					$user_name = get_post_meta( $value->ID, '_mxffi_user_name', true );

					$response = get_post_meta( $value->ID, '_mxffi_faq_response', true );

					$posts_id_results[$key]->user_name = $user_name;

					$posts_id_results[$key]->answer = $response;
			
				}					

				$items_stuff = json_encode( $posts_id_results );

				echo $items_stuff;

			}

			wp_die();

		}

		// get count of faq items
		public static function mx_get_count_faq_items()
		{

			if( empty( $_POST['nonce'] ) ) wp_die();

			if( wp_verify_nonce( $_POST['nonce'], 'mxvjfepcdata_nonce_request_front' ) ) {

				$query = sanitize_text_field( $_POST['query'] );

				global $wpdb;

				$posts_table = $wpdb->prefix . 'posts';				

				$faq_coung = $wpdb->get_var(
					"SELECT COUNT(ID)
						FROM $posts_table
						WHERE post_type = 'mxffi_iile_faq'
							AND post_status = 'publish'
							AND ( post_title LIKE '%$query%'
								OR post_content LIKE '%$query%' )
							"
				);

				echo $faq_coung;

			}

			wp_die();

		}

		// get faq item by search
		public static function mx_search_faq_items()
		{

			if( empty( $_POST['nonce'] ) ) wp_die();

			if( wp_verify_nonce( $_POST['nonce'], 'mxvjfepcdata_nonce_request_front' ) ) {

				$query = sanitize_text_field( $_POST['query'] );

				$current_page = sanitize_text_field( $_POST['current_page'] );

				$current_page = intval( $current_page );

				$faq_per_page = sanitize_text_field( $_POST['faq_per_page'] );

				$current_page = ( $current_page * $faq_per_page ) - $faq_per_page;

				global $wpdb;

				$posts_table = $wpdb->prefix . 'posts';

				$posts_id_results = $wpdb->get_results(

					"SELECT ID, post_title, post_date, post_title, post_content FROM $posts_table
						WHERE post_type = 'mxffi_iile_faq'
							AND post_status = 'publish'
							AND ( post_title LIKE '%$query%'
								OR post_content LIKE '%$query%' )
						ORDER BY post_date DESC
						LIMIT $current_page, $faq_per_page
						"

				);

				// var_dump( $posts_id_results );

				foreach ( $posts_id_results as $key => $value ) {

					$user_name = get_post_meta( $value->ID, '_mxffi_user_name', true );

					$response = get_post_meta( $value->ID, '_mxffi_faq_response', true );

					$posts_id_results[$key]->user_name = $user_name;

					$posts_id_results[$key]->answer = $response;										

				}					

				$items_stuff = json_encode( $posts_id_results );

				echo $items_stuff;

			}

			wp_die();

		}

}