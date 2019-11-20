<?php

if( !class_exists('wlwh_show_hearts')){
	class wlwh_show_hearts{

		//private $options = [];

		public function __construct(){
				$this->options = get_option( 'wlwhplugin_settings' );
		}




		function wlwhplugin_add_wishbox_markup(){
					$existStatus = 'no';
					$wishpostId = 0;
					$currentUserId = get_current_user_id();
					$userTitle = "wlwh_user_" . $currentUserId ;
					$currentProductId = get_the_ID();

					$wishpost = get_page_by_title($userTitle, '' , 'wish');
					$wishpostId = $wishpost->ID;


					if ( $wishpostId ){ 		//means wish list exists
						$prvproductId = get_post_meta($wishpostId,'wishids',true);
						$arrayofWishListIds = explode(',',$prvproductId);
						if (in_array($currentProductId,$arrayofWishListIds)){
							$existStatus = 'yes';
						}
					}

					if(is_user_logged_in()){
						 $logged = 'yes';
					} else {
						 $logged = 'no';
					}
					$heart_url =  WLWHPLUGIN_URL .'assets/heart.png';

				?>
				<span class="wish-box wish-box_hover" style = " cursor:url('<?php _e($heart_url) ;  ?>' ) 6 6 ,cell" data-exists="<?php _e($existStatus); ?>"  data-product-id="<?php _e($currentProductId) ; ?>"  data-logged="<?php _e($logged); ?>">
						<i class = "fa fa-heart-o "></i>
						<i class = "fa fa-heart"></i>

						<span class = "added-wish hidden">
								<?php
									_e($this->options['wlwh_toast']);
								 ?>

						</span>
						<span class = "deleted-wish hidden">
								Deleted from wish list
						</span>

				</span>


			<?php
		} // function wlwhplugin_add_wishbox_markup

		}  // class

} //if ! class exists

$wlwhplugin_wishbox_markup = new wlwh_show_hearts;
$options = get_option( 'wlwhplugin_settings' );

if( isset( $options[ 'other_checkbox' ] ) ) {
	add_action('woocommerce_before_shop_loop_item_title', array($wlwhplugin_wishbox_markup,'wlwhplugin_add_wishbox_markup'),30);
}

// this is just before the image
// to add just after icrease the priority to 15 or so
if( isset( $options[ 'single_checkbox' ] ) ) {
	add_action('woocommerce_before_single_product_summary', array($wlwhplugin_wishbox_markup,'wlwhplugin_add_wishbox_markup'),30);

//	add_action('woocommerce_product_thumbnails', array($wlwhplugin_wishbox_markup,'wlwhplugin_add_wishbox_markup'),30);
}
