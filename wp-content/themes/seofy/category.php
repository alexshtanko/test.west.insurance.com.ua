<?php
get_header();

$term_id = isset(get_queried_object()->term_id) ? get_queried_object()->term_id : '';
$term_id = !empty($term_id) ? $term_id : '';

$cat_title = $cat_descr = '';
if(!empty($term_id)){
    $cat = get_term_by( 'id', (int) $term_id, 'category' );
    $cat_title = $cat->name;
    $cat_descr = $cat->description;
}

$sb = Seofy_Theme_Helper::render_sidebars('blog_list');
$row_class = $sb['row_class'];
$column = $sb['column'];

?>
    <div class="wgl-container">
        <div class="row<?php echo apply_filters('seofy_row_class', $row_class); ?>">
            <div id='main-content' class="wgl_col-<?php echo apply_filters('seofy_column_class', $column); ?>">
                <?php
                if(!empty($term_id)){
                    echo '<div class="blog_archive-cat">';
                        echo '<h4 class="blog_archive-cat_title">'.esc_html__('Category:','seofy-core').' '.esc_html($cat_title).'</h4>';
                        echo '<div class="blog_archive-cat_descr">'.esc_html($cat_descr).'</div>';
                    echo '</div>';
                }
                // List of Post
                get_template_part('templates/post/posts-list');
                // Pagination
                echo Seofy_Theme_Helper::pagination();
                ?>
            </div>
            <?php
                echo (isset($sb['content']) && !empty($sb['content']) ) ? $sb['content'] : '';
            ?>
        </div>
    </div>
    
<?php get_footer(); ?>