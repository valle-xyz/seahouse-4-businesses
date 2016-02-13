<?php
if( ! defined('ABSPATH') ) die();




/**
 * Add an admin submenu link under Settings
 */
function s4b_add_options_submenu_page() {
		 add_submenu_page(
					'options-general.php',          // admin page slug
					__( 'Seahouse 4 Businesses Settings', 'wporg' ), // page title
					__( 'Business', 'wporg' ), 			// menu title
					'manage_options',               // capability required to see the page
					's4b_index',                // admin page slug, e.g. options-general.php?page=s4b_index
					's4b_index_page'            // callback function to display the options page
		 );
}
add_action( 'admin_menu', 's4b_add_options_submenu_page' );

/**
 * Register the settings
 */
function s4b_register_settings() {
		 register_setting(
					's4b_index',  // settings section
					's4b_organization' // setting name
		 );
}
add_action( 'admin_init', 's4b_register_settings' );

/**
 * Build the options page
 */
function s4b_index_page() {
	if ( ! isset( $_REQUEST['settings-updated'] ) )
					$_REQUEST['settings-updated'] = false; ?>

	<div class="wrap">

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
				 <div class="updated fade"><p><strong><?php _e( 'WPORG Options saved!', 'wporg' ); ?></strong></p></div>
		<?php endif; ?>

		<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
		Seahouse 4 Businesses lets you add your Business-Data to your site. Google & Co. will love it.


		<form method="post" action="options.php">
			<?php settings_fields( 's4b_index' ); ?>
			<?php $options = get_option( 's4b_organization' ); ?>
			<table class="form-table">
				<tr valign="top"><th scope="row"><?php _e( 'Hide the post meta information on posts?', 'wporg' ); ?></th>
					<td>
						<select name="s4b_organization[hide_meta]" id="hide-meta">
							<?php $selected = $options['hide_meta']; ?>
							<option value="1" <?php selected( $selected, 1 ); ?> >Yes, hide the post meta!</option>
							<option value="0" <?php selected( $selected, 0 ); ?> >No, show my post meta!</option>
						</select><br />
						<label class="description" for="s4b_organization[hide_meta]"><?php _e( 'Toggles whether or not to display post meta under posts.', 'wporg' ); ?></label>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Organization Name', 'wporg' ); ?></th>
					<td>
						<input type='text' name='s4b_organization[name]' value='<?php echo $options["name"]; ?>' /><br />
						<label class="description" for="s4b_organization[name]s"><?php _e( 'The Name of the Organization.', 'wporg' ); ?></label>
					</td>
				</tr>

			</table>
			<p class="submit">
				<input type="submit" value="Save settings" class="button-primary"/>
			</p>
		</form>

 </div>
<?php }
