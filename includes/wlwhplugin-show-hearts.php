<?php

add_action('woocommerce_before_shop_loop_item_title', 'wlwhplugin_add_wishbox_markup',9);
// this is just before the image
// to add just after icrease the priority to 15 or so
add_action('woocommerce_product_thumbnails', 'wlwhplugin_add_wishbox_markup',30);



function wlwhplugin_add_wishbox_markup (){

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

			$heart_url =  WLWHPLUGIN_URL .'assets/heart.png';

		?>
		<span class="wish-box" style = " cursor:url('<?php echo $heart_url ;  ?>' ) 6 6 ,cell" data-exists="<?php echo $existStatus; ?>" data-product-id="<?php echo $currentProductId ; ?>" >
				<i class = "fa fa-heart-o "></i>
				<i class = "fa fa-heart"></i>
		</span>

	<?php
}
