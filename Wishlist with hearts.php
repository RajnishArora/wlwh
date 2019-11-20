<?php
/*
Plugin Name: Wishlist with hearts
Plugin URI: https://github.com/rajnisharora/wlwh
Description: Plugin to create wishlist Woocommerce e-store
Version: 1.0.0
Contributors: rajarora795
Author: Rajnish Arora
Author URI:
License: GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wlwhplugin
Domain Path:  /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die("Not allowed to access directly");
}

if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
  die("Please install WooCommerce & try again");
}


// Define plugin paths and URLs

define( 'WLWHPLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WLWHPLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Create Settings Fields
//include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-settings-fields.php');
include( WLWHPLUGIN_DIR . 'includes/wlwhplugin-settings-fields.php');

// create menu
include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-menus.php');

include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-styles.php');
include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-scripts.php');

include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-create-metabox.php');
include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-post-types.php');

include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-show-hearts.php');
include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-wish-route.php');

include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-create-page.php');
include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-create-button.php');
