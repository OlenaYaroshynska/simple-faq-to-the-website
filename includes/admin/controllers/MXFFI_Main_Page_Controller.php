<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class MXFFI_Main_Page_Controller extends MXFFI_Controller
{	

	public function settings_menu_item_action()
	{

		return new MXFFI_View( 'settings-page' );

	}

}