<?php
/**
 * Plugin Name: WordPress Vite React Template
 * Author: Anjon Roy
 * Author URI: https://anjonroy.com/
 * Version: 1.0.0
 * Description: WordPress Vite React Template
 * Text-Domain: wordpress-vite-react-template
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Define Plugins Contstants
 */
define( 'WPVITEREACT_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'WPVITEREACT_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );

class WP_Vite_React_Template {
	
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'create_admin_menu' ) );
	}

	public function init() {
		add_action('admin_enqueue_scripts', array( $this, 'load_scripts' ) );
	}

	public function load_scripts( $hook_suffix ){
		if ($hook_suffix != 'toplevel_page_wp-vite-react-app') {
			return;
		}
		wp_enqueue_script( 'wp-vite-react-js', WPVITEREACT_URL . 'dist/assets/js/main.js', array(), time(), true );
		wp_localize_script( 'wp-vite-react-js', 'appLocalizer', array(
			'apiUrl' => home_url('/wp-json'),
			'nonce' => wp_create_nonce('wp_rest')
		) );
	
		wp_enqueue_style('wp-admin-react-css', WPVITEREACT_URL . 'dist/assets/css/main.css', array(), time() );
	}

	public function create_admin_menu() {
		$capability = 'manage_options';
		$slug = 'wp-vite-react-app';

		add_menu_page(
			__( 'WordPress Vite React Template', 'wordpress-vite-react-template' ),
			__( 'WordPress Vite React Template', 'wordpress-vite-react-template' ),
			$capability,
			$slug,
			array( $this, 'menu_page_template' ),
			'dashicons-hammer'
		);
	}

	public function menu_page_template() {
		echo "<div class='wrap'><div id='wp-vite-react-app'></div></div>";
	}
}

new WP_Vite_React_Template();
