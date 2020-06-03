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
				wp_enqueue_script( 'mxvjfepc_vue_js', MXFFI_PLUGIN_URL . 'assets/vue_js/vue.dev.js', array(), '29.05.20', true );

				// production version
				//wp_enqueue_script( 'mxvjfepc_vue_js', MXFFI_PLUGIN_URL . 'assets/vue_js/vue.production.js', array(), '29.05.20', true );

			// recaptcha
			// wp_enqueue_script( 'vue-recaptcha', MXFFI_PLUGIN_URL . 'includes/frontend/assets/js/vue-recaptcha.min.js', array(), '28.05.20', false );

				// wp_enqueue_script( 'google-recaptcha', 'https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit', array(), '28.05.20', false );
			
			wp_enqueue_script( 'mxvjfepc_script', MXFFI_PLUGIN_URL . 'includes/frontend/assets/js/script.js', array( 'mxvjfepc_vue_js', 'jquery' ), MXFFI_PLUGIN_VERSION, true );

			$agre_link = get_option( '_mx_simple_faq_agree_link' );

			if( !$agre_link ) {

				$agre_link = '#';

			}

			wp_localize_script( 'mxvjfepc_script', 'mxvjfepcdata_obj_front', array(

				'nonce' => wp_create_nonce( 'mxvjfepcdata_nonce_request_front' ),

				'ajax_url' => admin_url( 'admin-ajax.php' ),

				'loading_img' => MXFFI_PLUGIN_URL . 'includes/frontend/assets/img/faq_sending.gif',


				'texts'	=> array(
					'search' 			=> __( 'Search', 'mxffi-domain' ),
					'find' 				=> __( 'Find ...', 'mxffi-domain' ),
					'make_question' 	=> __( 'Make a question', 'mxffi-domain' ),
					'error_getting' 	=> __( 'Error getting FAQ from database!', 'mxffi-domain' ),
					'call_to_question' 	=> __( 'If you have any questions, write to us, and we will answer you.', 'mxffi-domain' ),
					'p_your_name' 		=> __( 'Your name', 'mxffi-domain' ),
					'your_name' 		=> __( 'Enter your name', 'mxffi-domain' ),
					'p_your_email' 		=> __( 'Your email', 'mxffi-domain' ),
					'your_email' 		=> __( 'Enter your email', 'mxffi-domain' ),
					'your_email_failed'	=> __( 'Invalid email format', 'mxffi-domain' ),
					'subject'			=> __( 'Question Title', 'mxffi-domain' ),
					'enter_subject'		=> __( 'Enter Question\'s Title', 'mxffi-domain' ),
					'agre_text'			=> __( 'I consent to the processing of personal data in accordance with', 'mxffi-domain' ),
					'agre_doc_name'		=> __( 'Regulation', 'mxffi-domain' ),
					'agre_failed'		=> __( 'You must give consent to the processing of personal data', 'mxffi-domain' ),
					'your_message'		=> __( 'Enter your message', 'mxffi-domain' ),
					'your_message_failed'=> __( 'Enter your question', 'mxffi-domain' ),
					'submit'			=> __( 'Submit', 'mxffi-domain' ),
					'success_sent'		=> __( 'Your question has been sent. Thank!', 'mxffi-domain' ),
					'no_questions'		=> __( 'There are no questions yet.', 'mxffi-domain' ),
					'nothing_found'		=> __( 'Nothing found!', 'mxffi-domain' ),
					'agre_link'			=> $agre_link
					
				)

			) );	
		
		}

}