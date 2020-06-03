<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXFFI_Add_Shortcodes
{


	/*
	* Registration of styles and scripts
	*/
	public static function mx_add_shortcodes()
	{

		// FAQ's form
		add_shortcode( 'mxffi_faq_template', array( 'MXFFI_Add_Shortcodes', 'mxffi_add_faq_template' ) );

		// Display list of questions
		
	}

		// form
		public static function mxffi_add_faq_template()
		{
			ob_start();
			?>

			<!-- <script src="" async defer></script> -->
		
			<div id="mx_iile_faq">

				<!-- search -->
				<mx_faq_search
					:pageloading="pageLoading"
					@mx-search-request="searchQuestion"
				></mx_faq_search>

				<!-- list of items -->
				<mx_faq_list_items
					:getfaqitems="faqItems"
					:parsejsonerror="parseJSONerror"
					:pageloading="pageLoading"
					:load_img="loadImg"
					:no_items="noItemsDisplay"
				></mx_faq_list_items>

				<!-- pagination -->
				<mx_faq_pagination
					:pageloading="pageLoading"
					v-if="!parseJSONerror"
					:faqcount="faqCount"
					:faqperpage="faqPerPage"
					:faqcurrentpage="faqCurrentPage"					
					@get-faq-page="changeFaqPage"
				></mx_faq_pagination>					
							
				<!-- form -->
				<mx_faq_form></mx_faq_form>

			</div>

			<?php return ob_get_clean();
		}

}