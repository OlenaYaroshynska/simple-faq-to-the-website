<div class="mx-main-page-text-wrap">

	<div id="mx_admin_app">
			
		<h1><?php echo __( 'Simple FAQ settings', 'simple-faq-to-the-website' ); ?></h1>

		<p>
			<span><?php echo __( 'Shortcode', 'simple-faq-to-the-website' ); ?></span>	<br>
			[mxffi_faq_template]
		</p>

		<p>
			<span><?php echo __( 'Admin\'s Email', 'simple-faq-to-the-website' ); ?></span>	<br>

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
			<span><?php echo __( 'Link to the Agreement document', 'simple-faq-to-the-website' ); ?></span>	<br>

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

		<p>
			<span><?php echo __( 'ReCaptcha V2 Site Key', 'simple-faq-to-the-website' ); ?></span> <a href="https://www.google.com/recaptcha/admin/create" target="_blank">google.com/recaptcha</a>	<br>

			<?php

				$recaptcha_site_key = get_option( '_mx_simple_faq_recaptcha_site_key' );

				if( !$recaptcha_site_key ) {

					$recaptcha_site_key = '';

				}

			?>
			
			<mx_recaptcha_site_key_form
				:site_key="'<?php echo $recaptcha_site_key; ?>'"
			></mx_recaptcha_site_key_form>
		</p>

	</div>

</div>