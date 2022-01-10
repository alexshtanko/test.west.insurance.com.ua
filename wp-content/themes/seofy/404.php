<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Seofy
 * @since 1.0
 * @version 1.0
 */

get_header();?>
	<div class="wgl-container">
		<div class="row">
			<div class="wgl_col-12">
				<section class="page_404_wrapper">
					<div class="banner_404"><img src="<?php echo esc_url(get_template_directory_uri() . "/img/404.png"); ?>"></div>
					<h2 class="banner_404_title"><?php echo esc_html__('Sorry We Can\'t Find That Page!', 'seofy'); ?></h2>
					<p class="banner_404_text"><?php echo esc_html__('The page you are looking for was moved, removed, renamed or never existed.', 'seofy'); ?></p>
					<div class="seofy_404_search">
						<?php get_search_form(); ?>
					</div>
					<div class="seofy_404_button seofy_module_button wgl_button wgl_button-l acenter">
						<a class="wgl_button_link" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Take me home', 'seofy'); ?></a>
					</div>
				</section>
			</div>
		</div>
	</div>
<?php get_footer(); ?>