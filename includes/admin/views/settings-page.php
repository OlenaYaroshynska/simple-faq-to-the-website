<div class="mx-main-page-text-wrap">

	<div id="mx_admin_app">
			
		<h1><?php echo __( 'Simple FAQ settings', 'mxffi-domain' ); ?></h1>

		<p>
			<span><?php echo __( 'Shortcode', 'mxffi-domain' ); ?></span>	<br>
			[mxffi_faq_template]
		</p>

		<p>
			<span><?php echo __( 'Admin\'s Email', 'mxffi-domain' ); ?></span>	<br>

			<?php

				$get_email = get_option( '_mx_simple_faq_admin_email' );

				if( !$get_email ) {

					$get_email = get_user_by( 'ID', 1 )->user_email;

				}

			?>

			<mx_admin_email_form
				:an_email="'<?php echo $get_email; ?>'"
			></mx_admin_email_form>
			
		</p>

		<p>
			<span><?php echo __( 'Link to the Agreement document', 'mxffi-domain' ); ?></span>	<br>

			<?php

				$agree_link = get_option( '_mx_simple_faq_agree_link' );

				if( !$agree_link ) {

					$agree_link = '#';

				}

			?>
			
			<mx_agree_link_form
				:agree_link="'<?php echo $agree_link; ?>'"
			></mx_agree_link_form>
		</p>

	</div>

</div>