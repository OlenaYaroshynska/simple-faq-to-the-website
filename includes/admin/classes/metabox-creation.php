<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXFFI_Metabox_Creation
{

	/*
	* Observe function
	*/
	public static function metaboxesCreation()
	{

		add_action( 'add_meta_boxes', array( 'MXFFI_Metabox_Creation', 'mxffi_meta_boxes' ) );

		// save response
		add_action( 'save_post_mxffi_iile_faq', array( 'MXFFI_Metabox_Creation', 'mxffi_faq_meta_response_save' ) );

		// save user name
		add_action( 'save_post_mxffi_iile_faq', array( 'MXFFI_Metabox_Creation', 'mxffi_faq_meta_user_name_save' ) );
		
	}

		public static function mxffi_meta_boxes() 
		{

			// user name
			add_meta_box(
				'mxffi_faq_meta_user_name',
				'User name',
				array( 'MXFFI_Metabox_Creation', 'mxffi_faq_meta_user_name_callback' ),
				array( 'mxffi_iile_faq' ),
				'normal'
			);

			// user email
			add_meta_box(
				'mxffi_faq_meta_user_email',
				'Email of the user',
				array( 'MXFFI_Metabox_Creation', 'mxffi_faq_meta_user_email_callback' ),
				array( 'mxffi_iile_faq' ),
				'normal'
			);

			// response
			add_meta_box(
				'mxffi_faq_meta_response',
				'Write an answer',
				array( 'MXFFI_Metabox_Creation', 'mxffi_faq_meta_response_callback' ),
				array( 'mxffi_iile_faq' ),
				'normal'
			);

		}

		public static function mxffi_faq_meta_user_name_callback( $post, $meta )
		{

			$user_name = get_post_meta( $post->ID, '_mxffi_user_name', true );

			echo '<p> <label for="mxffi_user_name"></label><input name="mxffi_user_name" id="mxffi_user_name" value="' . $user_name . '" required />
			</p>';

		}

			public static function mxffi_faq_meta_user_name_save( $post_id )
			{

				if ( ! isset( $_POST['mxffi_meta_box_response_nonce'] ) ) 
					return;

				if ( ! wp_verify_nonce( $_POST['mxffi_meta_box_response_nonce'], 'mxffi_meta_box_response_action') )
					return;

				if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
					return;

				if( ! current_user_can( 'edit_post', $post_id ) )
					return;

				if ( ! isset( $_POST['mxffi_user_name'] ) ) 
					return;

				$user_name = sanitize_text_field( $_POST['mxffi_user_name'] );

				update_post_meta( $post_id, '_mxffi_user_name', $user_name  );

			}

		public static function mxffi_faq_meta_user_email_callback( $post, $meta )
		{

			$user_email = get_post_meta( $post->ID, '_mxffi_user_email', true );

			echo '<p>' . $user_email . '</p>';

		}

		public static function mxffi_faq_meta_response_callback( $post, $meta )
		{

			$response = get_post_meta( $post->ID, '_mxffi_faq_response', true );

			// check nonce
			wp_nonce_field( 'mxffi_meta_box_response_action', 'mxffi_meta_box_response_nonce' );

			echo '<textarea cols="60" rows="10" name="mxffi_faq_response" id="mxffi_faq_response" required>' . $response . '</textarea>';

		}

			public static function mxffi_faq_meta_response_save( $post_id )
			{

				if ( ! isset( $_POST['mxffi_meta_box_response_nonce'] ) ) 
					return;

				if ( ! wp_verify_nonce( $_POST['mxffi_meta_box_response_nonce'], 'mxffi_meta_box_response_action') )
					return;

				if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
					return;

				if( ! current_user_can( 'edit_post', $post_id ) )
					return;

				$response = sanitize_textarea_field( $_POST['mxffi_faq_response'] );

				update_post_meta( $post_id, '_mxffi_faq_response', $response  );

				$user_email = get_post_meta( $post_id, '_mxffi_user_email', true );

				// check if response has sent
				$response_has_sent = get_post_meta( $post_id, '_mxffi_faq_response_sent', true );

				if( $response_has_sent !== '1') {

					MXFFI_Metabox_Creation::mxffi_faq_user_notification( $user_email, $response );

					update_post_meta( $post_id, '_mxffi_faq_response_sent', '1'  );

				}				

			}

			/*
			* User FAQ notification
			*/
			public static function mxffi_faq_user_notification( $email, $message )
			{
				
				if( $email == null ) return;

				update_option( '_mx_test_email', 123 );

				$websit_name = get_bloginfo( 'name' );

				$websit_domain = get_site_url();

				$websit_domain = str_replace( 'http://', '', $websit_domain );

				$websit_domain = str_replace( 'https://', '', $websit_domain );

				$header  = 'From: ' . $websit_name .' <support@' . $websit_domain . '>' . "\r\n";
				$header .= 'Reply-To: support@' . $websit_domain . "\r\n";

				$header .= "Content-Type: text/html; charset=UTF-8\r\n";
				
				$subject = __( 'The answer to your question!', 'simple-faq-to-the-website' );

				$_message = '<p>' . __( 'Hello! The answer to your question.', 'simple-faq-to-the-website' ) . '</p>';

				$_message .= '<p>' . $message . '</p>';

				add_filter( 'wp_mail_content_type', array( 'MXFFI_Metabox_Creation', 'mx_send_html' ) );

				wp_mail( $email, $subject, $_message, $header );

				remove_filter( 'wp_mail_content_type', array( 'MXFFI_Metabox_Creation', 'mx_send_html' ) );
				
			}

			public static function mx_send_html()
			{
				return "text/html";
			}


}