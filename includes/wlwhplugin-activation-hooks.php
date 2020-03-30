<?php
/*
function wlwh_pluginprefix_setup_post_type() {

}
add_action( 'init', 'wlwh_pluginprefix_setup_post_type' );
*/

function wlwh_pluginprefix_install() {
    //wlwh_create_cpt
    if ( !isset($wlwh_cpt_object) ){
 				$wlwh_cpt_object = new wlwh_create_cpt;
 		}
    // trigger our function that registers the custom post type
    $wlwh_create_cpt->create_cpt();

    // clear the permalinks after the post type has been registered
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'wlwh_pluginprefix_install' );



function wlwh_pluginprefix_deactivation() {
    //del the cookie`
    if( isset( $_COOKIE['wlwhguest'] ) ){
        setcookie('wlwhguest', "", 1,'/',COOKIE_DOMAIN);
    }
    // unregister the post type, so the rules are no longer in memory
    unregister_post_type( 'wish' );
    // clear the permalinks to remove our post type's rules from the database
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'wlwh_pluginprefix_deactivation' );
