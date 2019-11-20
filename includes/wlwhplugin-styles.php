<?php


// Load CSS on the frontend
function wlwhplugin_frontend_styles() {

  wp_enqueue_style( 'load-fa', WLWHPLUGIN_URL . 'assets/font-awesome-4.7.0/css/font-awesome.min.css' );
  wp_enqueue_style( 'wlwhplugin-frontend', WLWHPLUGIN_URL . 'frontend/css/wlwhplugin-frontend-style.css', [], time()  );
  wp_enqueue_style(
    'wlwhplugin-frontend-wishlist', WLWHPLUGIN_URL . 'frontend/css/page-wishlist.css', [], time()
  );
}
add_action( 'wp_enqueue_scripts', 'wlwhplugin_frontend_styles', 100 );
