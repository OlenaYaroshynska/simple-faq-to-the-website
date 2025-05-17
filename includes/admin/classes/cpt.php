<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXFFICPTclass
{

	/*
	* MXFFICPTclass constructor
	*/
	public function __construct()
	{		

	}

	/*
	* Observe function
	*/
	public static function createCPT()
	{

		add_action( 'init', array( 'MXFFICPTclass', 'mxffi_custom_init' ) );

	}

	/*
	* Create a Custom Post Type
	*/
	public static function mxffi_custom_init()
	{

		$count_v_posts = self::mxffi_count_of_verification_posts();

		$_menu_title = 'Simple FAQ';

		if( $count_v_posts !== false ) {

			$_menu_title =  'Simple FAQ (' . $count_v_posts . ')';

		}
		
		register_post_type( 'mxffi_iile_faq', array(

			'labels'             => array(
				'name'               =>  __( 'Simple FAQ', 'simple-faq-to-the-website' ),
				'singular_name'      =>  __( 'Question', 'simple-faq-to-the-website' ),
				'add_new'            =>  __( 'Add Question', 'simple-faq-to-the-website' ),
				'add_new_item'       =>  __( 'Add Question', 'simple-faq-to-the-website' ),
				'edit_item'          =>  __( 'Edit Question', 'simple-faq-to-the-website' ),
				'new_item'           =>  __( 'New Question', 'simple-faq-to-the-website' ),
				'view_item'          =>  __( 'View Question', 'simple-faq-to-the-website' ),
				'search_items'       =>  __( 'Search Question', 'simple-faq-to-the-website' ),
				'not_found'          =>	 __( 'Not found', 'simple-faq-to-the-website' ),
				'not_found_in_trash' =>  __( 'Not found in trash', 'simple-faq-to-the-website' ),
				'parent_item_colon'  => '',
				'menu_name'          => $_menu_title

			  ),
			'public' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'supports'           => array( 'title', 'editor' )

		) );

		// new post status
		register_post_status( 'verification', array(
            'label'                     => _x( 'New questions ', 'post status label', 'simple-faq-to-the-website' ),
            'public'                    => true,
            'label_count'               => _n_noop( 'New questions <span class="count">(%s)</span>', 'New questions <span class="count">(%s)</span>', 'simple-faq-to-the-website' ),
            'post_type'                 => array( 'mxffi_iile_faq' ),
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'show_in_metabox_dropdown'  => true,
            'show_in_inline_dropdown'   => true,
            'dashicon'                  => 'dashicons-businessman',
        ) );

		// Rewrite rules
		if( is_admin() && get_option( 'mxffi_flush_rewrite_rules' ) == 'go_flush_rewrite_rules' )
		{

			delete_option( 'mxffi_flush_rewrite_rules' );

			flush_rewrite_rules();

		}

	}
	
	public static function mxffi_count_of_verification_posts()
		{

			global $wpdb;

			$count_of_posts = false;

			$posts_table = $wpdb->prefix . 'posts';

			$posts_results = $wpdb->get_results( 
				"SELECT ID FROM $posts_table
					WHERE post_status = 'verification'
						AND post_type = 'mxffi_iile_faq'"
			);

			if( count( $posts_results ) > 0 ) {

				$count_of_posts = count( $posts_results );

			}

			return $count_of_posts;

		}

}