<?php

/* 
** Plugin Name: dotstudioPRO Premium Carousel
** Version: 1.00
** Author: dotstudioPRO
** Author URI: #
*/

require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if(!class_exists('DotStudioz_Commands')){

	require_once("class.curl_commands.php");

}

require_once("functions.php");

require 'updater/plugin-update-checker.php';
$myUpdateChecker = PucFactory::buildUpdateChecker(
    'http://wordpress.dotstudiopro.com/pluginupdates/carousel/api/update.php',
    __FILE__
);

add_action( 'wp_enqueue_scripts', 'ds_carousel_owl_carousel' );

function ds_carousel_main_check() {

    $plugins = get_option('active_plugins');

    $ds_premium_video = false;

    foreach($plugins as $k => $v){

    	if(strpos($v, "ds-premium-video")){

    		$ds_premium_video = true;

    		break;

    	}

    }

    if (!$ds_premium_video) {

    	foreach($plugins as $k => $v){

	    	if(strpos($v, "ds-premium-carousel")){

	    		unset($plugins[$k]);

	    		update_option('active_plugins', $plugins);

    			add_action( 'admin_notices', 'ds_carousel_check_main_plugin' );

	    		break;

	    	}

	    }

    }

}
register_activation_hook( __FILE__, 'ds_carousel_main_check' );

add_action("init", "ds_carousel_main_check");


/** Add Menu Entry **/
function dot_studioz_carousel_menu() {
	
	add_menu_page( 'dotstudioCarousel Options', 'dotstudioCarousel Options', 'manage_options', 'dot-studioz-carousel-options', 'dot_studioz_carousel_menu_page', 'dashicons-slides' );
	
}

add_action( 'admin_menu', 'dot_studioz_carousel_menu' );

// Set up the page for the plugin
function dot_studioz_carousel_menu_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
	echo "<div class='wrap'>";
	
			
	include("menu.tpl.php");	
	
	
	echo "</div>";
	
}
/** End Menu Entry **/
