<?php

class Banner extends WP_Widget
{
private $isMultilingual = FALSE; //Is this site multilingual?
    
    function __construct() 
    {
        parent::__construct(
            'combined_image_banner_widget', // Base ID
            esc_html__( 'WGL Banner', 'seofy' ), // Name
            array( 'description' => esc_html__( 'WGL Widget', 'seofy' ), ) // Args
        );

        //If WPML is active and was setup to have more than one language this website is multilingual.
        
        if ( is_admin() === TRUE ) {
            add_action('admin_enqueue_scripts', array($this, 'enqueue_backend_scripts') );
        }
    }


    public function enqueue_backend_scripts()
    {
        wp_enqueue_media(); //Enable the WP media uploader
        wp_enqueue_script('seofy-upload-img', get_template_directory_uri() . '/core/admin/js/img_upload.js', array('jquery'), false, true);
    }
    

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) 
    {
        
        $title_name = 'title';
        $text_name = 'text';
        $image_name = 'image';

        $image_name_2 = 'image_2';

        $attachment_id = attachment_url_to_postid ($instance[$image_name]);
        $alt = '';
        // if no alt attribute is filled out then echo "Featured Image of article: Article Name"
        if ('' === get_post_meta($attachment_id, '_wp_attachment_image_alt', true)) {
            $alt = the_title_attribute(array('before' => esc_html__('Featured image: ', 'seofy'), 'echo' => false));
        } else {
            $alt = trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true)));
        }

        $widgetImg = ( (isset($instance[$image_name])) && (!empty($instance[$image_name])) )? '<img class="banner-widget_img" src="' . esc_url($instance[$image_name]) . '" alt="'.esc_attr($alt).'">':'';
        $widgetImg_2 = ( (isset($instance[$image_name_2])) && (!empty($instance[$image_name_2])) )? 'background-image: url('.$instance[$image_name_2].');' : '';
        
        $title = ( (isset($instance[$title_name])) && (!empty($instance[$title_name])) )? $instance[$title_name]:FALSE; 
        $text = ( (isset($instance[$text_name])) && (!empty($instance[$text_name])) )? $instance[$text_name] : '';
        $button_link = ( (isset( $instance['button_link'])) && (!empty($instance['button_link'])) )? $instance['button_link'] : '';
        
        $widgetClasses = 'seofy_banner-widget';

        $widgetClasses.= ' widget seofy_widget';
        $html = '<div class="' . esc_attr($widgetClasses) . '" style="'.esc_attr($widgetImg_2).'">';
            if(!empty($widgetImg)){
               $html .= '<div class="banner-widget_img-wrapper">' . $widgetImg . '</div>'; 
            }
            
            if ( !empty($text) ) $html .= '<h5 class="banner-widget_text">' . Seofy_Theme_Helper::render_html($text) . '</h5>';

            if ( !empty($button_link) && !empty($title) ) $html.= '<a class="banner-widget_button" href="'.esc_url($button_link).'">'. esc_html($title).'</a>';

        $html.= '</div>';

        echo Seofy_Theme_Helper::render_html($html);
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {

        $title_name = 'title';
        $title = ( (isset($instance[$title_name])) && (!empty( $instance[$title_name])) )? $instance[$title_name] : '';
        
        $text_name = 'text';
        $text = ( (isset($instance[$text_name])) && (!empty($instance[$text_name])) )? $instance[$text_name] : '';       

        $image_name = 'image';
        $image = ( (isset($instance[$image_name])) && (!empty($instance[$image_name])) )? $instance[$image_name] : '';

        $image_name_2 = 'image_2';
        $image_2 = ( (isset($instance[$image_name_2])) && (!empty($instance[$image_name_2])) )? $instance[$image_name_2] : '';

        $button_link = ( (isset( $instance['button_link'])) && (!empty($instance['button_link'])) )? $instance['button_link'] : '';

        ?>

        <p>
          <label for="<?php echo esc_attr( $this->get_field_id($image_name) ); ?>"><?php echo esc_html__('Add Logotype image:', 'seofy')?></label><br />
            <img class="seofy_media_image" src="<?php if(!empty($instance[$image_name])){echo esc_url( $instance[$image_name] );} ?>" style="max-width: 100%" />
            <input type="text" class="widefat seofy_media_url" name="<?php echo esc_attr( $this->get_field_name($image_name) ); ?>" id="<?php echo esc_attr( $this->get_field_id($image_name) ); ?>" value="<?php echo esc_attr( $image ); ?>">
            <a href="#" class="button seofy_media_upload"><?php esc_html_e('Upload', 'seofy'); ?></a>
        </p>

        <p>
          <label for="<?php echo esc_attr( $this->get_field_id($image_name_2) ); ?>"><?php echo esc_html__('Add background image:', 'seofy')?></label><br />
            <img class="seofy_media_image" src="<?php if(!empty($instance[$image_name_2])){echo esc_url( $instance[$image_name_2] );} ?>" style="max-width: 100%" />
            <input type="text" class="widefat seofy_media_url" name="<?php echo esc_attr( $this->get_field_name($image_name_2) ); ?>" id="<?php echo esc_attr( $this->get_field_id($image_name_2) ); ?>" value="<?php echo esc_attr( $image_2 ); ?>">
            <a href="#" class="button seofy_media_upload"><?php esc_html_e('Upload', 'seofy'); ?></a>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( $text_name ) ); ?>"><?php echo esc_html__('Title:', 'seofy')?></label> 
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( $text_name ) ); ?>" name="<?php echo esc_attr(  $this->get_field_name( $text_name ) ); ?>" row="2"><?php echo Seofy_Theme_Helper::render_html($text); ?></textarea>
        </p>               

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( $title_name ) ); ?>"><?php echo esc_html__('Button title:', 'seofy')?></label> 
            <input class="widefat" id="<?php echo esc_attr(  $this->get_field_id( $title_name ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $title_name ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'button_link' ) ); ?>"><?php esc_html_e( 'Button link:', 'seofy' ); ?></label> 
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'button_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_link' ) ); ?>" type="text" value="<?php echo esc_attr( $button_link ); ?>">
        </p>
        <?php

    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) 
    {
        return $new_instance;
    }
}

function banner_register_widgets() {
    register_widget('banner');
}

add_action('widgets_init', 'banner_register_widgets');

?>