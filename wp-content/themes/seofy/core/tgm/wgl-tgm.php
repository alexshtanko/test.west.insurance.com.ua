<?php

require_once get_template_directory() . '/core/tgm/class-tgm-plugin-activation.php'; 

add_action('tgmpa_register', 'seofy_register_required_plugins');
function seofy_register_required_plugins()
{

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
        array(
            'name'               => esc_html__('Seofy Core', 'seofy' ), // The plugin name.
            'slug'               => 'seofy-core', // The plugin slug (typically the folder name).
            'source'             => get_template_directory() . '/core/tgm/plugins/seofy-core.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '1.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
        ),
        array(
            'name'          => esc_html__('WPBakery Visual Composer', 'seofy' ), // The plugin name
            'slug'          => 'js_composer', // The plugin slug (typically the folder name)
            'source'            => get_template_directory() . '/core/tgm/plugins/js_composer.zip', // The plugin source
            'required'          => true, // If false, the plugin is only 'recommended' instead of required
            'version'           => '5.7', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwize a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
        ),
        array(
            'name'               => esc_html__('Contact Form 7', 'seofy' ),
            'slug'               => 'contact-form-7',
            'required'           => false,
        ),
        array(
            'name'          => esc_html__('Revolution Slider', 'seofy' ), // The plugin name
            'slug'          => 'revslider', // The plugin slug (typically the folder name)
            'source'            => get_template_directory() . '/core/tgm/plugins/revslider.zip', // The plugin source
            'required'          => false, // If false, the plugin is only 'recommended' instead of required
            'version'           => '5.4.8.3', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
        ),
        array(
            'name'                      => esc_html__('WooCommerce','seofy'), // The plugin name
            'slug'                      => 'woocommerce', // The plugin slug (typically the folder name)
            'required'              => false, // If false, the plugin is only 'recommended' instead of required
        ),  
    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                       // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins',  // Menu slug.
        'has_notices'  => true,                     // Show admin notices or not.
        'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                       // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                     // Automatically activate plugins after installation or not.
        'message'      => '',                       // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => esc_html__( 'Install Required Plugins', 'seofy' ),
            'menu_title'                      => esc_html__( 'Install Plugins', 'seofy' ),
            'installing'                      => esc_html__( 'Installing Plugin: %s', 'seofy' ), // %s = plugin name.
            'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'seofy' ),
            'notice_can_install_required'     => esc_html__( 'This theme requires the following plugins: %1$s.', 'seofy' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => esc_html__( 'This theme recommends the following plugins: %1$s.', 'seofy' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => esc_html__( 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'seofy' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => esc_html__( 'The following required plugins are currently inactive: %1$s.', 'seofy' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => esc_html__( 'The following recommended plugins are currently inactive: %1$s.', 'seofy' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => esc_html__( 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'seofy' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => esc_html__( 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'seofy' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => esc_html__( 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'seofy' ), // %1$s = plugin name(s).
            'install_link'                    => esc_html__( 'Begin installing plugins', 'seofy' ),
            'activate_link'                   => esc_html__( 'Begin activating plugins', 'seofy' ),
            'return'                          => esc_html__( 'Return to Required Plugins Installer', 'seofy' ),
            'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'seofy' ),
            'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'seofy' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}