<?php

if( !class_exists('wlwh_create_button')){

	class wlwh_create_button{

    public function __construct(){
				$this->options = get_option( 'wlwhplugin_settings' );
			}


		function check_wish_status() {
						$existStatus = 'no';
						$currentProductId = get_the_ID();

						if(is_user_logged_in()){
								$wishpostId = 0;
								$currentUserId = get_current_user_id();

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
						} else { //not logged so check in cookie
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



						return $existStatus;
			}

		public function wlwh_add_short_button($btnlabel){
					if(is_product()){
								global $product;
								$id = $product->get_id();
								$currentproduct = wc_get_product( $id );
								$x= $this->check_wish_status();
								if( isset( $this->options[ 'wlwh_heart_picker_label' ] ) ) {
										$text_col = sanitize_text_field($this->options[ 'wlwh_heart_picker_label' ]) ;
								}else {
										$text_col = "#ff0000";
								}
								?>
								<div style = "color: <?php _e($text_col);?>" >
											<div class="single-addtowishList wish-button" data-singleproductid="<?php _e($id); ?>" data-singleexiststatus = "<?php _e($x); ?>" style="">
													<?php
													if( $btnlabel != '') {
															_e(sanitize_text_field($btnlabel));
													} else {
															_e("Add to WishList");
													}

													?>
											</div>
								</div>
								<?php

					}

		}

		public function wlwh_add_button(){
				global $product;
			  $id = $product->get_id();
			  $currentproduct = wc_get_product( $id );
				$x= $this->check_wish_status();
				if( isset( $this->options[ 'wlwh_heart_picker_label' ] ) ) {
						$text_col = sanitize_text_field($this->options[ 'wlwh_heart_picker_label' ]) ;
				}else {
						$text_col = "#ff0000";
				}
				?>
				<div style = "color: <?php _e($text_col);?>" >
							<div class="single-addtowishList wish-button" data-singleproductid="<?php _e($id); ?>" data-singleexiststatus = "<?php _e($x); ?>" >
									<?php
									if( isset( $this->options[ 'wlwh_buttontext' ] )  && $this->options['wlwh_buttontext'] != '') {
									  	_e(sanitize_text_field($this->options['wlwh_buttontext']));
									} else {
											_e("Add to WishList");
									}

									?>
							</div>
				 </div>
				<?php
		}

  }
}

$wlwh_button_object = new wlwh_create_button;
$options = get_option( 'wlwhplugin_settings' );

if( isset( $options[ 'select' ] ) ) {
	$option_selected = sanitize_text_field($options[ 'select' ]);
	if($option_selected == "option_one"){
			add_action( 'woocommerce_before_add_to_cart_button', array($wlwh_button_object , 'wlwh_add_button'),2 );
	} else if($option_selected == "option_two"){
			add_action( 'woocommerce_product_meta_start', array($wlwh_button_object , 'wlwh_add_button'),2 );
	} else {
				// user wants to add shortcode or no button needed
	}


}
