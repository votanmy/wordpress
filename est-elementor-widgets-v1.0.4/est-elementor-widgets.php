<?php
/**
 * Plugin Name: EST Elementor Widgets
 * Description: Add custom elementor widgets
 * Plugin URI:  https://efe.com.vn/
 * Version:     1.0.4
 * Author:      EFE Technology
 * Author URI:  https://efe.com.vn/
 * Text Domain: est-img-tooltip
 *
 * Elementor tested up to: 3.7.0
 * Elementor Pro tested up to: 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */

function register_est_img_tooltip_widget( $widgets_manager ) {
	require_once( __DIR__ . '/widgets/est-img-tooltip-widget.php' );
	$widgets_manager->register( new \EST_Img_Tooltip_Widget() );
}
add_action( 'elementor/widgets/register', 'register_est_img_tooltip_widget' );

/**
 * Register scripts and styles.
 */
function est_widgets_dependencies() {

	/* Styles */
	wp_register_style( 'est-style-handle', plugins_url( 'assets/css/est-custom-widget.css', __FILE__ ) );
	/* Scripts */
	wp_register_script( 'est-script-handle', plugins_url( 'assets/js/est-custom-widget.js', __FILE__ ) );	

}
add_action( 'wp_enqueue_scripts', 'est_widgets_dependencies' );