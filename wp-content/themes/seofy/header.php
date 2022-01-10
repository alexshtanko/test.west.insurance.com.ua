<?php
 if(!is_user_logged_in()) {
  auth_redirect();
 }

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="main">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Seofy
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="shortcut icon" href="<?php echo bloginfo('template_url'); ?>/img/favicon.png" type="image/x-icon">
    <link rel="pingback" href="<?php esc_url(bloginfo('pingback_url')); ?>">
    <?php 
        wp_head(); 
    ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-145769775-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-145769775-1');
      gtag('config', 'AW-795453491');
	</script>

	<!-- Facebook Pixel Code -->
	<script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '3023460801051928');
        fbq('track', 'PageView');
	</script>
	<noscript><img height="1" width="1" style="display:none"
	               src="https://www.facebook.com/tr?id=3023460801051928&ev=PageView&noscript=1"
		/></noscript>
	<!-- End Facebook Pixel Code -->

</head>

<body <?php body_class(); ?>>
    <?php 
        Seofy_Theme_Helper::preloader();
        get_template_part('templates/header/section','header');
        get_template_part('templates/header/section','page_title');
        
    ?>


    <?php

        //Add ling to manager page
        $user = wp_get_current_user();
        $allowed_roles = array('user_manager', 'administrator');

        if( array_intersect( $allowed_roles, $user->roles ) ) : ?>

<!--        <div class="go-to-manager-page-wrapper">-->
<!--            <div class="wgl-container">-->
<!--                <div class="row">-->
<!--                    <div class="wgl_col-12">-->
<!--                        <a class="go-to-manager-page" href="/get-policy-m">Менеджеру</a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    <?php endif; ?>
    <main id="main">