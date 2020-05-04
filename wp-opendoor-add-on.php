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

$fields_text = array(
    (object) [
        'id' => 'price_value',
        'label' => 'Price (How much is this property?)'
    ],
    (object) [
        'id' => 'pricecustom_value',
        'label' => 'Custom price text (Example: "As low as $200,000")',
    ],
    (object) [
        'id' => 'reducedby_value',
        'label' => 'Price reduction (optional)'
    ],
    (object) [
        'id' => 'address_value',
        'label' => 'Address for the listing',
        'hint' => 'For example, 1223 Main Street. Note: This is for display, and Google Maps use only, NOT for use in the search.',
    ],
    (object) [
        'id' => 'mls_value',
        'label' => 'MLS number (required only if \'mlslisting_value\' is Yes)',
    ],
    (object) [
        'id' => 'openhousedate_value',
        'label' => 'Open House Date (Required if this is searchable)',
        'hint' => 'If this property has an upcoming Open House, enter the date. For example: \'July 12, 2013\'. The theme will automatically disable any reference to the open house when the date expires.',
    ],
    (object) [
        'id' => 'openhousetime_value',
        'label' => 'Open House Time',
        'hint' => 'If the property has an upcoming Open House, enter the time range. For example: \'1-4pm\'',
    ],
    (object) [
        'id' => 'beds_value',
        'label' => 'Bedrooms (Required if this is searchable)',
        'hint' => 'How many bedrooms does this property have? This is used when visitors search by number of bedrooms.',
    ],
    (object) [
        'id' => 'baths_value',
        'label' => 'Bathrooms (Required if this is searchable)',
        'hint' => 'How many bathrooms does this property have? This is used when visitors search by number of bathrooms.',
    ],
    (object) [
        'id' => 'size_value',
        'label' => 'Size (Required if this is searchable)',
        'hint' => 'The home/building size. Only number, no commas or text. For example: 5500. This represents the number of square feet, acres, etc, as determined as your setting in Theme Options.',
    ],
    (object) [
        'id' => 'lotsize_value',
        'label' => 'Lot Size (Required if this is searchable)',
        'hint' => 'The full lot size. Only a number, no comma or text. For example: 13500. This represents the number of square feet, acres, etc, as determined as your setting in Theme Options.',
    ],
    (object) [
        'id' => 'garage_value',
        'label' => 'Number of garage spaces (optional)'
    ],
    (object) [
        'id' => 'date_value',
        'label' => 'Date Available (format: July 12, 2013)'
    ],
    (object) [
        'id' => 'year_value',
        'label' => 'Year built (e.g. 1980) (Required if this is searchable)'
    ],
    (object) [
        'id' => 'school_value',
        'label' => 'School district (optional)'
    ],
    (object) [
        'id' => 'google_location_value',
        'label' => 'Google Maps Location (optional)',
        'hint' => 'By default the Google Map for each listing uses the address, city, state, and Zip, as entered above. If you enter an address here, the Google map will use this info instead of the info entered above.',
    ],
    (object) [
        'id' => 'title_value',
        'label' => 'Custom Slideshow Title (optional)',
        'hint' => 'By default the slideshow title will pull in the text from the post Title. You can override that text by entering custom text here.',
    ],
    (object) [
        'id' => 'email_value',
        'label' => 'Agent\'s email address (optional)'
    ],
    (object) [
        'id' => 'phoneoffice_value',
        'label' => 'Agent\'s office number (optional)'
    ],
    (object) [
        'id' => 'phonemobile_value',
        'label' => 'Agent\'s mobile number (optional)'
    ],
    (object) [
        'id' => 'fax_value',
        'label' => 'Agent\'s fax number (definitely optional)'
    ]
);

foreach ( $fields_text as $field ) {
    $open_door_theme_addon->add_field($field->id, $field->label, 'text', null, property_exists($field, 'hint') ? $field->hint : null);
}

// $open_door_theme_addon->add_field('address_value', 'Address', 'text', null, 'Address for the listing');

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
