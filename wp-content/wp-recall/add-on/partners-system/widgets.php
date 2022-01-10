<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

add_action( 'widgets_init', 'widget_referal_stat' );
function widget_referal_stat() {
	register_widget( 'Widget_referal_stat' );
}

class Widget_referal_stat extends WP_Widget{

	function Widget_referal_stat() {
		$widget_ops = array( 'classname' => 'widget-referal-stat', 'description' => __('The last referrals','partners-system') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'widget-referal-stat' );
		parent::__construct( 'widget-referal-stat', __('The last referrals','partners-system'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		//Our variables from the widget settings.
		$title = apply_filters('widget_title', $instance['title'] );
		$size_referal = $instance['size_referal'];
		echo $before_widget;

		// Display the widget title

		global $wpdb;
		global $user_ID;
		if ($user_ID){
			$referals = $wpdb->get_results("SELECT * FROM ".PS_PREFIX."list_users WHERE author = '$user_ID' ORDER BY ID DESC LIMIT $size_referal");

			if ( $title )
					echo $before_title . $title . $after_title;

				echo '<div class="ref-link">'.__('Your affiliate link','partners-system').':<br />'.get_bloginfo('wpurl').'/?ref='.$user_ID.'</div>';

			if($referals){
				echo '<h4>'.__('The last referrals','partners-system').':</h4><div class="new-author-recall">';
				foreach($referals as $referal){
					echo '<div class="author-avatar-list"><a href="'.get_author_posts_url($referal->referal).'">'.get_avatar($referal->referal,50).'</a></div>';
				}
				echo '</div>
				<p align="right"><a href="'.get_permalink(get_option('refstat_page')).'">'.__('Complete statistics','partners-system').'</a></p>';

			}else{
				echo __('You have not invited anyone.','partners-system');
			}
		}
				echo $after_widget;
	}

	//Update the widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		//Strip tags from title and name to remove HTML
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['size_referal'] = $new_instance['size_referal'];
		return $instance;
	}

	function form( $instance ) {
		//Set up some default widget settings.
		$defaults = array( 'title' => __('The last referrals','partners-system').':','size_referal' => '5');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title','partners-system') ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('The number of referrals','partners-system') ?>:</label>
			<input id="<?php echo $this->get_field_id( 'size_referal' ); ?>" name="<?php echo $this->get_field_name( 'size_referal' ); ?>" value="<?php echo $instance['size_referal']; ?>" style="width:100%;" />
		</p>
	<?php
	}
}