<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
* Error Handle calss
*/
class MXFFI_Error_Handle
{

	/**
	* Error name
	*/
	// public $mxffi_error_name = '';	

	/**
	* has error
	*/
	public $mxffi_isnt_error = true;

	public function __construct()
	{

	}
	
	public function mxffi_class_attributes_error( $class_name, $method )
	{

		// if class not exists display an error
		if( class_exists( $class_name ) ) {

			// check if method exists
			$class_inst = new $class_name();

			// if method not exists display an error
			if( !method_exists( $class_inst, $method ) ) {

				// notice of error
				$mxffi_error_notice = "The <b>\"{$class_name}\"</b> class doesn't contain the <b>\"{$method}\"</b> method.";

				// show an error
				$error_method_inst = new MXFFI_Display_Error( $mxffi_error_notice );

				$error_method_inst->mxffi_show_error();

				$this->mxffi_isnt_error = $mxffi_error_notice;

			}

		} else {

			// notice of error
			$mxffi_error_notice = "The <b>\"{$class_name}\"</b> class not exists.";

			// show an error
			$error_class_inst = new MXFFI_Display_Error( $mxffi_error_notice );

			$error_class_inst->mxffi_show_error();

			$this->mxffi_isnt_error = $mxffi_error_notice;

		}
	
		// 
		return $this->mxffi_isnt_error;

	}
	
}