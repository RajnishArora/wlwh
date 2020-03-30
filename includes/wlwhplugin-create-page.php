<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if( !class_exists('wlwh_create_page')){
	class wlwh_create_page{
  private $wish_page_template =  WLWHPLUGIN_DIR . 'templates/frontend/page-wishlist.php' ;
	private $new_page_id;
		public function __construct(){
				$this->options = get_option( 'wlwhplugin_settings' );
		}
		public function wlwh_add_page(){
				if( isset( $this->options['pageselect']) ){
						$page_id = $this->options['pageselect'];
				}
				if($page_id == '-1'){
							$slug = 'wlwh-wish-list-page';
							$content = ' This page is created by Plugin : Wishlist with hearts. It is required for the plugin to function.Please donot delete ';
							$title = 'Wish List';
							 $new_post = array(
										'post_title' => sanitize_text_field($title) ,
										'post_slug' => sanitize_text_field($slug),
										'post_content' => sanitize_text_field($content),
										'post_status' => 'publish',
										'post_author' => get_current_user_id(),
										'post_type' => 'page'
								//    'post_category' => array(0)
								);
								$page = get_page_by_title($title);
								if( isset($page->ID)){
										//		 already exists
								} else {
										$new_page_id =  wp_insert_post($new_post);
										if(!empty($wish_page_template)){
														$wish_page_template = (WLWHPLUGIN_DIR . 'templates/frontend/page-wishlist.php') ;
														//$wish_page_template = plugin_dir_path( __FILE__ ) . 'templates/frontend/page-wishlist.php' ;
														update_post_meta($new_page_id, '_wp_page_template', $wish_page_template);
										}
								}
				}

    }

      function catch_plugin_template($template) {

				if( isset( $this->options['pageselect']) ){
						$page_id = $this->options['pageselect'];
						if($page_id == '-1'){

						} else if(is_page($page_id)) {
									$template =  (WLWHPLUGIN_DIR . 'templates/frontend/page-wishlist.php');
						}
				}
				return $template;
      }
	}  // class
}
  $wlwh_page_object = new wlwh_create_page;
  //add_action( 'admin_init', array($wlwh_page_object , 'wlwh_add_page') );
  add_filter('page_template',array($wlwh_page_object , 'catch_plugin_template') );
  // Page template filter callback
