<?php

/* Template Name: wishlist */

get_header();
?>



<!-- MAIN CONTENT
============================================ -->
<div class="page-wishlist" id="wish-container">
			<?php
			$options = get_option('wlwhplugin_settings');

			?>
			<div class ="wish-header">
					<h1> <?php if( isset( $options[ 'wlwh_label' ] ) ) { _e( $options['wlwh_label'] );} ?></h1>
			</div>
			<?php

			$wishListIds = array();
			if(is_user_logged_in()){
          $currentUserId = get_current_user_id();
          $userTitle = "wlwh_user_" . $currentUserId ;
			    $args = array(
						   	'title'	=> $userTitle,
								'post_type' => 'wish'
		      );
					$wishQuery = new WP_Query($args);
					$count = $wishQuery->found_posts;
			    $wishQuery->the_post();
			    $productId = sanitize_text_field(get_post_meta(get_the_ID(),'wishids',true));
			    if( $productId){
					          $wishListIds = array_reverse(explode(',',$productId));
					} else { //no products in wish list
											_e("No products in  your wish list");
					}
											 //	print_r($wishListIds);
			} //  if user logged in
			else { //user not logged so look for cookie
						//	 				_e("Please log in to see your wish list");
						$cookie_time = 30;
						$cookie_days = $cookie_time * 86400 ;
						if( isset( $_COOKIE['wlwhguest'] ) ){
									$prev_val = $_COOKIE['wlwhguest'] ;
									$prev_val = stripslashes($prev_val);
									$wishListIds = unserialize($prev_val);
						}
			}
			if(!empty($wishListIds)){
		    				foreach ($wishListIds as $wishListId) {
		    					//print_r($wishListId);
		    			       if($wishListId){
		    					         $currentproduct = wc_get_product( $wishListId );
		    					         ?>
		    					         <div id = "<?php _e($wishListId) ; ?>" class="page-wishlist__row " >

		                            <div class = "col-2">
		    									           <a href=" <?php _e(get_permalink($wishListId)) ?>" >
		    										         <?php
		    												     if(has_post_thumbnail( $wishListId)){
		    													             _e(get_the_post_thumbnail( $wishListId, 'thumbnail' ));
		    												    }
		    										    	  ?>
		    										        </a>
		                           </div>  <!-- end of col-2   -->

		            							<div class="col-4">
		            											<a href=" <?php _e(get_permalink($wishListId)) ; ?>" >
		            											<div class = "page-wishlist__title">
		            												     <?php _e($currentproduct->get_title()); ?>
		            									    </div>
		            								    	</a>
		            								    	<div class = "page-wishlist__price">
		            								    		<?php _e($currentproduct->get_price_html()) ; ?>
		            								    	</div>
																			<a href= "<?php _e( $currentproduct->add_to_cart_url() ); ?>" >
																				<!--  Now del this product from wish list as it is added to cart -->
		            									   			<div class = "page-wishlist__innerflex">
		            											     				<span class="fa fa-shopping-cart page-wishlist__carticon ">Add to Cart
		            												   				</span>

		            										       </div>
																			</a>
		            							</div>

		            								<div class= "col-5">

		            											<div class = "page-wishlist__desc">
		            													<?php

																					$optionChosen ='1';
																					if( isset( $options['radio'] ) ) {
																							$optionChosen = $options['radio'];
																							if( $optionChosen == '1'){
																										_e($currentproduct->get_short_description()) ;
																							} else if ( $optionChosen == '2'){
																										_e($currentproduct->get_description()) ;
																							} else if ( $optionChosen == '3'){

																							}
		                                      }
		                                       ?>
		          											   </div>

		            								</div>
												<?php
												$rest_url = get_rest_url();
												if (strpos($rest_url,'wp-json') != false){
														$is_json=true;
												} else {
														$is_json=false;;
												}
												?>
		        								<div class= "col-1 page-wishlist__trashicon ">
		        									<span class="fa fa-trash trashwishitem"  aria-hidden="true" data-trashjson = "<?php _e($is_json); ?> "  data-trashitem ="<?php _e($wishListId)  ; ?>"></span>
		        								</div>
		      							</div>

		    				<?php
		              } // if wish list id ..
		    				}   //foreach
					} // if $wishListIds ! empty
					else {
							?> <div class ="no_products"> <?php
							_e("No Products in the Wish List Found");
							?> </div> <?php
					}



			// we have ids of products in $productId,  we have to fetch data for these ids



			?>
    	</div> <!--col-md-10  -->
<?php

get_footer();
