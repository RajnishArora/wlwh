<?php
/*
Plugin Name: Wishlist with hearts
Plugin URI: https://github.com/rajnisharora/wlwh
Description: Plugin to create wishlist / shoppinglist / shortlist for Woocommerce e-store
Version: 1.0.0
Contributors: rajarora795
Author: Rajnish Arora
Author URI: rajnisharora.com
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
include( WLWHPLUGIN_DIR . 'includes/wlwhplugin-settings-fields.php');
include( WLWHPLUGIN_DIR . 'includes/wlwhplugin-email-settings-fields.php');

// create menu
include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-menus.php');

// include styles * scripts
include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-styles.php');
include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-scripts.php');

include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-create-metabox.php');
include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-post-types.php');

include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-show-hearts.php');

include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-wish-route.php');
include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-email-route.php');
include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-create-page.php');
include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-create-button.php');
include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-wishlist.php');
include( plugin_dir_path( __FILE__ ) . 'shortcodes/wlwh_shortcode_view.php');

//include( plugin_dir_path( __FILE__ ) . 'includes/wlwhplugin-settings-link.php');

// Add a link to your settings page in your plugin
function wlwhplugin_add_settings_link( $links ) {
    $settings_link = '<a href="edit.php?post_type=wish&page=wlwhplugin-wish">' . __( 'Settings', 'wlwhplugin' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
$filter_name = "plugin_action_links_" . plugin_basename( __FILE__ );
add_filter( $filter_name, 'wlwhplugin_add_settings_link' );
