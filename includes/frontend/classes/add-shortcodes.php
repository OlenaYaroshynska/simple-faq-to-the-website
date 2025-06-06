<?php

// Exit if accessed directly
if (! defined('ABSPATH')) exit;

class MXFFI_Add_Shortcodes
{


	/*
	* Registration of styles and scripts
	*/
	public static function mx_add_shortcodes()
	{

		$enable_ssr = get_option( '_mx_simple_faq_enable_ssr' );

		if($enable_ssr === '1') {

			// SSR
			add_shortcode('mxffi_faq_template', array('MXFFI_Add_Shortcodes', 'server_side_rendering'));
		} else {

			// Vue
			add_shortcode('mxffi_faq_template', array('MXFFI_Add_Shortcodes', 'mxffi_add_faq_template'));
		}

	}

	public static function server_side_rendering()
	{
		ob_start();

		$args = [
			'query'         => empty($_GET['search']) ? '' : sanitize_text_field($_GET['search']),
			'faq_per_page'  => 20,
			'current_page'  => isset($_GET['paged']) && is_numeric($_GET['paged']) ? intval($_GET['paged']) : 1,
		];

		echo '<div class="mx-faq-server-side-rendering">';

		self::server_side_rendering_search($args);

		self::server_side_rendering_items($args);

		self::server_side_rendering_pagination($args);

		self::server_side_rendering_form();

		echo '</div>';

		return ob_get_clean();
	}

	public static function server_side_rendering_search($args)
	{
		$current_search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : ''; ?>

		<form method="get" action="#faq-list" class="mx-faq-search">
			<div>
				<input
					type="text"
					name="search"
					placeholder="<?php esc_attr_e('Find ...', 'text-domain'); ?>"
					value="<?php echo esc_attr($current_search); ?>" />
				<button type="submit" class="mx-faq-button"><?php esc_html_e('Search', 'text-domain'); ?></button>

				<div class="mx-make-question">
					<a href="#mx-iile-question-form" class="mx-faq-button">
						<?php esc_html_e('Ask a question', 'text-domain'); ?>
					</a>
				</div>
			</div>
		</form>

	<?php
	}

	public static function server_side_rendering_items($args)
	{
		$items = MXFFI_Database_Talk::mx_get_faq_items_body($args); ?>

		<div class="mx-faq-list-of-items">

			<?php if (!empty($items) && is_array($items)) : ?>
				<?php foreach ($items as $index => $item) :
					$id         = 'faq-' . intval($item->ID);
					$title      = $item->post_title;
					$question   = wp_kses_post(html_entity_decode($item->post_content));
					$answer     = wp_kses_post(html_entity_decode($item->answer));
					$user_name  = esc_html($item->user_name);
					$date_parts = explode(' ', $item->post_date);
					$date       = date('j/n/Y', strtotime($date_parts[0]));
					$is_open    = $index === 0;
				?>
					<div class="mx-faq-item" id="<?php echo esc_attr($id); ?>">
						<div class="mx-faq-item-header">
							<div class="mx-faq-item-date"><?php echo esc_html($date); ?></div>
							<div class="mx-faq-item-subject">
								<a href="#">
									<strong><?php echo esc_html($title); ?></strong>
									<span class="dashicons-plus dashicons" style="<?php echo esc_attr($is_open ? 'display:none;' : ''); ?>"></span>
									<span class="dashicons-minus dashicons" style="<?php echo esc_attr($is_open ? '' : 'display:none;'); ?>"></span>
								</a>
							</div>
							<div class="mx-faq-item-user"><?php echo esc_html($user_name); ?></div>
						</div>
						<div class="mx-faq-item-body" style="<?php echo esc_attr($is_open ? '' : 'display: none;'); ?>">
							<div class="mx-faq-item-question"><?php echo $question; ?></div>
							<div class="mx-faq-item-answer"><?php echo $answer; ?></div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<p><?php esc_html_e('No FAQs found.', 'text-domain'); ?></p>
			<?php endif; ?>

		</div>

		<?php
	}

	public static function server_side_rendering_pagination($args)
	{
		$per_page     = !empty($args['faq_per_page']) ? intval($args['faq_per_page']) : 1;
		$current_page = !empty($args['current_page']) ? intval($args['current_page']) : 1;
		$query        = !empty($args['query']) ? sanitize_text_field($args['query']) : '';

		$total_items  = MXFFI_Database_Talk::mx_get_count_faq_items_body($query);
		$total_pages  = (int) ceil($total_items / $per_page);

		if ($total_pages > 1): ?>
			<ul class="mx-faq-pagination">
				<?php for ($page = 1; $page <= $total_pages; $page++) :
					$url = esc_url(add_query_arg([
						'paged' => $page,
						'search' => $query,
					]));
					$is_current = $page === $current_page;
				?>
					<li class="<?php echo $is_current ? 'mx-current-page' : ''; ?>">
						<a href="<?php echo $url; ?>#faq-list">
							<?php echo esc_html($page); ?>
						</a>
					</li>
				<?php endfor; ?>
			</ul>
		<?php endif;
	}

	public static function server_side_rendering_form()
	{ ?>

		<div id="mx_iile_faq">

			<!-- form -->
			<mx_faq_form></mx_faq_form>

		</div>
	<?php
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
				@mx-search-request="searchQuestion"></mx_faq_search>

			<!-- list of items -->
			<mx_faq_list_items
				:getfaqitems="faqItems"
				:parsejsonerror="parseJSONerror"
				:pageloading="pageLoading"
				:load_img="loadImg"
				:no_items="noItemsDisplay"></mx_faq_list_items>

			<!-- pagination -->
			<mx_faq_pagination
				:pageloading="pageLoading"
				v-if="!parseJSONerror"
				:faqcount="faqCount"
				:faqperpage="faqPerPage"
				:faqcurrentpage="faqCurrentPage"
				@get-faq-page="changeFaqPage"></mx_faq_pagination>

			<!-- form -->
			<mx_faq_form></mx_faq_form>

		</div>

<?php return ob_get_clean();
	}
}
