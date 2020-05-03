<?php

/*
Plugin Name: WP All Import Open Door Theme Add-On
Description: An add-on for importing properties into Open Door WordPress theme
Version: 1.0
Author: Max Kovalenkov
*/
if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

include "rapid-addon.php";

$open_door_theme_addon = new RapidAddon('Open Door Theme Add-On', 'open_door_theme_addon');

$open_door_theme_addon->add_field('address_value', 'Address', 'text', null, 'Address for the listing');

$open_door_theme_addon->set_import_function('open_door_theme_addon_import');

$theme_name = 'OpenDoor';
// can also use wp_get_theme to test for theme name:
// $theme = wp_get_theme();
// if ( $theme_name == $theme->name || $theme_name == $theme->parent_theme ) {}

if (function_exists('is_plugin_active') && function_exists('get_option')) {

	if ( get_option( 'template' ) != ($theme_name . '1.4') ) {

		$open_door_theme_addon->admin_notice(
			'Open Door Theme Add-On requires the Open Door 1.4 theme to be active.'
		);
	}

	// only run if WP All Import is active
	if ( is_plugin_active('wp-all-import-pro/wp-all-import-pro.php') || is_plugin_active('wp-all-import/plugin.php') ) {
		// only run this add-on if importing listings into Open Door theme
		$open_door_theme_addon->run(
            array(
                "post_types" => array( "listing" ),
                "themes" => array( "OpenDoor" ),
            )
        );
	}
}

function open_door_theme_addon_import($post_id, $data, $import_options) {

	global $open_door_theme_addon;
    // error_log('foobar updating address:');
    // error_log(print_r($data, true));
	if ($open_door_theme_addon->can_update_meta('address_value', $import_options)) {
        update_post_meta($post_id, 'address_value', $data['address_value']);
        $open_door_theme_addon->log( '- Adding address_value, post ID: ' . $post_id );
	}


}
