<?php

if( !class_exists('wlwh_create_metabox')){

	class wlwh_create_metabox{

		public function __construct(){
			$this->options = get_option( 'wlwhplugin_email_settings' );

		}

		public function add_wlwh_meta_box(){
			add_meta_box("wlwh_meta", esc_html("Wish List"), array($this,'add_wish_list_meta_box'), "wish", "normal", "low");
		}

		public function add_wish_list_meta_box(){
		      global $post;
					// add nonce fiels here & check before storing data
					wp_nonce_field( basename( __FILE__ ), 'wlwh_meta_box_nonce' );
		      $custom = get_post_custom( $post->ID );
					// Retrieve post meta fields, based on post ID.
					// since we have 1 custom field so array [0]

					//starting email panga
			//		global $post;
					$user_id=substr(get_the_title($post->ID),10 ) ;
					$user_info=get_userdata($user_id);
					// email panga ends
		      ?>

		      <p>

		          <label>Wish List</label><br />
		          <input type="text" name="wishids" value="<?php _e($custom["wishids"][0]); ?>" />
	      	</p>

					<p>
						<?php

						//$str = date("l jS \of F Y h:i:s A");
						//echo $str;
						$wishString  = $custom["wishids"][0] ;
						$wishListIds = explode(',',$wishString);

						foreach ($wishListIds as $wishListId) {
							//print_r($wishListId);
								 if($wishListId){
											 $currentproduct = wc_get_product( $wishListId );
											 $currentThumbnail = get_the_post_thumbnail( $wishListId, array(50,50) );
											 $currentTitle = $currentproduct->get_title();
											 $currentPrice = $currentproduct->get_price_html();
											// $emailContent = $emailBody . $currentTitle . $currentPrice;
											 ?>



											 <div id = "<?php _e($wishListId) ; ?>" class="metabox__row " >

														<div class = "col-2">

																 <?php
																 if(has_post_thumbnail( $wishListId)){
																					 _e($currentThumbnail);
																}
																?>

													 </div>  <!-- end of col-2   -->

													<div class="col-2">
																	<div class = "metabox__title">
																				 <?php _e($currentTitle); ?>
																	</div>
													</div>

														<div class= "col-5">
																 <button type="button" class ="emailbutton" id="emailbutton" data-productid="<?php _e($wishListId);?>" data-postid="<?php _e($post->ID); ?>" >Send mail to <?php echo $user_info->display_name ; ?> about this product</button>
														</div>

										</div>

						<?php
							} // if wish list id ..
						}   //foreach
						?>

					</p>
		      <?php
		}

		public function save_wished_products_custom_fields(){
			  global $post;
				// verify nonce so that save command is coming from this plugin only
				if ( !isset( $_POST['wlwh_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['wlwh_meta_box_nonce'], basename( __FILE__ ) ) ){
						return;
				}

			  if ( $post )
			  {
			    update_post_meta($post->ID, "wishids", sanitize_text_field($_POST["wishids"]));
			  }
		}


	}  // class

}

$wlwh_meta_box_object = new wlwh_create_metabox;
add_action( 'admin_init', array($wlwh_meta_box_object , 'add_wlwh_meta_box') );
add_action('save_post', array($wlwh_meta_box_object , 'save_wished_products_custom_fields') );
