<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// require Route-Registrar.php
require_once MXFFI_PLUGIN_ABS_PATH . 'includes/core/Route-Registrar.php';

/*
* Routes class
*/
class MXFFI_Route
{

	public function __construct()
	{
		// ...
	}
	
	public static function mxffi_get( ...$args )
	{

		return new MXFFI_Route_Registrar( ...$args );

	}
	
}