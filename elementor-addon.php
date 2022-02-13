<?php
/**
 * Plugin Name: Elementor Addon
 * Description: Custom Elementor Addons.
 * Version:     1.0.0
 * Author:      Mulraj Gupta
 * Author URI:  https://developers.elementor.com/
 */

function register_custom_widgets( $widgets_manager ) {

  require_once( __DIR__ . '/widgets/Custom_Slider.php' );

  $widgets_manager->register( new \Custom_Slider() );

}

add_action( 'elementor/widgets/register', 'register_custom_widgets' );
