<?php
/*
	Plugin Name: Beefy
	Demo: http://beefy.ahansson.com
	Description: Beefy Slider is a great slider to show images on your site. Beefy Slider is beautifully responsive, comes with color control and supports up to 20 images of your choice. Sounds tasty? Buy Beefy ;)
	Version: 3.1
	Author: Aleksander Hansson
	Author URI: http://ahansson.com
	v3: true
*/

class ah_Beefy_Plugin {

	function __construct() {
		add_action( 'init', array( &$this, 'ah_updater_init' ) );
	}

	function ah_updater_init() {

		require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/plugin-updater.php' );

		$config = array(
			'base'      => plugin_basename( __FILE__ ), 
			'repo_uri'  => 'http://shop.ahansson.com',  
			'repo_slug' => 'beefy',
		);

		new AH_Beefy_Plugin_Updater( $config );
	}

}

new ah_Beefy_Plugin; 