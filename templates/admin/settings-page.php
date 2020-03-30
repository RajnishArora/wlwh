<?php
/**
 *
 * @package           Wishlist-with-hearts
 */


// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}
?>

<div class="wrap">

  <h1><?php esc_html_e( get_admin_page_title() ); ?></h1>

  <form method="post" action="options.php">
    <!-- Display necessary hidden fields for settings -->
    <?php settings_fields( 'wlwhplugin_settings' ); ?>
    <!-- Display the settings sections for the page -->
    <?php do_settings_sections( 'wlwhplugin' ); ?>
    <!-- Default Submit Button -->
    <?php submit_button(); ?>
  </form>

</div>
