<?php

if( !class_exists('wlwh_create_metabox')){

	class wlwh_create_metabox{

		public function __construct(){
			$this->options = get_option( 'wlwhplugin_email_settings' );

		}

		public function add_wlwh_meta_box(){
			add_meta_box("wlwh_meta", esc_html("Wish List"), array($this,'add_wish_list_meta_box'), "wish", "normal", "low");
		}

		public function add_wish_list_meta_box(){
		      global $post;
					// add nonce fiels here & check before storing data
					wp_nonce_field( basename( __FILE__ ), 'wlwh_meta_box_nonce' );
		      $custom = get_post_custom( $post->ID );
					// Retrieve post meta fields, based on post ID.
					// since we have 1 custom field so array [0]

					//starting email panga
					$user_id=substr(get_the_title($post->ID),10 ) ;
					$user_info=get_userdata($user_id);
					// email panga ends
		      ?>

		      <p>
		          <input type="hidden" name="wishids" value="<?php _e($custom["wishids"][0]); ?>" />
	      	</p>

					<p>
						<?php

						//$str = date("l jS \of F Y h:i:s A");
						//echo $str;
						$wishString  = $custom["wishids"][0] ;
						$wishListIds = explode(',',$wishString);
						$options = get_option( 'wlwhplugin_email_settings' );

						foreach ($wishListIds as $wishListId) {
							//print_r($wishListId);
								 if($wishListId){
											 $currentproduct = wc_get_product( $wishListId );
											 $currentThumbnail = get_the_post_thumbnail( $wishListId, array(50,50) );
											 $currentTitle = $currentproduct->get_title();
											 $currentPrice = $currentproduct->get_price_html();
											// $emailContent = $emailBody . $currentTitle . $currentPrice;
											 ?>

											 <div id = "<?php _e($wishListId) ; ?>" class="metabox__row " >
														<div class = "col-2">
																 <?php
																 if(has_post_thumbnail( $wishListId)){
																					 _e($currentThumbnail);
																}
																?>
													 </div>  <!-- end of col-2   -->

													<div class="col-2">
																	<div class = "metabox__title">
																				 <?php _e($currentTitle); ?>
																	</div>
 													</div>

													<div class= "col-5">
																 <button type="button" class ="emailbutton" data-productid="<?php _e($wishListId);?>" data-postid="<?php _e($post->ID); ?>" >Send mail to <?php echo $user_info->display_name ; ?> about this product</button>
													</div>

										</div>

						<?php
							} // if wish list id ..
							$to = sanitize_email($user_info->user_email);
							$subject = sanitize_text_field($options['wlwh_email_subject']);
							$message1 = sanitize_textarea_field($options['wlwh_email_content_before']);
							$message2 = sanitize_textarea_field($options['wlwh_email_content_after']);
							$products_url = get_permalink($wishListId);
	//						$currentDetails = '<div> Hello php </div> ';
							$productDetails = "<a id ='product_a'>".$currentThumbnail."<br>".$currentTitle."<br>".$currentPrice."</a>";
	//						$productDetails = $currentThumbnail.$currentDetails;
							$message = "<br>".$message1."<br><br>".$productDetails."<br><br>".$message2."<br>";
							?>
							<div class = "modal hidden" id="email-confirm">
								<div  class="modal-content">
										<span class ="heading"> Do you want to send the following email
											<button type="button" class="btn ok okupper okbtn" >Send</button>
											<button type="button" class="btn cancel cancelupper" >Cancel</button>
											<span class = "cross" id = "modalcross">X</span>
										</span>
										<hr>
										<div>
										<br>
										<span> <b> To: </b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										<input type="text" name="to" class = "mailto" size ="80" value="<?php _e($to);?>">
										</div>
										<span> <b>Subject: </b>&nbsp;&nbsp; </span>
										<input type="text" name="subject" class ="mailsub" size="80" value="<?php _e($subject);?>">
										<hr>
										<div><b>Content: </b></div>
										<div id="createmetaboxmsg" contenteditable="true"> <?php _e($message); ?></div>
										<br>
										<button type="button" class="btn ok okbtn" >Send</button>
										<button type="button" class="btn cancel cancelbtn" >Cancel</button>

										<div class ="waiting hidden">
														<img src = "<?php _e( plugin_dir_url( dirname( __FILE__ ) ). 'assets/waiting.gif' );?> ">
										</div>

									</div>

							</div>
							<?php

						}   //foreach
						?>
					</p>


		      <?php
		}

		public function save_wished_products_custom_fields(){
			  global $post;
				// verify nonce so that save command is coming from this plugin only
				if ( !isset( $_POST['wlwh_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['wlwh_meta_box_nonce'], basename( __FILE__ ) ) ){
						return;
				}

			  if ( $post )
			  {
			    update_post_meta($post->ID, "wishids", sanitize_text_field($_POST["wishids"]));
			  }
		}


	}  // class

}

$wlwh_meta_box_object = new wlwh_create_metabox;
add_action( 'admin_init', array($wlwh_meta_box_object , 'add_wlwh_meta_box') );
add_action('save_post', array($wlwh_meta_box_object , 'save_wished_products_custom_fields') );
