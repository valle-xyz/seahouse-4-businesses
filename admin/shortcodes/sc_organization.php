<?php
if( ! defined('ABSPATH') ) die();

/*
 *  Registers shortcode to output organization data as JSON-LD
 */

function s4b_sc_organization() {
	// Shortcode: Load organization data into array and print array as json
	$options = get_option( 's4b_organization' );
	$payload["@context"] = "http://schema.org/";
	$options["@context"] = "http://schema.org/";

	$string = '<script type="application/ld+json">' . json_encode($options) . '</script>';
	return $string;
}

function s4b_sc_organization_register() {
	// register shortcode
	add_shortcode( 's4b-organization', 's4b_sc_organization' );
}
add_action( 'init', 's4b_sc_organization_register' );
