<?php

// Load JS on all admin pages
function wlwhplugin_admin_scripts() {

  wp_enqueue_script(
    'wlwhplugin-admin', WLWHPLUGIN_URL . 'admin/js/wlwhplugin-admin.js', ['jquery'],  time()
  );

}
add_action( 'admin_enqueue_scripts', 'wlwhplugin_admin_scripts', 100 );


// Load JS on the frontend
function wlwhplugin_frontend_scripts() {
/*
  wp_enqueue_script(
    'wlwhplugin-frontend', WLWHPLUGIN_URL . 'frontend/js/wlwhplugin-frontend.js', [], time(),true
  );
*/

  wp_enqueue_script(
    'wlwhplugin-frontend', WLWHPLUGIN_URL . 'frontend/js/wlwhplugin-wishlist.js', [], time(),true
  );


  wp_localize_script('wlwhplugin-frontend', 'wlwhData', array(
      'pluginsUrl' => plugins_url(),
      'root_url' => get_site_url(),
      'nonce' => wp_create_nonce('wp_rest'),
  ));

}

add_action( 'wp_enqueue_scripts', 'wlwhplugin_frontend_scripts', 100 );
