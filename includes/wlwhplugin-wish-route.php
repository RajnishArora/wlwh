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
			$prvWishId = get_post_meta($wishpostId,'wishids',true);
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
					'wishids' => $wishIdStr

				)
			));

		}

	 else {
		die("Only logged in users can create a like");
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
			$prvproductId = get_post_meta($wishpostId,'wishids',true);
			$arrayofWishListIds = explode(',',$prvproductId);
			// remove the entry of $productId from array and implode

			$key = array_search($productId,$arrayofWishListIds);
			if($key!==false){
    			unset($arrayofWishListIds[$key]);
			}

			$strWishLishUpdated =  implode(",",$arrayofWishListIds);


			update_post_meta($wishpostId,'wishids',$strWishLishUpdated);
		}
	}
}
