<?php


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

							die("Only logged in users can create a wish list");
		}

	}

}


if(!function_exists('wlwh_removeWish')){
	function wlwh_removeWish($data) {
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

}
