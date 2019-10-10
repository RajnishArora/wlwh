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

define( 'RVPPLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'RVPPLUGIN_DIR', plugin_dir_path( __FILE__ ) );
