<?php

function wlwhplugin_settings_page_markup()
{
  // Double check user capabilities
  if ( !current_user_can('manage_options') ) {
      return;
  }
  include( WLWHPLUGIN_DIR . 'templates/admin/settings-page.php');
}


function wlwhplugin_email_page_markup()
{
  // Double check user capabilities
  if ( !current_user_can('manage_options') ) {
      return;
  }
  include( WLWHPLUGIN_DIR . 'templates/admin/email-page.php');
}

function wlwhplugin_settings_pages()
{
  /*
  add_menu_page(
    __( 'Wishlist with hearts Plugin', 'wlwhplugin' ),   //page title
    __( 'Wishlist', 'wlwhplugin' ), //menu title
    'manage_options',
    'wlwhplugin',
    'wlwhplugin_settings_page_markup',
    'dashicons-heart',
    100
  );
  */
  add_submenu_page(
    'edit.php?post_type=wish',
    __( 'Wish Settings', 'wlwhplugin' ),
    __( 'Wish Settings', 'wlwhplugin' ),
    'manage_options',
    'wlwhplugin-wish',
    'wlwhplugin_settings_page_markup'
  );

  add_submenu_page(
    'edit.php?post_type=wish',
    __( 'Email Settings', 'wlwhplugin' ),
    __( 'Email Settings', 'wlwhplugin' ),
    'manage_options',
    'wlwhplugin-email',
    'wlwhplugin_email_page_markup'
  );
}
//add_action( 'admin_menu', 'wlwhplugin_settings_pages' );
add_action( 'admin_menu', 'wlwhplugin_settings_pages' );


// Add a link to your settings page in your plugin
function wlwhplugin_add_settings_link( $links ) {
    $settings_link = '<a href="admin.php?page=wlwhplugin">' . __( 'Settings', 'wlwhplugin'  ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
$filter_name = "plugin_action_links_".plugin_basename( __FILE__ );
add_filter( $filter_name, 'wlwhplugin_add_settings_link' );
