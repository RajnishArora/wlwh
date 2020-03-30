<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if( !class_exists('wlwh_show_hearts')){
	class wlwh_show_hearts{



		public function __construct(){
				$this->options = get_option( 'wlwhplugin_settings' );

		}

		function wlwhplugin_add_short_wishbox($visibility){

				if($visibility != ''){
						if(($visibility == "hidden")){
									$this->wlwhplugin_add_wishbox_markup("hidden");
						} else {
									$this->wlwhplugin_add_wishbox_markup("true");
						}
				}


		}


		function wlwhplugin_add_wishbox_markup($short = "false"){
					$is_json=false;
					$existStatus = 'no';
					$currentProductId = get_the_ID();

					if(is_user_logged_in()){
							 $logged = 'yes';
							 $wishpostId = 0;
			 					$currentUserId = get_current_user_id();
			 					$userTitle = "wlwh_user_" . $currentUserId ;

			 					$wishpost = get_page_by_title($userTitle, '' , 'wish');
			 					$wishpostId = $wishpost->ID;

			 					if ( $wishpostId ){ 		//means wish list exists
			 							$prvproductId = sanitize_text_field(get_post_meta($wishpostId,'wishids',true));
			 							$arrayofWishListIds = explode(',',$prvproductId);
			 							if (in_array($currentProductId,$arrayofWishListIds)){
			 									$existStatus = 'yes';
			 							}
			 					}


					} else {
						 $logged = 'no';
						 // check  the current product in cookie
						 if( isset( $_COOKIE['wlwhguest'] ) ){
		 							$prev_val = $_COOKIE['wlwhguest'] ;
		 							$prev_val = stripslashes($prev_val);
		 							$array_val = unserialize($prev_val);
									if (in_array($currentProductId,$array_val)){
												$existStatus = 'yes';
									}
							}
					}
					$cursorOption=1;
					$heart_url='pointer';
					if( isset( $this->options['heart_cursor'] ) ) {
							$cursorOption = sanitize_text_field($this->options['heart_cursor']);
					}
//					$heart_url =  esc_url(WLWHPLUGIN_URL .'assets/heart.png');
/* 'url(<?php _e($heart_url) ;  ?> ) 6 6 ,cell';  */
					switch ($cursorOption) {
						case '1':		$heart_url = 'pointer';
												break;
						case '2':
												$heart_url = 'cell';
												break;
						case '3':		$heart_url = 'crosshair';
												break;
						case '4': 	$heart_url = 'default';
												break;
						default:		$heart_url = 'default';
												break;
					}
					$optionChosen = 1;
					if( isset( $this->options['heart_place'] ) ) {
							$optionChosen = sanitize_text_field($this->options['heart_place']);
					}
					//check whether rest url contains the word json or not
					$rest_url = get_rest_url();
					if (strpos($rest_url,'wp-json') != false){
							$is_json=true;
					} else {
						    $is_json=false;;
					}

				if( isset( $this->options[ 'wlwh_heart_picker_label' ] ) ) {
						$heart_col = sanitize_text_field($this->options[ 'wlwh_heart_picker_label' ]) ;
				} else {
						$heart_col = "#ff0000";
				}

				?>
				<span class="wish-box hidden wish-box_hover" style = "cursor: <?php _e($heart_url) ; ?> ;  color: <?php _e($heart_col);?> ;" data-isjson = "<?php _e($is_json); ?> " data-exists="<?php _e($existStatus); ?>"  data-place ="<?php _e($optionChosen);?>"  data-product-id="<?php _e($currentProductId) ; ?>"  data-logged="<?php _e($logged); ?>" data-short="<?php _e($short); ?>">
						<i class = "fa fa-heart-o "></i>
						<i class = "fa fa-heart"></i>
				</span>
				<div class = "added-wish hidden " style="color: <?php _e($heart_col); ?>">
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
