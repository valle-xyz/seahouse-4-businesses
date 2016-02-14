<?php
if( ! defined('ABSPATH') ) die();

require_once('pages/organization.php'); // builds settings page


/**
 * Add an admin submenu link under Settings
 */
function s4b_add_options_submenu_page() {
	// adds the menu entry under Settings
	 add_submenu_page(
				'options-general.php',                             // admin page slug
				__( 'Seahouse 4 Businesses Settings', 'wporg' ),   // page title
				__( 'Business', 'wporg' ), 			                   // menu title
				'manage_options',                                  // capability required to see the page
				's4b_index',                                       // admin page slug, e.g. options-general.php?page=s4b_index
				's4b_index_page'                                   // callback function to display the options page
	 );
}
add_action( 'admin_menu', 's4b_add_options_submenu_page' );

function s4b_register_settings() {
	// registers the settings. WP saves registered settings as options automaticaly
		 register_setting(
					's4b_index',  // settings section
					's4b_organization' // setting name
		 );
}
add_action( 'admin_init', 's4b_register_settings' );
