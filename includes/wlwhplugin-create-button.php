<?php

if( !class_exists('wlwh_create_button')){

	class wlwh_create_button{

    public function __construct(){
				$this->options = get_option( 'wlwhplugin_settings' );
    }


		function check_wish_status() {
						$existStatus = 'no';
						$wishpostId = 0;
						$currentUserId = get_current_user_id();
						$currentProductId = get_the_ID();

						$userTitle = "wlwh_user_" . $currentUserId;
						$wishpost = get_page_by_title($userTitle,'' , 'wish');
						$wishpostId = $wishpost->ID;

						if ( $wishpostId ){ 		//means wish list exists
							$prvproductId = sanitize_text_field(get_post_meta($wishpostId,'wishids',true));
							$arrayofWishListIds = explode(',',$prvproductId);
							if (in_array($currentProductId,$arrayofWishListIds)){
									$existStatus = 'yes';
							}
						}

						return $existStatus;
			}


		public function wlwh_add_button(){
				global $product;
			  $id = $product->get_id();
			  $currentproduct = wc_get_product( $id );
				$x= $this->check_wish_status();

				?>
				<div class="single-addtowishList wish-button" data-singleproductid="<?php _e($id); ?>" data-singleexiststatus = "<?php _e($x); ?>" >
						<?php
						if( isset( $this->options[ 'wlwh_buttontext' ] )  && $this->options['wlwh_buttontext'] != '') {
						  	_e(sanitize_text_field($this->options['wlwh_buttontext']));
						} else {
								_e("Add to WishList");
						}

						?>
				</div>
				<?php
		}

  }
}

$wlwh_button_object = new wlwh_create_button;
$options = get_option( 'wlwhplugin_settings' );


if( isset( $options[ 'show_button' ] ) ) {
		add_action( 'woocommerce_product_meta_start', array($wlwh_button_object , 'wlwh_add_button'),2 );
}
