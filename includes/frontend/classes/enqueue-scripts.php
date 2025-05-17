<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXFFI_Enqueue_Scripts_Frontend
{

	/*
	* MXFFI_Enqueue_Scripts_Frontend
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
		add_action( 'wp_enqueue_scripts', array( 'MXFFI_Enqueue_Scripts_Frontend', 'mxffi_enqueue' ) );

	}

		public static function mxffi_enqueue()
		{

			wp_enqueue_style( 'mxffi_style', MXFFI_PLUGIN_URL . 'includes/frontend/assets/css/style.css', array(), MXFFI_PLUGIN_VERSION, 'all' );

			// include Vue.js
				// dev version
				// wp_enqueue_script( 'mxvjfepc_vue_js', MXFFI_PLUGIN_URL . 'assets/vue_js/vue.dev.js', array(), '29.05.20', true );

				// production version
				wp_enqueue_script( 'mxvjfepc_vue_js', MXFFI_PLUGIN_URL . 'assets/vue_js/vue.production.js', array(), '10.01.22', true );

			// recaptcha
			wp_enqueue_script( 'vue-recaptcha', MXFFI_PLUGIN_URL . 'includes/frontend/assets/js/vue-recaptcha.min.js', array(), '10.01.22', false );

				wp_enqueue_script( 'google-recaptcha', 'https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit', array(), '10.01.22', false );
			
			wp_enqueue_script( 'mxvjfepc_script', MXFFI_PLUGIN_URL . 'includes/frontend/assets/js/script.js', array( 'mxvjfepc_vue_js', 'jquery' ), MXFFI_PLUGIN_VERSION, true );

			$agre_link = get_option( '_mx_simple_faq_agree_link' );

			if( !$agre_link ) {

				$agre_link = '#';

			}

			$site_key = get_option( '_mx_simple_faq_recaptcha_site_key' );

			if( !$site_key ) {

				$site_key = '';

			}

			wp_localize_script( 'mxvjfepc_script', 'mxvjfepcdata_obj_front', array(

				'nonce' => wp_create_nonce( 'mxvjfepcdata_nonce_request_front' ),

				'ajax_url' => admin_url( 'admin-ajax.php' ),

				'loading_img' => MXFFI_PLUGIN_URL . 'includes/frontend/assets/img/faq_sending.gif',


				'texts'	=> array(
					'search' 			=> __( 'Search', 'simple-faq-to-the-website' ),
					'find' 				=> __( 'Find ...', 'simple-faq-to-the-website' ),
					'make_question' 	=> __( 'Ask a question', 'simple-faq-to-the-website' ),
					'error_getting' 	=> __( 'Error getting FAQ from database!', 'simple-faq-to-the-website' ),
					'call_to_question' 	=> __( 'If you have any questions, write to me and I\'ll answer you', 'simple-faq-to-the-website' ),
					'p_your_name' 		=> __( 'Your name', 'simple-faq-to-the-website' ),
					'your_name' 		=> __( 'Enter your name', 'simple-faq-to-the-website' ),
					'p_your_email' 		=> __( 'Your email', 'simple-faq-to-the-website' ),
					'your_email' 		=> __( 'Enter your email', 'simple-faq-to-the-website' ),
					'your_email_failed'	=> __( 'Invalid email format', 'simple-faq-to-the-website' ),
					'subject'			=> __( 'Question Title', 'simple-faq-to-the-website' ),
					'enter_subject'		=> __( 'Enter Question\'s Title', 'simple-faq-to-the-website' ),
					'agre_text'			=> __( 'I consent to the processing of personal data in accordance with', 'simple-faq-to-the-website' ),
					'agre_doc_name'		=> __( 'Regulation', 'simple-faq-to-the-website' ),
					'agre_failed'		=> __( 'Please give consent to the processing of personal data', 'simple-faq-to-the-website' ),
					'your_message'		=> __( 'Enter your message', 'simple-faq-to-the-website' ),
					'your_message_failed'=> __( 'Enter your question', 'simple-faq-to-the-website' ),
					'submit'			=> __( 'Submit', 'simple-faq-to-the-website' ),
					'success_sent'		=> __( 'Your question has been sent. Thank!', 'simple-faq-to-the-website' ),
					'no_questions'		=> __( 'There are no questions yet.', 'simple-faq-to-the-website' ),
					'nothing_found'		=> __( 'Nothing found!', 'simple-faq-to-the-website' ),
					'recaptcha_failed'	=> __( 'Please verify that you are not a robot.', 'simple-faq-to-the-website' ),
					'agre_link'			=> $agre_link				
				),
				'site_key'          => $site_key
			) );	
		
		}

}