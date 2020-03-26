<?php
// donot allow duplicate enteries

if(!function_exists('wlwhRegisterLike')){
			function wlwhRegisterLike() {
				register_rest_route('wlwh/v1', 'manageWish', array(
					'methods' => 'POST',
					'callback' => 'wlwh_createWish'
				));

				register_rest_route('wlwh/v1', 'manageWish', array(
					'methods' => "DELETE",
					'callback' => 'wlwh_removeWish'
				));
			}

			add_action('rest_api_init', 'wlwhRegisterLike');

}


if(!function_exists('wlwh_createWish')){
	function wlwh_createWish($data) {
		if (is_user_logged_in()) {

			$productId = sanitize_text_field($data['productId']);
			$currentUser = get_current_user_id();
			// Only add a like if the current user has not liked the product already AND
			// make sure the ID of the product actually exists
			$userTitle = "wlwh_user_" . $currentUser;
			$wishpost = get_page_by_title($userTitle,'' , 'wish');
			$wishpostId = $wishpost->ID;

			if ( $wishpostId ){ 		//wish list exists so append
				//$wishpostId = $wishpost->ID;
				$prvWishId =sanitize_text_field(get_post_meta($wishpostId,'wishids',true));




				if($prvWishId){
					// first remove any old entry

								$arrayofWishListIds = explode(',',$prvWishId);
								// remove the entry of $productId from array and implode

								$key = array_search($productId,$arrayofWishListIds);
								if($key!==false){
										unset($arrayofWishListIds[$key]);
								}

								$prvWishId =  sanitize_text_field(implode(",",$arrayofWishListIds));


					// then add new entry
					$wishIdStr= $prvWishId.",".$productId ;
				} else {
					$wishIdStr=$productId;
				}


			} else {
				$wishIdStr=$productId; // wish list does not exist
			}


			// create new wish post
				return wp_insert_post(array(
					'post_type' => 'wish',
					'ID'		=> $wishpostId ,
					'post_status' => 'publish',
					//'post_title' => 'PHP title post test',
					'post_title' => $userTitle,
					'meta_input' => array(
						'wishids' => sanitize_text_field($wishIdStr)

					)
				));

			}

		 else { // user not logged so create a cookie
						//	die("Only logged in users can create a wish list");

					//	setcookie('wlwhguest', "", 1,'/',COOKIE_DOMAIN);
					//	return "del cookie";
						$productId = sanitize_text_field($data['productId']);
						$wlwhguest = 'wlwhguest';
						$cookie_time = 30;

//						if( isset( $this->options['cookie_time'] )  ){
//								$cookie_time = esc_html( $this->options['cookie_time'] );
//						}

						$cookie_days = $cookie_time * 86400 ;
						if( !isset( $_COOKIE['wlwhguest'] ) ) {
							//print_r("cookie empty");
							$wlwhval = array($productId);
							$wlwhval = serialize($wlwhval);
							setcookie('wlwhguest', $wlwhval, time() + $cookie_days ,'/',COOKIE_DOMAIN);
							$_COOKIE['wlwhguest'] = $wlwhval;
							//return $wlwhval;
						} else { // reset cookie
									$prev_val = $_COOKIE['wlwhguest'] ;
									$prev_val = stripslashes($prev_val);
									$array_val = unserialize($prev_val);
									if(!in_array($productId,$array_val)){
											array_unshift($array_val, $productId ); //add it to array
											$new_wlwh_val = serialize($array_val);
											setcookie('wlwhguest', $new_wlwh_val, time() + $cookie_days,'/',COOKIE_DOMAIN);
											$_COOKIE['wlwhguest'] = $new_wlwh_val;
									}

									return $array_val;

						}   // else reset cookie

					return $wlwhval;


		}  //// create cookie ends

	}

}


if(!function_exists('wlwh_removeWish')){
	function wlwh_removeWish($data) {
			$productId = sanitize_text_field($data['productId']);
			if (is_user_logged_in()){

					$currentUser = get_current_user_id();

					$userTitle = "wlwh_user_" . $currentUser;

					$wishpost = get_page_by_title($userTitle,'' , 'wish');
					$wishpostId = $wishpost->ID;

					if ( $wishpostId ){  // wish list exists so delete this product id
						$prvproductId = sanitize_text_field(get_post_meta($wishpostId,'wishids',true));
						$arrayofWishListIds = explode(',',$prvproductId);
						// remove the entry of $productId from array and implode

						$key = array_search($productId,$arrayofWishListIds);
						if($key!==false){
								unset($arrayofWishListIds[$key]);
						}

						$strWishLishUpdated =  sanitize_text_field(implode(",",$arrayofWishListIds));


						update_post_meta($wishpostId,'wishids',$strWishLishUpdated);
					}
				} else { // delete from cookie
						$cookie_time = 30;

//						if( isset( $this->options['cookie_time'] )  ){
//								$cookie_time = esc_html( $this->options['cookie_time'] );
//						}

						$cookie_days = $cookie_time * 86400 ;
						if( isset( $_COOKIE['wlwhguest'] ) ){
							$prev_val = $_COOKIE['wlwhguest'] ;
							$prev_val = stripslashes($prev_val);
							$array_val = unserialize($prev_val);

							if(in_array($productId,$array_val)){
									// del the entry from the array
									$index = array_search($productId,$array_val);

									unset($array_val[$index]);
									$array_val=array_values($array_val);
									$new_wlwh_val = serialize($array_val);
									setcookie('wlwhguest', $new_wlwh_val, time() + $cookie_days,'/',COOKIE_DOMAIN);
									$_COOKIE['wlwhguest'] = $new_wlwh_val;
									return $new_wlwh_val;
							}
						}


				}
	}

}
