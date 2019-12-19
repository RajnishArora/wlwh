<?php


if( !class_exists('wlwh_create_cpt')){

class wlwh_create_cpt{

  public function __construct()
  {
  }  //constructor

   public function create_cpt() {
    //  Post Type

    // this variable controls whether to shoe in dashboard
    $show_checkbox = true;

        if( !post_type_exists('wish') ){
                register_post_type('wish', array(
                      'supports' => array('title'),
                      'public' => true,
                      'show_ui' => true,
                      'show_in_menu'  => true,
                      'capability_type' => 'post',
                      'capabilities'  => array(
                            'create_posts' => false
                      ),
                      'map_meta_cap'  => true,
                      'labels' => array(
                          'name' => _x('Wish Lists','post type general name','wlwhplugin'),
                          'singular_name' => _x('Wish List','post type singular name','wlwhplugin'),
                          'all_items' => __('All Users','wlwhplugin')

                      ),
                      'exclude_from_search' => true,
                      'publicly_queryable'  => false,
                      'query_var'           => false,
                      'menu_icon' => 'dashicons-heart'
               ));

        }// if post_type_exists
    } //create_cpt ends
  } // class  ends
}

add_action('init', array(new wlwh_create_cpt , 'create_cpt' ) );
