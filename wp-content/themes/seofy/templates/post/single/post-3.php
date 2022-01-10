<?php
    $single = Seofy_SinglePost::getInstance();
    $single->set_data();

    $title = get_the_title();

	$show_share = Seofy_Theme_Helper::get_option('single_share');
	$single_author_info = Seofy_Theme_Helper::get_option('single_author_info');
	$single_meta = Seofy_Theme_Helper::get_option('single_meta');
	$show_views = Seofy_Theme_Helper::get_option('single_views');
	$show_tags = Seofy_Theme_Helper::get_option('single_meta_tags');
	$single->set_post_views(get_the_ID());
	$featured_image = Seofy_Theme_Helper::options_compare('post_hide_featured_image', 'mb_post_hide_featured_image', '1');
?>

<div class="blog-post blog-post-single-item format-<?php echo esc_attr($single->get_pf()); ?>">
	<div <?php post_class("single_meta"); ?>>
		<div class="item_wrapper">
			<div class="blog-post_content">
				<?php 
				if(!(bool) $featured_image){
					$pf_type = $single->get_pf();
					$video_style = function_exists("rwmb_meta") ? rwmb_meta('post_format_video_style') : '';
					if($pf_type !== 'standard-image' && $pf_type !== 'standard'){
						if($pf_type === 'video' && $video_style === 'bg_video'){
						}else{
							$single->render_featured(false, 'full' );
						}
						
					}		
				}			
					the_content();

					wp_link_pages(array('before' => '<div class="page-link"><span class="pagger_info_text">' . esc_html__('Pages', 'seofy') . ': </span>', 'after' => '</div>'));

				if (has_tag() || (bool)$show_views || (bool)$show_share) {
					echo '<div class="post_info single_post_info">';

					if ( (bool)$show_views || (bool)$show_share) echo '<div class="blog-post_meta-wrap">';

					if(has_tag() && !(bool) $show_tags){
						echo "<div class='tagcloud-wrapper'>";
							the_tags('<div class="tagcloud">', ' ', '</div>');
						echo "</div>";						
					}

					if ( (bool)$show_views || (bool)$show_share)  echo '<div class="blog-post_info-wrap">';
						// Share in blog
						if ( (bool)$show_share ) : ?>              
								<?php
					                $single->render_post_list_share();
								?>
							<?php
						endif;

						// Views in blog
						if ( (bool)$show_views ) : ?>              
							<div class="blog-post_views-wrap">
							<?php
								$single->get_post_views(get_the_ID());
							?>
							</div>
							<?php
						endif;
					
					if ( (bool)$show_views || (bool)$show_share ): ?> 
                        </div>   
                        </div>   
                    	<?php
                	endif;
					echo "</div>";
				}else{
					echo "<div class='divider_post_info'></div>";
				}
				
				if ( (bool)$single_author_info ) {
					$single->render_author_info();
				} 
				?>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div>