<?php
// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
		exit();
}

// Delete all entries to database
delete_option( 's4b_organization' );
