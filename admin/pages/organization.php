<?php
if( ! defined('ABSPATH') ) die();

/**
 * Build the actual settings page
 */
function s4b_organization_requirements() {
	// registers required data. used to generate form fields
	// @fields array $args {
	//    Field.
	//
	//    @string name            // intern key of option, should be same as Knowledge Graph property, functions as input name
	//    @string title           // labels the field
	//    @string description     // Explains user what to write gets i18s through __(), in english
	//   -- or:
	//    @string @type           // if @type is set, sub fields will also be generated
	//    @string fields          // contains an array with subfields
	//    @string title Optional  // if available prints out title for subfields
	// }
	$payload = array(
		array(
			'name'        => '@id',
			'title'       => 'Organization ID',
			'description' => 'Should be a unique URL. One per department.',
		),
		array(
			'name'        => 'name',
			'title'       => 'Organization Name',
			'description' => 'The Name of the Organization.',
		),
		array(
			'name'        => 'address',
			'title'       => 'Address',
			'@type'       => 'PostalAddress',
			'fields'      => array(
				array(
					'name'        => 'streetAddress',
					'title'       => 'Street',
					'description' => 'The Street of the Organization.',
				),
			),
		),
	);

	return $payload;
}
function s4b_generate_form_field($field, $values, $parent = 's4b_organization[%s]') {
	// generates form field
	// @param field: array, the required data
	// @param values: array, the options with previous values
	// @param parent defines which field this is subfield of

	if ( !$field ) return;

	if ( array_key_exists( 'fields', $field ) ) {
		// Field has subfields, that get generated seperatly
		$payload = '';
		$payload .= array_key_exists( 'title', $field ) ? '<tr valign="top"><th scope="row">' . $field['title'] . '</th>' : '';
		$fields = $field['fields'];
		$values = $values[$field['name']];
		$parent = sprintf($parent, $field['name']) . '[%s]';
		$payload .= s4b_generate_multiple_form_fields($fields, $values, $parent);
		return $payload;
	} else {
		// Generates single field
		$options_index = sprintf($parent, $field['name']);
		$value =         $values[$field['name']];
		$title =         __( $field['title'], 'wporg' );
		$description =   __( $field['description'], 'wporg' );

		$payload = <<<FIELD
			<tr valign="top"><th scope="row">{$title}</th>
				<td>
					<input type="text" name="{$options_index}" value="{$value}" /><br />
					<label class="description" for="{$options_index}">{$description}</label>
				</td>
			</tr>
FIELD;
		return $payload;
	}
}
function s4b_generate_multiple_form_fields($fields, $values, $parent = 's4b_organization[%s]') {
	// Generates form fields out of requirements;
	$payload = '';
	foreach ( $fields as $field ) {
		$payload .= s4b_generate_form_field( $field, $values, $parent );
	}
	return $payload;
}

function s4b_index_page() {
	// Sets up the input fields for the setting
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
	$options = get_option( 's4b_organization' );
	$fields = s4b_organization_requirements();
	?>

	<div class="wrap">

		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
			<div class="updated fade"><p><strong><?php _e( 'WPORG Options saved!', 'wporg' ); ?></strong></p></div>
		<?php endif; ?>

		<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
		Seahouse 4 Businesses lets you add your Business-Data to your site. Google & Co. will love it.


		<form method="post" action="options.php">
			<?php settings_fields( 's4b_index' ); ?>
			<table class="form-table">
				<!-- <tr valign="top"><th scope="row"><?php _e( 'Hide the post meta information on posts?', 'wporg' ); ?></th>
					<td>
						<select name="s4b_organization[hide_meta]" id="hide-meta">
							<?php $selected = $options['hide_meta']; ?>
							<option value="1" <?php selected( $selected, 1 ); ?> >Yes, hide the post meta!</option>
							<option value="0" <?php selected( $selected, 0 ); ?> >No, show my post meta!</option>
						</select><br />
						<label class="description" for="s4b_organization[hide_meta]"><?php _e( 'Toggles whether or not to display post meta under posts.', 'wporg' ); ?></label>
					</td>
				</tr> -->

				<?php echo s4b_generate_multiple_form_fields($fields, $options) ?>

			</table>
			<p class="submit">
				<input type="submit" value="Save settings" class="button-primary"/>
			</p>
		</form>

 </div>
<?php }
