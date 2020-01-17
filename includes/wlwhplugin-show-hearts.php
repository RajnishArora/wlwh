<?php

if( !class_exists('wlwh_show_hearts')){
	class wlwh_show_hearts{

		//private $options = [];

		public function __construct(){
				$this->options = get_option( 'wlwhplugin_settings' );
		}


		function wlwhplugin_add_wishbox_markup(){
					$is_json=false;
					$existStatus = 'no';
					$wishpostId = 0;
					$currentUserId = get_current_user_id();
					$userTitle = "wlwh_user_" . $currentUserId ;
					$currentProductId = get_the_ID();

					$wishpost = get_page_by_title($userTitle, '' , 'wish');
					$wishpostId = $wishpost->ID;

					if ( $wishpostId ){ 		//means wish list exists
						$prvproductId = sanitize_text_field(get_post_meta($wishpostId,'wishids',true));
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
					$heart_url =  esc_url(WLWHPLUGIN_URL .'assets/heart.png');
					$optionChosen = 1;
					if( isset( $this->options['heart_place'] ) ) {
							$optionChosen = sanitize_text_field($this->options['heart_place']);
					}
					
					$rest_url = get_rest_url();
					if (strpos($rest_url,'wp-json') != false){
							$is_json=true;
					} else {
						    $is_json=false;;
					}

				?>
				<span class="wish-box hidden wish-box-topleft wish-box_hover" style = " cursor:url('<?php _e($heart_url) ;  ?>' ) 6 6 ,cell" data-isjson = "<?php _e($is_json); ?> " data-exists="<?php _e($existStatus); ?>"  data-place ="<?php _e($optionChosen);?>"  data-product-id="<?php _e($currentProductId) ; ?>"  data-logged="<?php _e($logged); ?>" >
						<i class = "fa fa-heart-o "></i>
						<i class = "fa fa-heart"></i>
				</span>
				<div class = "added-wish hidden">
						<?php _e(sanitize_text_field($this->options['wlwh_toast']));	 ?>
				</div>
				<span class = "left_correction hidden">
						<?php _e(sanitize_text_field( $this->options['wlwh_correction_left']));	 ?>
				</span>
				<span class = "right_correction hidden">
						<?php _e(sanitize_text_field( $this->options['wlwh_correction_right']));	 ?>
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
// to add just after increase the priority to 15 or so
if( isset( $options[ 'single_checkbox' ] ) ) {
	add_action('woocommerce_before_single_product_summary', array($wlwhplugin_wishbox_markup,'wlwhplugin_add_wishbox_markup'),30);
}
