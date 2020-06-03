<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/*
* Error Handle calss
*/
class MXFFI_Display_Error
{

	/**
	* Error notice
	*/
	public $mxffi_error_notice = '';

	public function __construct( $mxffi_error_notice )
	{

		$this->mxffi_error_notice = $mxffi_error_notice;

	}

	public function mxffi_show_error()
	{
		add_action( 'admin_notices', function() { ?>

			<div class="notice notice-error is-dismissible">

			    <p><?php echo $this->mxffi_error_notice; ?></p>
			    
			</div>
		    
		<?php } );
	}

}