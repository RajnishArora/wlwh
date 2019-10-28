<?php

/* Template Name: wishlist */

get_header();

?>


<!-- MAIN CONTENT
============================================ -->
<div class="container page-wishlist" id="wish-container">
	<div class="row">

		<div class="col-sm-12">
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
    				<ul class="min-list">
    				<?php
    				foreach ($wishListIds as $wishListId) {
    					//print_r($wishListId);
    			       if($wishListId){
    					         $currentproduct = wc_get_product( $wishListId );
    					         ?>
    					         <li id = "<?php echo $wishListId ; ?>" class="page-wishlist__li " >

                       <div class = "row">
    								         <div class = "col-2">
    									           <a href=" <?php echo get_permalink($wishListId) ?>" >
    										         <div class= "row">
    											            <div>
    												               <?php
    												               if(has_post_thumbnail( $wishListId)){
    													             echo get_the_post_thumbnail( $wishListId, 'thumbnail' );
    												               }
    										    	             ?>
    										              </div>
    										        </div>
    									       </a>
                           </div>  <!-- end of col-2   -->

            							<div class="col-2">
            									<div class = "page-wishlist__tp">
            										<a href=" <?php echo get_permalink($wishListId) ?>" >
            											<div class = "page-wishlist__title">
            												<?php echo $currentproduct->get_title(); ?>
            									    	</div>
            								    	</a>
            								    	<div class = "page-wishlist__price">
            								    		<?php echo $currentproduct->get_price_html(); ?>
            								    	</div>
            									   	<div>
            											 <a href="<?php echo $currentproduct->add_to_cart_url(); // Now del this product from wish list as it is added to cart ?>" >
            												<span class="fa fa-shopping-cart d-lg-none page-wishlist__carticon ">
            												</span>
            												<span class ="d-none d-lg-flex page-wishlist__addtocartbtn">Add to Cart
            											 	</span>
            										    </a>
            										</div>
            									</div>

            								</div>

            								<div class= "col-4">
            										<div class= "row">
            											<div class = "page-wishlist__desc">

            												<div>
            													<?php //echo $currentproduct->get_description();
                                      //$short_description = '';
                                      //$short_description = $currentproduct->get_short_description();
                                      echo $currentproduct->get_short_description();

                                      ?>
            												</div>
            											</div>
            										</div>
            								</div>

                        <div class= "col-1">
                        </div>

        								<div class= "col-1 page-wishlist__trashicon ">
        									<span class="fa fa-trash trashwishitem"  aria-hidden="true" data-trashitem ="<?php echo $wishListId ; ?>"></span>
        								</div>
      							</div>

    					</li>
    				<?php
    					}
    				}   //foreach

    				echo '</ul>';
				} else { //no products in wish list
					echo("No products in  your wish list");
				}

			}
			// we have ids of products in $productId,  we have to fetch data for these ids

			} //  if user logged in
			else {
				echo("Please log in to see your wish list");
			}

			?>



    	</div> <!--col-md-10  -->


  	</div>
</div>


<?php

get_footer();
