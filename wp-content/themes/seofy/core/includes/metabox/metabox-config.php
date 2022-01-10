<?php 


if (!class_exists( 'RWMB_Loader' )) {
	return;
}
class Seofy_Metaboxes{
	public function __construct(){
		//Team Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'team_meta_boxes' ) );

		//Portfolio Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'portfolio_meta_boxes' ) );
		add_filter( 'rwmb_meta_boxes', array( $this, 'portfolio_related_meta_boxes' ) );

		//Blog Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'blog_settings_meta_boxes' ) );
		add_filter( 'rwmb_meta_boxes', array( $this, 'blog_meta_boxes' ) );
		add_filter( 'rwmb_meta_boxes', array( $this, 'blog_related_meta_boxes' ));
		
		//Page Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'page_layout_meta_boxes' ) );
		//Colors Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'page_color_meta_boxes' ) );		
		//Logo Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'page_logo_meta_boxes' ) );		
		//Header Builder Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'page_header_meta_boxes' ) );
		//Title Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'page_title_meta_boxes' ) );
		//Footer Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'page_footer_meta_boxes' ) );				
		//Copyright Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'page_copyright_meta_boxes' ) );		
	}

	public function team_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Team Options', 'seofy' ),
	        'post_types' => array( 'team' ),
	        'context' => 'advanced',
	        'fields'     => array(
	        	array(
		            'name' => esc_html__( 'Info Name Department', 'seofy' ),
		            'id'   => 'department_name',
		            'type' => 'text',
		            'class' => 'name-field'
		        ),       
	        	array(
		            'name' => esc_html__( 'Member Department', 'seofy' ),
		            'id'   => 'department',
		            'type' => 'text',
		            'class' => 'field-inputs'
				),
				array(
					'name' => esc_html__( 'Member Info', 'seofy' ),
		            'id'   => 'info_items',
		            'type' => 'social',
		            'clone' => true,
		            'sort_clone'     => true,
		            'options' => array(
						'name'    => array(
							'name' => esc_html__( 'Name', 'seofy' ),
							'type_input' => 'text'
							),
						'description' => array(
							'name' => esc_html__( 'Description', 'seofy' ),
							'type_input' => 'text'
							),
						'link' => array(
							'name' => esc_html__( 'Link', 'seofy' ),
							'type_input' => 'text'
							),
					),
		        ),		
		        array(
					'name'     => esc_html__( 'Social Icons', 'seofy' ),
					'id'          => "soc_icon",
					'type'        => 'select_icon',
					'options'     => WglAdminIcon()->get_icons_name(),
					'clone' => true,
					'sort_clone'     => true,
					'placeholder' => esc_html__( 'Select an icon', 'seofy' ),
					'multiple'    => false,
					'std'         => 'default',
				),
		        array(
					'name'             => esc_html__( 'Info Background Image', 'seofy' ),
					'id'               => "mb_info_bg",
					'type'             => 'file_advanced',
					'max_file_uploads' => 1,
					'mime_type'        => 'image',
				),
	        ),
	    );
	    return $meta_boxes;
	}
	
	public function portfolio_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Portfolio Options', 'seofy' ),
	        'post_types' => array( 'portfolio' ),
	        'context' => 'advanced',
	        'fields'     => array(
	        	array(
					'id'   => 'mb_portfolio_featured_img',
					'name' => esc_html__( 'Show Featured image on single', 'seofy' ),
					'type' => 'switch',
					'std' => 'true',
				),        	
				array(
					'id'   => 'mb_portfolio_title',
					'name' => esc_html__( 'Show Title on single', 'seofy' ),
					'type' => 'switch',
					'std' => 'true',
				),
				array(
		            'name' => esc_html__( 'Custom Url for portfolio grid', 'seofy' ),
		            'id'   => 'portfolio_custom_url',
		            'type' => 'text',
		            'class' => 'field-inputs'
				),
				array(
		            'id'   => 'portfolio_custom_url_target',
					'name' => esc_html__( 'Open custom url in new window', 'seofy' ),
					'type' => 'switch',
					'std' => 'true',
				),
				array(
					'id'   => 'mb_portfolio_title',
					'name' => esc_html__( 'Show Title on single', 'seofy' ),
					'type' => 'switch',
					'std' => 'true',
				),
				array(
					'name' => esc_html__( 'Info', 'seofy' ),
		            'id'   => 'mb_portfolio_info_items',
		            'type' => 'social',
		            'clone' => true,
		            'sort_clone'     => true,
		            'desc' => esc_html__( 'Description', 'seofy' ),
		            'options' => array(
						'name'    => array(
							'name' => esc_html__( 'Name', 'seofy' ),
							'type_input' => 'text'
							),
						'description' => array(
							'name' => esc_html__( 'Description', 'seofy' ),
							'type_input' => 'text'
							),
						'link' => array(
							'name' => esc_html__( 'Url', 'seofy' ),
							'type_input' => 'text'
							),
					),
		        ),		
		        array(
					'name'     => esc_html__( 'Info Description', 'seofy' ),
					'id'          => "mb_portfolio_editor",
					'type'        => 'wysiwyg',
					'multiple'    => false,
					'desc' => esc_html__( 'Info description is shown in one row with a main info', 'seofy' ),
				),			
		        array(
					'name'     => esc_html__( 'Tags On/Off', 'seofy' ),
					'id'          => "mb_portfolio_above_content_cats",
					'type'        => 'button_group',
					'options'     => array(
						'default' => esc_html__( 'Default', 'seofy' ),
						'yes' => esc_html__( 'On', 'seofy' ),
						'no' => esc_html__( 'Off', 'seofy' ),
					),
					'multiple'    => false,
					'std'         => 'default',
				),		
		        array(
					'name'     => esc_html__( 'Share Links On/Off', 'seofy' ),
					'id'          => "mb_portfolio_above_content_share",
					'type'        => 'button_group',
					'options'     => array(
						'default' => esc_html__( 'Default', 'seofy' ),
						'yes' => esc_html__( 'On', 'seofy' ),
						'no' => esc_html__( 'Off', 'seofy' ),
					),
					'multiple'    => false,
					'std'         => 'default',
				),	
	        ),
	    );
	    return $meta_boxes;
	}

	public function portfolio_related_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Related Portfolio', 'seofy' ),
	        'post_types' => array( 'portfolio' ),
	        'context' => 'advanced',
	        'fields'     => array(
	        	array(
					'id'   => 'mb_pf_carousel_r',
					'name' => esc_html__( 'Display items carousel for this portfolio post', 'seofy' ),
					'type' => 'switch',
					'std'  => 1,
				),           	
				array(
					'id'   => 'mb_pf_show_r',
					'name' => esc_html__( 'Show related', 'seofy' ),
					'type' => 'switch',
					'std'  => 1,
				),
				array(
					'name' => esc_html__( 'Title', 'seofy' ),
					'id'   => "mb_pf_title_r",
					'type' => 'text',
					'std'  => 'Related Portfolio',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('mb_pf_show_r','=','1')
							),
						),
					),
				), 			
				array(
					'name' => esc_html__( 'Categories', 'seofy' ),
					'id'   => "mb_pf_cat_r",
					'multiple'    => true,
					'type' => 'taxonomy_advanced',
					'taxonomy' => 'portfolio-category',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('mb_pf_show_r','=','1')
							),
						),
					),
				),     
				array(
					'name'     => esc_html__( 'Columns', 'seofy' ),
					'id'          => "mb_pf_column_r",
					'type'        => 'button_group',
					'options'     => array(
						'def' => esc_html__( 'Default', 'seofy' ),
						'1' => esc_html__( '1', 'seofy' ),
						'2' => esc_html__( '2', 'seofy' ),
						'3' => esc_html__( '3', 'seofy' ),
						'4' => esc_html__( '4', 'seofy' ),
					),
					'multiple'    => false,
					'std'         => 'def',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('mb_pf_show_r','=','1')
							),
						),
					),
				),  
				array(
					'name' => esc_html__( 'Number of Related Items', 'seofy' ),
					'id'   => "mb_pf_number_r",
					'type' => 'number',
					'min'  => 0,
					'step' => 1,
					'std'  => 4,
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('mb_pf_show_r','=','1')
							),
						),
					),
				),
	        ),
	    );
	    return $meta_boxes;
	}

	public function blog_settings_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Post Settings', 'seofy' ),
	        'post_types' => array( 'post' ),
	        'context' => 'advanced',
	        'fields'     => array(
				array(
					'name'     => esc_html__( 'Post Layout', 'seofy' ),
					'id'          => "mb_post_layout_conditional",
					'type'        => 'button_group',
					'options'     => array(
						'default' => esc_html__( 'Default', 'seofy' ),
						'custom' => esc_html__( 'Custom', 'seofy' ),
					),
					'multiple'    => false,
					'std'         => 'default',
				),        
				array(
					'name'     => esc_html__( 'Post Layout Settings', 'seofy' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_post_layout_conditional','=','custom')
						)),
					),
				),  	    
				array(
					'name'     => esc_html__( 'Post Layout', 'seofy' ),
					'id'          => "mb_single_type_layout",
					'type'        => 'button_group',
					'options'     => array(
						'1' => esc_html__( 'Title First', 'seofy' ),
						'2' => esc_html__( 'Image First', 'seofy' ),
						'3' => esc_html__( 'Overlay Image', 'seofy' ),
					),
					'multiple'    => false,
					'std'         => '1',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('mb_post_layout_conditional','=','custom')
							),
						),
					),
				), 
				array(
					'name' => esc_html__( 'Spacing', 'seofy' ),
					'id'   => 'mb_single_padding_layout_3',
					'type' => 'wgl_offset',
					'options' => array(
						'mode'   => 'padding',
						'top'    => true,
						'right'  => false,
						'bottom' => true,
						'left'   => false,
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_post_layout_conditional','=','custom'),
							array('mb_single_type_layout','=','3'),
						)),
					),
					'std' => array(
						'padding-top' => '300',
						'padding-bottom' => '30'
					)
				),
				array(
					'id'   => 'mb_single_apply_animation',
					'name' => esc_html__( 'Apply Animation', 'seofy' ),
					'type' => 'switch',
					'std'  => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_post_layout_conditional','=','custom'),
							array('mb_single_type_layout','=','3'),
						)),
					),
				),
	        ),
	    );
	    return $meta_boxes;
	}

	public function blog_meta_boxes( $meta_boxes ) {
		$meta_boxes[] = array(
			'title'      => esc_html__( 'Post Format Layout', 'seofy' ),
			'post_types' => array( 'post' ),
			'context' => 'advanced',
			'fields'     => array(
				// Standard Post Format
				array(
					'name'             => esc_html__( 'Standard Post( Enabled only Featured Image for this post format)', 'seofy' ),
					'id'               => "post_format_standard",
					'type'             => 'static-text',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('formatdiv','=','0')
							),
						),
					),
				),
				// Gallery Post Format  
				array(
					'name'     => esc_html__( 'Gallery Settings', 'seofy' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('formatdiv','=','gallery')
						)),
					),
				),  
				array(
					'name'             => esc_html__( 'Add Images', 'seofy' ),
					'id'               => "post_format_gallery",
					'type'             => 'image_advanced',
					'max_file_uploads' => '',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('formatdiv','=','gallery')
							),
						),
					),
				),
				// Video Post Format
				array(
					'name'     => esc_html__( 'Video Settings', 'seofy' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('formatdiv','=','video')
						)),
					),
				), 
				array(
					'name' => esc_html__( 'Video Style', 'seofy' ),
					'id'   => "post_format_video_style",
					'type'        => 'select',
					'options'     => array(
						'bg_video' => esc_html__( 'Background Video', 'seofy' ),
						'popup' => esc_html__( 'Popup', 'seofy' ),
					),
					'multiple'    => false,
					'std'         => 'bg_video',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('formatdiv','=','video')
							),
						),
					),
				),	
				array(
					'name' => esc_html__( 'Start Video', 'seofy' ),
					'id'   => "start_video",
					'type' => 'number',
					'std'  => '0',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('formatdiv','=','video'),
								array('post_format_video_style','=','bg_video'),
							),
						),
					),
				),				
				array(
					'name' => esc_html__( 'End Video', 'seofy' ),
					'id'   => "end_video",
					'type' => 'number',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('formatdiv','=','video'),
								array('post_format_video_style','=','bg_video'),
							),
						),
					),
				),	
				array(
					'name' => esc_html__( 'oEmbed URL', 'seofy' ),
					'id'   => "post_format_video_url",
					'type' => 'oembed',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('formatdiv','=','video')
							),
							array(
								array('post_format_video_select','=','oEmbed')
							)
						),
					),
				),
				// Quote Post Format
				array(
					'name'     => esc_html__( 'Quote Settings', 'seofy' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('formatdiv','=','quote')
						)),
					),
				), 
				array(
					'name'             => esc_html__( 'Quote Text', 'seofy' ),
					'id'               => "post_format_qoute_text",
					'type'             => 'textarea',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('formatdiv','=','quote')
							),
						),
					),
				),
				array(
					'name'             => esc_html__( 'Author Name', 'seofy' ),
					'id'               => "post_format_qoute_name",
					'type'             => 'text',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('formatdiv','=','quote')
							),
						),
					),
				),			
				array(
					'name'             => esc_html__( 'Author Position', 'seofy' ),
					'id'               => "post_format_qoute_position",
					'type'             => 'text',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('formatdiv','=','quote')
							),
						),
					),
				),
				array(
					'name'             => esc_html__( 'Author Avatar', 'seofy' ),
					'id'               => "post_format_qoute_avatar",
					'type'             => 'image_advanced',
					'max_file_uploads' => 1,
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('formatdiv','=','quote')
							),
						),
					),
				),
				// Audio Post Format
				array(
					'name'     => esc_html__( 'Audio Settings', 'seofy' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('formatdiv','=','audio')
						)),
					),
				), 
				array(
					'name' => esc_html__( 'oEmbed URL', 'seofy' ),
					'id'   => "post_format_audio_url",
					'type' => 'oembed',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('formatdiv','=','audio')
							),
							array(
								array('post_format_audio_select','=','oEmbed')
							)
						),
					),
				),
				// Link Post Format
				array(
					'name'     => esc_html__( 'Link Settings', 'seofy' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('formatdiv','=','link')
						)),
					),
				), 
				array(
					'name'             => esc_html__( 'URL', 'seofy' ),
					'id'               => "post_format_link_url",
					'type'             => 'url',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('formatdiv','=','link')
							),
						),
					),
				),
				array(
					'name'             => esc_html__( 'Text', 'seofy' ),
					'id'               => "post_format_link_text",
					'type'             => 'text',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('formatdiv','=','link')
							),
						),
					),
				),
			)
		);
		return $meta_boxes;
	}

	public function blog_related_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Related Blog Post', 'seofy' ),
	        'post_types' => array( 'post' ),
	        'context' => 'advanced',
	        'fields'     => array(        	
				array(
					'id'   => 'mb_blog_show_r',
					'name' => esc_html__( 'Related On/Off', 'seofy' ),
					'type' => 'switch',
					'std'  => 1,
				),
				array(
					'name'     => esc_html__( 'Related Settings', 'seofy' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_blog_show_r','=','1')
						)),
					),
				), 
				array(
					'name' => esc_html__( 'Title', 'seofy' ),
					'id'   => "mb_blog_title_r",
					'type' => 'text',
					'std'  => 'Related Posts',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('mb_blog_show_r','=','1')
							),
						),
					),
				), 			
				array(
					'name' => esc_html__( 'Categories', 'seofy' ),
					'id'   => "mb_blog_cat_r",
					'multiple'    => true,
					'type' => 'taxonomy_advanced',
					'taxonomy' => 'category',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('mb_blog_show_r','=','1')
							),
						),
					),
				),     
				array(
					'name'     => esc_html__( 'Columns', 'seofy' ),
					'id'          => "mb_blog_column_r",
					'type'        => 'button_group',
					'options'     => array(
						'12' => esc_html__( '1', 'seofy' ),
						'6' => esc_html__( '2', 'seofy' ),
						'4' => esc_html__( '3', 'seofy' ),
						'3' => esc_html__( '4', 'seofy' ),
					),
					'multiple'    => false,
					'std'         => '6',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('mb_blog_show_r','=','1')
							),
						),
					),
				),  
				array(
					'name' => esc_html__( 'Number of Related Items', 'seofy' ),
					'id'   => "mb_blog_number_r",
					'type' => 'number',
					'min'  => 0,
					'step' => 1,
					'std'  => 2,
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('mb_blog_show_r','=','1')
							),
						),
					),
				),
	        	array(
					'id'   => 'mb_blog_carousel_r',
					'name' => esc_html__( 'Display items carousel for this blog post', 'seofy' ),
					'type' => 'switch',
					'std'  => 1,
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('mb_blog_show_r','=','1')
							),
						),
					),
				),  
	        ),
	    );
	    return $meta_boxes;
	}

	public function page_layout_meta_boxes( $meta_boxes ) {

	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Page Layout', 'seofy' ),
	        'post_types' => array( 'page' , 'post', 'team', 'practice','portfolio' ),
	        'context' => 'advanced',
	        'fields'     => array(
				array(
					'name'     => esc_html__( 'Page Sidebar Layout', 'seofy' ),
					'id'          => "mb_page_sidebar_layout",
					'type'        => 'wgl_image_select',
					'options'     => array(
						'default' => get_template_directory_uri() . '/core/admin/img/options/1c.png',
						'none'    => get_template_directory_uri() . '/core/admin/img/options/none.png',
						'left'    => get_template_directory_uri() . '/core/admin/img/options/2cl.png',
						'right'   => get_template_directory_uri() . '/core/admin/img/options/2cr.png',
					),
					'std'         => 'default',
				),
				array(
					'name'     => esc_html__( 'Sidebar Settings', 'seofy' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_sidebar_layout','!=','default'),
							array('mb_page_sidebar_layout','!=','none'),
						)),
					),
				),
				array(
					'name'     => esc_html__( 'Page Sidebar', 'seofy' ),
					'id'          => "mb_page_sidebar_def",
					'type'        => 'select',
					'placeholder' => 'Select a Sidebar',
					'options'     => seofy_get_all_sidebar(),
					'multiple'    => false,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_sidebar_layout','!=','default'),
							array('mb_page_sidebar_layout','!=','none'),
						)),
					),
				),			
				array(
					'name'     => esc_html__( 'Page Sidebar Width', 'seofy' ),
					'id'          => "mb_page_sidebar_def_width",
					'type'        => 'button_group',
					'options'     => array(	
						'9' => esc_html( '25%' ),
						'8' => esc_html( '33%' ),
					),
					'std'  => '9',
					'multiple'    => false,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_sidebar_layout','!=','default'),
							array('mb_page_sidebar_layout','!=','none'),
						)),
					),
				),
				array(
					'id'   => 'mb_sticky_sidebar',
					'name' => esc_html__( 'Sticky Sidebar On?', 'seofy' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_sidebar_layout','!=','default'),
							array('mb_page_sidebar_layout','!=','none'),
						)),
					),
				),
				array(
					'name'     => esc_html__( 'Sidebar Side Gap', 'seofy' ),
					'id'          => "mb_sidebar_gap",
					'type'        => 'select',
					'options'     => array(	
						'def' => 'Default',
	                    '0' => '0',     
	                    '15' => '15',     
	                    '20' => '20',     
	                    '25' => '25',     
	                    '30' => '30',     
	                    '35' => '35',     
	                    '40' => '40',     
	                    '45' => '45',     
	                    '50' => '50', 
					),
					'std'         => 'def',
					'multiple'    => false,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_sidebar_layout','!=','default'),
							array('mb_page_sidebar_layout','!=','none'),
						)),
					),
				),
	        )
	    );
	    return $meta_boxes;
	}

	public function page_color_meta_boxes( $meta_boxes ) {

	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Page Colors', 'seofy' ),
	        'post_types' => array( 'page' , 'post', 'team', 'practice','portfolio' ),
	        'context' => 'advanced',
	        'fields'     => array(
	        	array(
					'name'     => esc_html__( 'Page Colors', 'seofy' ),
					'id'          => "mb_page_colors_switch",
					'type'        => 'button_group',
					'options'     => array(
						'default' => esc_html__( 'Default', 'seofy' ),
						'custom' => esc_html__( 'Custom', 'seofy' ),
					),
					'inline'   		=> true,
					'multiple'    => false,
					'std'         => 'default',
				),
				array(
					'name'     => esc_html__( 'Colors Settings', 'seofy' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_colors_switch','=','custom')
						)),
					),
				),
				array(
					'name'     	=> esc_html__( 'General Theme Color', 'seofy' ),
	                'id'        => 'mb_theme-custom-color',
	                'type'      => 'color',
	                'std'         => '#ff7d00',
					'js_options' => array(
						'defaultColor' => '#ff7d00',
					),
	                'validate'  => 'color',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_colors_switch','=','custom'),
						)),
					),
	            ),				
	            array(
					'name'     	=> esc_html__( 'Secondary Theme Color', 'seofy' ),
	                'id'        => 'mb_second-custom-color',
	                'type'      => 'color',
	                'std'         => '#7c529c',
					'js_options' => array(
						'defaultColor' => '#7c529c',
					),
	                'validate'  => 'color',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_colors_switch','=','custom'),
						)),
					),
				),
				array(
					'name'     	=> esc_html__( 'Body Background Color', 'seofy' ),
	                'id'        => 'mb_body-background-color',
	                'type'      => 'color',
	                'std'         => '#ffffff',
					'js_options' => array(
						'defaultColor' => '#ffffff',
					),
	                'validate'  => 'color',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_colors_switch','=','custom'),
						)),
					),
	            ),
				array(
					'name'     => esc_html__( 'Gradient Settings', 'seofy' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_colors_switch','=','custom')
						)),
					),
				),
				array(
					'id'   => 'mb_use-gradient',
					'name' => esc_html__( 'Use Theme Gradient?', 'seofy' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_colors_switch','=','custom')
						)),
					),
				),
				array(
					'name'     	=> esc_html__( 'Theme Gradient From', 'seofy' ),
	                'id'        => 'mb_theme-gradient-from',
	                'type'      => 'color',
	                'std'         => '#ffc600',
					'js_options' => array(
						'defaultColor' => '#ffc600',
					),
	                'validate'  => 'color',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_use-gradient','=','1'),
						)),
					),
				),
				array(
					'name'     	=> esc_html__( 'Theme Gradient To', 'seofy' ),
	                'id'        => 'mb_theme-gradient-to',
	                'type'      => 'color',
	                'std'         => '#ff4200',
					'js_options' => array(
						'defaultColor' => '#ff4200',
					),
	                'validate'  => 'color',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_use-gradient','=','1'),
						)),
					),
				),
				array(
					'name'     	=> esc_html__( 'Second Gradient From', 'seofy' ),
	                'id'        => 'mb_second-gradient-from',
	                'type'      => 'color',
	                'std'         => '#5ad0ff',
					'js_options' => array(
						'defaultColor' => '#5ad0ff',
					),
	                'validate'  => 'color',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_use-gradient','=','1'),
						)),
					),
				),
				array(
					'name'     	=> esc_html__( 'Second Gradient To', 'seofy' ),
	                'id'        => 'mb_second-gradient-to',
	                'type'      => 'color',
	                'std'         => '#3224e9',
					'js_options' => array(
						'defaultColor' => '#3224e9',
					),
	                'validate'  => 'color',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_use-gradient','=','1'),
						)),
					),
				),
				array(
					'name'     => esc_html__( 'Scroll Up Settings', 'seofy' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_colors_switch','=','custom')
						)),
					),
				),
				array(
					'name'     	=> esc_html__( 'Button Background Color', 'seofy' ),
	                'id'        => 'mb_scroll_up_bg_color',
	                'type'      => 'color',
	                'std'         => '#c10e0e',
					'js_options' => array(
						'defaultColor' => '#c10e0e',
					),
	                'validate'  => 'color',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_colors_switch','=','custom'),
						)),
					),
	            ),				
	            array(
					'name'     	=> esc_html__( 'Button Arrow Color', 'seofy' ),
	                'id'        => 'mb_scroll_up_arrow_color',
	                'type'      => 'color',
	                'std'         => '#ffffff',
					'js_options' => array(
						'defaultColor' => '#ffffff',
					),
	                'validate'  => 'color',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_colors_switch','=','custom'),
						)),
					),
	            ),
	        )
	    );
	    return $meta_boxes;
	}

	public function page_logo_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Logo', 'seofy' ),
	        'post_types' => array( 'page' ),
	        'context' => 'advanced',
	        'fields'     => array(
	        	array(
					'name'     => esc_html__( 'Logo', 'seofy' ),
					'id'          => "mb_customize_logo",
					'type'        => 'button_group',
					'options'     => array(
						'default' => esc_html__( 'Default', 'seofy' ),
						'custom' => esc_html__( 'Custom', 'seofy' ),
					),
					'multiple'    => false,
					'inline'    => true,
					'std'         => 'default',
				),
				array(
					'name'     => esc_html__( 'Logo Settings', 'seofy' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_logo','=','custom')
						)),
					),
				),
				array(
					'name'             => esc_html__( 'Header Logo', 'seofy' ),
					'id'               => "mb_header_logo",
					'type'             => 'image_advanced',
					'max_file_uploads' => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_logo','=','custom')
						)),
					),
				),
				array(
					'id'   => 'mb_logo_height_custom',
					'name' => esc_html__( 'Enable Logo Height', 'seofy' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
					    	array('mb_customize_logo','=','custom')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Set Logo Height', 'seofy' ),
					'id'   => "mb_logo_height",
					'type' => 'number',
					'min'  => 0,
					'step' => 1,
					'std'  => 50,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_logo','=','custom'),
							array('mb_logo_height_custom','=',true)
						)),
					),
				),
				array(
					'name'             => esc_html__( 'Sticky Logo', 'seofy' ),
					'id'               => "mb_logo_sticky",
					'type'             => 'image_advanced',
					'max_file_uploads' => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_logo','=','custom')
						)),
					),
				),
				array(
					'id'   => 'mb_sticky_logo_height_custom',
					'name' => esc_html__( 'Enable Sticky Logo Height', 'seofy' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
					    	array('mb_customize_logo','=','custom')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Set Sticky Logo Height', 'seofy' ),
					'id'   => "mb_sticky_logo_height",
					'type' => 'number',
					'min'  => 0,
					'step' => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_logo','=','custom'),
							array('mb_sticky_logo_height_custom','=',true),
						)),
					),
				),
				array(
					'name'             => esc_html__( 'Mobile Logo', 'seofy' ),
					'id'               => "mb_logo_mobile",
					'type'             => 'image_advanced',
					'max_file_uploads' => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_logo','=','custom')
						)),
					),
				),
				array(
					'id'   => 'mb_mobile_logo_height_custom',
					'name' => esc_html__( 'Enable Mobile Logo Height', 'seofy' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
					    	array('mb_customize_logo','=','custom')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Set Mobile Logo Height', 'seofy' ),
					'id'   => "mb_mobile_logo_height",
					'type' => 'number',
					'min'  => 0,
					'step' => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_logo','=','custom'),
							array('mb_mobile_logo_height_custom','=',true),
						)),
					),
				),
	        )
	    );
	    return $meta_boxes;
	}

	public function page_header_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Header', 'seofy' ),
	        'post_types' => array( 'page' ),
	        'context' => 'advanced',
	        'fields'     => array(
	        	array(
					'name'     => esc_html__( 'Header Settings', 'seofy' ),
					'id'          => "mb_customize_header_layout",
					'type'        => 'button_group',
					'options'     => array(
						'default' => esc_html__( 'default', 'seofy' ),
						'custom' => esc_html__( 'custom', 'seofy' ),
						'hide' => esc_html__( 'hide', 'seofy' ),
					),
					'multiple'    => false,
					'std'         => 'default',
				),
	        	array(
					'name'     => esc_html__( 'Header Builder', 'seofy' ),
					'id'          => "mb_customize_header",
					'type'        => 'select',
					'options'     => seofy_get_custom_preset(),
					'multiple'    => false,
					'std'         => 'default',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_header_layout','!=','hide')
						)),
					),
				),			
				// It is works 
				array(
					'id'   => 'mb_menu_header',
					'name' => esc_html__( 'Menu ', 'seofy' ),
					'type' => 'select',
					'options'     => seofy_get_custom_menu(),
					'multiple'    => false,
					'std'         => 'default',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_header_layout','=','custom')
						)),
					),
				),
				array(
					'id'   => 'mb_header_sticky',
					'name' => esc_html__( 'Sticky Header', 'seofy' ),
					'type' => 'switch',
					'std'  => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_header_layout','=','custom')
						)),
					),
				),
	        )
	    );
	    return $meta_boxes;
	}

	public function page_title_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Page Title', 'seofy' ),
	        'post_types' => array( 'page', 'post', 'team', 'practice','portfolio' ),
	        'context' => 'advanced',
	        'fields'     => array(
				array(
					'id'       => 'mb_page_title_switch',
					'name'     => esc_html__( 'Page Title', 'seofy' ),
					'type'     => 'button_group',
					'options'  => array(
						'default' => esc_html__( 'Default', 'seofy' ),
						'on' => esc_html__( 'On', 'seofy' ),
						'off' => esc_html__( 'Off', 'seofy' ),
					),
					'inline'   => true,
					'multiple' => false,
					'std'      => 'default'
				),
				array(
					'name'     => esc_html__( 'Page Title Settings', 'seofy' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on')
						)),
					),
				),
				array(
					'name'             => esc_html__( 'Background', 'seofy' ),
					'id'               => "mb_page_title_bg",
					'type'             => 'wgl_background',	
					'color'      	   => '#f4f6fd',
				    'image'     	   => '',
				    'position'   	   => 'center center',
				    'attachment' 	   => 'scroll',
				    'size'       	   => 'cover',
				    'repeat'     	   => 'no-repeat',			
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on')
						)),
					),
				),			
				array( 
					'name' => esc_html__( 'Height', 'seofy' ),
					'id'   => 'mb_page_title_height',
					'type' => 'number',
					'std'  => 220,
					'min'  => 0,
					'step' => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on')
						)),
					),
				),
				array(
					'name'     => esc_html__( 'Text Align', 'seofy' ),
					'id'       => 'mb_page_title_align',
					'type'     => 'button_group',
					'options'  => array(
						'left' => esc_html__( 'left', 'seofy' ),
						'center' => esc_html__( 'center', 'seofy' ),
						'right' => esc_html__( 'right', 'seofy' ),
					),
					'multiple' => false,
					'std'         => 'center',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Padding Top/Bottom', 'seofy' ),
					'id'   => 'mb_page_title_padding',
					'type' => 'wgl_offset',
					'options' => array(
						'mode'   => 'padding',
						'top'    => true,
						'right'  => false,
						'bottom' => true,
						'left'   => false,
					),
					'std' => array(
						'padding-top'    => '0',
						'padding-bottom' => '0',
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Margin Bottom', 'seofy' ),
					'id'   => "mb_page_title_margin",
					'type' => 'wgl_offset',
					'options' => array(
						'mode'   => 'margin',
						'top'    => false,
						'right'  => false,
						'bottom' => true,
						'left'   => false,
					),
					'std' => array(
						'margin-bottom' => '50',
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on')
						)),
					),
				),
				array(
					'id'   => 'mb_page_title_parallax',
					'name' => esc_html__( 'Add Page Title Parallax', 'seofy' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Prallax Speed', 'seofy' ),
					'id'   => "mb_page_title_parallax_speed",
					'type' => 'number',
					'std'  => 0.3,
					'step' => 0.1,
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(
							array('mb_page_title_parallax','=',true),
							array('mb_page_title_switch','=','on'),
						)),
					),
				),
				array(
					'id'   => 'mb_page_change_tile_switch',
					'name' => esc_html__( 'Custom Page Title', 'seofy' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on')
						)),
					),
				),		
				array(
		            'name' => esc_html__( 'Page Title', 'seofy' ),
		            'id'   => 'mb_page_change_tile',
		            'type' => 'text',
		            'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
					    	array('mb_page_change_tile_switch','=',1),
							array('mb_page_title_switch','=','on'),
						)),
					),
		        ),		
				array(
					'id'   => 'mb_page_title_breadcrumbs_switch',
					'name' => esc_html__( 'Breadcrumbs On/Off', 'seofy' ),
					'type' => 'switch',
					'std'  => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on')
						)),
					),
				),
				array(
					'id'   => 'mb_page_title_extended_anim',
					'name' => esc_html__( 'Extended Animation On/Off', 'seofy' ),
					'type' => 'switch',
					'std'  => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on')
						)),
					),
				),
				array(
					'name'     	=> esc_html__( 'Animation Color 1', 'seofy' ),
	                'id'        => 'mb_page_title_extended_color_1',
	                'type'      => 'color',
	                'std'         => '#ff7e00',
					'js_options' => array(
						'defaultColor' => '#ff7e00',
					),
	                'validate'  => 'color',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_extended_anim','=',true),
							array('mb_page_title_switch','=','on'),
						)),
					),
	            ),
				array(
					'name'     	=> esc_html__( 'Animation Color 2', 'seofy' ),
	                'id'        => 'mb_page_title_extended_color_2',
	                'type'      => 'color',
	                'std'         => '#3224e9',
					'js_options' => array(
						'defaultColor' => '#3224e9',
					),
	                'validate'  => 'color',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_extended_anim','=',true),
							array('mb_page_title_switch','=','on'),
						)),
					),
	            ),
				array(
					'name'     	=> esc_html__( 'Animation Color 3', 'seofy' ),
	                'id'        => 'mb_page_title_extended_color_3',
	                'type'      => 'color',
	                'std'         => '#69e9f2',
					'js_options' => array(
						'defaultColor' => '#69e9f2',
					),
	                'validate'  => 'color',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_extended_anim','=',true),
							array('mb_page_title_switch','=','on'),
						)),
					),
	            ),
				array(
					'name'     => esc_html__( 'Page Title Typography', 'seofy' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Page Title Font', 'seofy' ),
					'id'   => 'mb_page_title_font',
					'type' => 'wgl_font',
					'options' => array(
						'font-size' => true,
						'line-height' => true,
						'font-weight' => false,
						'color' => true,
					),
					'std' => array(
						'font-size' => '42',
						'line-height' => '54',
						'color' => '#252525',
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Page Title Breadcrumbs Font', 'seofy' ),
					'id'   => 'mb_page_title_breadcrumbs_font',
					'type' => 'wgl_font',
					'options' => array(
						'font-size' => true,
						'line-height' => true,
						'font-weight' => false,
						'color' => true,
					),
					'std' => array(
						'font-size' => '16',
						'line-height' => '34',
						'color' => '#252525',
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on')
						)),
					),
				),
	        ),
	    );
	    return $meta_boxes;
	}

	public function page_footer_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Footer', 'seofy' ),
	        'post_types' => array( 'page' ),
	        'context' => 'advanced',
	        'fields'     => array(
	        	array(
					'name'     => esc_html__( 'Footer', 'seofy' ),
					'id'          => "mb_footer_switch",
					'type'        => 'button_group',
					'options'     => array(
						'default' => esc_html__( 'Default', 'seofy' ),
						'on' => esc_html__( 'On', 'seofy' ),
						'off' => esc_html__( 'Off', 'seofy' ),
					),
					'multiple'    => false,
					'std'         => 'default',
				),
				array(
					'name'     => esc_html__( 'Footer Settings', 'seofy' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_footer_switch','=','on')
						)),
					),
				), 
				array(
					'id'   => 'mb_footer_add_mountain',
					'name' => esc_html__( 'Add Mountain', 'seofy' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_footer_switch','=','on')
						)),
					),
				),
				array(
					'name'     => esc_html__( 'Content Type', 'seofy' ),
					'id'          => 'mb_footer_content_type',
					'type'        => 'button_group',
					'options'     => array(
						'widgets' => esc_html__( 'Default', 'seofy' ),
						'pages' => esc_html__( 'Page', 'seofy' )		
					),
					'multiple'    => false,
					'std'         => 'widgets',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_footer_switch','=','on')
						)),
					),
				),
				array(
	        		'name'        => 'Select a page',
					'id'          => 'mb_footer_page_select',
					'type'        => 'post',
					'post_type'   => 'footer',
					'field_type'  => 'select_advanced',
					'placeholder' => 'Select a page',
					'query_args'  => array(
					    'post_status'    => 'publish',
					    'posts_per_page' => - 1,
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_footer_switch','=','on'),
							array('mb_footer_content_type','=','pages')
						)),
					),
	        	),
				array(
					'name' => esc_html__( 'Paddings', 'seofy' ),
					'id'   => 'mb_footer_spacing',
					'type' => 'wgl_offset',
					'options' => array(
						'mode'   => 'padding',
						'top'    => true,
						'right'  => true,
						'bottom' => true,
						'left'   => true,
					),
					'std' => array(
						'padding-top'    => '84',
						'padding-right'  => '0',
						'padding-bottom' => '48',
						'padding-left'   => '0'
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_footer_switch','=','on')
						)),
					),
				),	
				array(
					'name'             => esc_html__( 'Background', 'seofy' ),
					'id'               => "mb_footer_bg",
					'type'             => 'wgl_background',	
					'color'      	   => '#040c5e',
				    'image'     	   => '',
				    'position'   	   => 'center center',
				    'attachment' 	   => 'scroll',
				    'size'       	   => 'cover',
				    'repeat'     	   => 'no-repeat',			
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_footer_switch','=','on')
						)),
					),
				),				
	        ),
	     );
	    return $meta_boxes;
	}	

	public function page_copyright_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Copyright', 'seofy' ),
	        'post_types' => array( 'page' ),
	        'context' => 'advanced',
	        'fields'     => array(
				array(
					'name'     => esc_html__( 'Copyright', 'seofy' ),
					'id'          => "mb_copyright_switch",
					'type'        => 'button_group',
					'options'     => array(
						'default' => esc_html__( 'Default', 'seofy' ),
						'on' => esc_html__( 'On', 'seofy' ),
						'off' => esc_html__( 'Off', 'seofy' ),
					),
					'multiple'    => false,
					'std'         => 'default',
				),
				array(
					'name'     => esc_html__( 'Copyright Settings', 'seofy' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_copyright_switch','=','on')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Editor', 'seofy' ),
					'id'   => "mb_copyright_editor",
					'type' => 'textarea',
					'cols' => 20,
					'rows' => 3,
					'std'  => 'Copyright © 2018 Seofy by WebGeniusLab. All Rights Reserved',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(						
							array('mb_copyright_switch','=','on')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Text Color', 'seofy' ),
					'id'   => "mb_copyright_text_color",
					'type' => 'color',
					'std'  => '#ffffff',
					'js_options' => array(
						'defaultColor' => '#ffffff',
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(						
							array('mb_copyright_switch','=','on')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Background Color', 'seofy' ),
					'id'   => "mb_copyright_bg_color",
					'type' => 'color',
					'std'  => '#040c5e',
					'js_options' => array(
						'defaultColor' => '#1d1f21',
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(						
							array('mb_copyright_switch','=','on')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Paddings', 'seofy' ),
					'id'   => 'mb_copyright_spacing',
					'type' => 'wgl_offset',
					'options' => array(
						'mode'   => 'padding',
						'top'    => true,
						'right'  => false,
						'bottom' => true,
						'left'   => false,
					),
					'std' => array(
						'padding-top'    => '15',
						'padding-bottom' => '15',
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_copyright_switch','=','on')
						)),
					),
				),
	        ),
	     );
	    return $meta_boxes;

	}

}
new Seofy_Metaboxes();

?>