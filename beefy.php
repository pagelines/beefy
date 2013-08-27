<?php
/*
	Plugin Name: Beefy
	Demo: http://beefy.ahansson.com
	Description: Beefy Slider is a great slider to show images on your site. Beefy Slider is beautifully responsive, comes with color control and supports up to 20 images of your choice. Sounds tasty? Buy Beefy ;)
	Version: 2.2
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
*/

define( 'AH_BEEFY_STORE_URL', 'http://shop.ahansson.com' );
define( 'AH_BEEFY_NAME', 'Beefy' );

if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
	// load our custom updater
	include( dirname( __FILE__ ) . '/EDD_SL_Plugin_Updater.php' );
}

// retrieve our license key from the DB
$license_key = trim( get_option( 'ah_beefy_license_key' ) );

// setup the updater
$edd_updater = new EDD_SL_Plugin_Updater( AH_BEEFY_STORE_URL, __FILE__, array(
		'version' 	=> '2.2', 				// current version number
		'license' 	=> $license_key, 		// license key (used get_option above to retrieve from DB)
		'item_name' => AH_BEEFY_NAME, 		// name of this plugin
		'author' 	=> 'Aleksander Hansson' // author of this plugin
	)
);


function ah_beefy_license_menu() {
	add_plugins_page( 'Beefy License', 'Beefy License', 'manage_options', 'ah_beefy_license', 'ah_beefy_license_page' );
}
add_action('admin_menu', 'ah_beefy_license_menu');

function ah_beefy_license_page() {
	$license 	= get_option( 'ah_beefy_license_key' );
	$status 	= get_option( 'ah_beefy_license_status' );
	?>
	<div class="wrap">
		<h2><?php _e('Beefy License Options'); ?></h2>
		<form method="post" action="options.php">

			<?php settings_fields('ah_beefy_license'); ?>

			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row" valign="top">
							<?php _e('License Key'); ?>
						</th>
						<td>
							<input id="ah_beefy_license_key" name="ah_beefy_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="ah_beefy_license_key"><?php _e('Enter your license key'); ?></label>
						</td>
					</tr>
					<?php if( false !== $license ) { ?>
						<tr valign="top">
							<th scope="row" valign="top">
								<?php _e('Activate License'); ?>
							</th>
							<td>
								<?php if( $status !== false && $status == 'valid' ) { ?>
									<span style="color:green;"><?php _e('active'); ?></span>
									<?php wp_nonce_field( 'ah_beefy_nonce', 'ah_beefy_nonce' ); ?>
									<input type="submit" class="button-secondary" name="ah_beefy_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>
								<?php } else {
									wp_nonce_field( 'ah_beefy_nonce', 'ah_beefy_nonce' ); ?>
									<input type="submit" class="button-secondary" name="ah_beefy_license_activate" value="<?php _e('Activate License'); ?>"/>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php submit_button(); ?>

		</form>
	<?php
}

function ah_beefy_register_option() {
	// creates our settings in the options table
	register_setting('ah_beefy_license', 'ah_beefy_license_key', 'ah_beefy_sanitize_license' );
}
add_action('admin_init', 'ah_beefy_register_option');

function ah_beefy_sanitize_license( $new ) {
	$old = get_option( 'ah_beefy_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'ah_beefy_license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}

function ah_beefy_activate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['ah_beefy_license_activate'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'ah_beefy_nonce', 'ah_beefy_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'ah_beefy_license_key' ) );


		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'activate_license',
			'license' 	=> $license,
			'item_name' => urlencode( AH_BEEFY_NAME ) // the name of our product in EDD
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, AH_BEEFY_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "active" or "inactive"

		update_option( 'ah_beefy_license_status', $license_data->license );

	}
}
add_action('admin_init', 'ah_beefy_activate_license');


/***********************************************
* Illustrates how to deactivate a license key.
* This will descrease the site count
***********************************************/

function ah_beefy_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['ah_beefy_license_deactivate'] ) ) {

		// run a quick security  check
	 	if( ! check_admin_referer( 'ah_beefy_nonce', 'ah_beefy_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'ah_beefy_license_key' ) );


		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'deactivate_license',
			'license' 	=> $license,
			'item_name' => urlencode( AH_BEEFY_NAME ) // the name of our product in EDD
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, AH_BEEFY_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' )
			delete_option( 'ah_beefy_license_status' );

	}
}
add_action('admin_init', 'ah_beefy_deactivate_license');


function ah_beefy_check_license() {

	global $wp_version;

	$license = trim( get_option( 'ah_beefy_license_key' ) );

	$api_params = array(
		'edd_action' => 'check_license',
		'license' => $license,
		'item_name' => urlencode( AH_BEEFY_NAME )
	);

	// Call the custom API.
	$response = wp_remote_get( add_query_arg( $api_params, AH_BEEFY_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );


	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if( $license_data->license == 'valid' ) {
		echo 'valid'; exit;
		// this license is still valid
	} else {
		echo 'invalid'; exit;
		// this license is no longer valid
	}
}