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
					<h1> <?php _e( $options['wlwh_label'] ); ?></h1>
			</div>
			<?php
			if(is_user_logged_in()){
          $currentUserId = get_current_user_id();
          $userTitle = "wlwh_user_" . $currentUserId ;
			    $args = array(
						   'title'	=> $userTitle,
					     'post_type' => 'wish'
		      );
			$wishQuery = new WP_Query($args);
			$count = $wishQuery->found_posts;

			if($count==1){  // one user has only one wish list
				    $wishQuery->the_post();
				    $productId = get_post_meta(get_the_ID(),'wishids',true);
				    //	print_r($productId);
				    if( $productId){
				          $wishListIds = explode(',',$productId);
				           //	print_r($wishListIds);
				     ?>

    				<?php
    				foreach ($wishListIds as $wishListId) {
    					//print_r($wishListId);
    			       if($wishListId){
    					         $currentproduct = wc_get_product( $wishListId );
    					         ?>
    					         <div id = "<?php _e($wishListId) ; ?>" class="page-wishlist__row " >

                            <div class = "col-3">
    									           <a href=" <?php _e(get_permalink($wishListId)) ?>" >
    										         <?php
    												     if(has_post_thumbnail( $wishListId)){
    													             _e(get_the_post_thumbnail( $wishListId, 'thumbnail' ));
    												    }
    										    	  ?>
    										        </a>
                           </div>  <!-- end of col-2   -->

            							<div class="col-3">
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
																			if( isset( $options[ 'complete_checkbox' ] ) ) {
                                            _e($currentproduct->get_description()) ;
																			} else {
																						_e($currentproduct->get_short_description()) ;
																			}
                                       ?>
          											   </div>

            								</div>

        								<div class= "col-1 page-wishlist__trashicon ">
        									<span class="fa fa-trash trashwishitem"  aria-hidden="true" data-trashitem ="<?php _e($wishListId)  ; ?>"></span>
        								</div>
      							</div>

    				<?php
              } // if wish list id ..
    				}   //foreach


				} else { //no products in wish list
					_e("No products in  your wish list");
				}

			}   // $count = 1
			// we have ids of products in $productId,  we have to fetch data for these ids

			} //  if user logged in
			else {
				_e("Please log in to see your wish list");
			}

			?>
    	</div> <!--col-md-10  -->
<?php

get_footer();
