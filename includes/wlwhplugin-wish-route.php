<?php

add_action('rest_api_init', 'wlwhRegisterLike');

function wlwhRegisterLike() {
	register_rest_route('wlwh/v1', 'manageWish', array(
		'methods' => 'POST',
		'callback' => 'createWish'
	));

	register_rest_route('wlwh/v1', 'manageWish', array(
		'methods' => "DELETE",
		'callback' => 'removeWish'
	));
}

function createWish($data) {
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

	 else { // create a cookie
		 			 // some other day
					 /*
					$product_id = get_the_ID();
        	$wlwhguest = 'wlwhguest';
					$cookie_time = 30;
					$cookie_days = $cookie_time * 86400 ;
					if( !isset( $_COOKIE['wlwhguest'] ) ) {
        			//print_r("cookie empty");
        			$wlwhval = array($product_id);
        			$wlwhval = serialize($wlwhval);
        			setcookie('wlwhguest', $wlwhval, time() + $cookie_days ,'/',COOKIE_DOMAIN);
        			$_COOKIE['wlwhguest'] = $wlwhval;
        	} else {
        			$prev_val = $_COOKIE['wlwhguest'] ;
        			$prev_val = stripslashes($prev_val);
        			$array_val = unserialize($prev_val);
        			if(in_array($product_id, $array_val)){
									// already there so do nothing or may be bring in front later
		            } else { // not in array so add
		                 	array_unshift($array_val, $product_id ); //add it to array
		                    $new_wlwh_val = serialize($array_val);
		                    setcookie('wlwhguest', $new_wlwh_val, time() + $cookie_days,'/',COOKIE_DOMAIN);
		                    $_COOKIE['wlwhguest'] = $new_wlwh_val;
		                 }
        		}   // else outer
						*/
						die("Only logged in users can create a wish list");
	}

}

function removeWish($data) {
if (is_user_logged_in()){
		$productId = sanitize_text_field($data['productId']);
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

	}
}
