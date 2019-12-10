<button type="button" name = "emailbutton" value = "Send mail"> Send Mail </button>

//create-metabox.php
<?php

if( !class_exists('wlwh_create_metabox')){

	class wlwh_create_metabox{

		public function __construct(){

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
					global $post;
					$user_id=substr(get_the_title($post->ID),10 ) ;
					$user_info=get_userdata($user_id);
					// email panga ends
		      ?>

		      <p>

		          <label>Wish List</label><br />
		          <input type="text" name="wishids" value="<?php _e($custom["wishids"][0]); ?>" />

							<a href="mailto: <?php _e($user_info->user_email); ?> ?Subject=Khareed%20le&amp;body=Abe yeh teri wish list mein tha khareedna hai kya "> &nbsp Send mail to <?php echo $user_info->display_name ; ?></a>
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


// create metabox ends



// wish route
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
	} else { // delete from cookie

	}
}
// wish route ends


<a class = "metabox__title" href="mailto: <?php _e($user_info->user_email); ?> ?Subject=<?php _e($subject); ?>&amp;body=<?php _e($emailContent); ?> ">

/*
if( 'wlwhplugin_complete_checkbox' == cc ) {
		if( $('#wlwhplugin_short_checkbox').is( ':checked') ){
				$('#wlwhplugin_short_checkbox').prop('checked',false);
		} else {
				$('#wlwhplugin_short_checkbox').prop('checked',true);
		}
}
if( 'wlwhplugin_short_checkbox' == cc ){
	if( $('#wlwhplugin_complete_checkbox').is( ':checked') ){
			$('#wlwhplugin_complete_checkbox').prop('checked',false);
	} else {
			$('#wlwhplugin_complete_checkbox').prop('checked',true);
	}
}
*/




  $short_checkbox = '';
  if( isset( $options[ 'short_checkbox' ] ) ) {
    $short_checkbox = esc_html( $options['short_checkbox'] );
  }
  $short_html = '<input type="checkbox" id="wlwhplugin_short_checkbox" name="wlwhplugin_settings[short_checkbox]" value="1"' . checked( 1, $short_checkbox, false ) . '/>';
  $short_html .= '&nbsp;';
  $short_html .= '<label for="wlwhplugin_short_checkbox">' . " Short description" . '</label>';
  $short_html .= '&nbsp;';$short_html .= '&nbsp;';$short_html .= '&nbsp;';$short_html .= '&nbsp;';
  $short_html .= '&nbsp;';$short_html .= '&nbsp;';$short_html .= '&nbsp;';$short_html .= '&nbsp;';

  _e($short_html);

  $complete_checkbox = '';
  if( isset( $options[ 'complete_checkbox' ] ) ) {
    $complete_checkbox = esc_html( $options['complete_checkbox'] );
  }
  $complete_html = '<input type="checkbox" id="wlwhplugin_complete_checkbox" name="wlwhplugin_settings[complete_checkbox]" value="1"' . checked( 1, $complete_checkbox, false ) . '/>';
  $complete_html .= '&nbsp;';
  $complete_html .= '<label for="wlwhplugin_complete_checkbox">' . "Full description" . '</label>';
  _e($complete_html);



	var cc = e.target.id;

	if( 'wlwhplugin_complete_checkbox' == cc ) {
			if( ($('#wlwhplugin_short_checkbox').prop('checked') == false) && ($('#wlwhplugin_complete_checkbox').prop('checked') == false)  ){
					$('#wlwhplugin_short_checkbox').prop('checked',true);
					$('#wlwhplugin_complete_checkbox').prop('checked',false);
			}
			if( $('#wlwhplugin_complete_checkbox').is( ':checked') ){
					$('#wlwhplugin_short_checkbox').prop('checked',false);
			} else {
					$('#wlwhplugin_short_checkbox').prop('checked',true);
			}
	}
	if( 'wlwhplugin_short_checkbox' == cc ){
		if( $('#wlwhplugin_complete_checkbox').is( ':checked') ){
				$('#wlwhplugin_complete_checkbox').prop('checked',false);
		} else {
				$('#wlwhplugin_complete_checkbox').prop('checked',true);
		}
	}

	function(rep){
		if(rep == true) {
			alert("Mail Sent"); //repalce alert by custom message box
		}
		else if(rep == false) {
			alert("Mail couldnot be sent. Please check server settings");
		}
	}



	/*
	add_action( 'phpmailer_init', 'mailer_config', 10, 1);
	function mailer_config(PHPMailer $mailer){
	  $mailer->IsSMTP();
	  $mailer->Host = "mail.telemar.it"; // your SMTP server
	  $mailer->Port = 25;
	  $mailer->SMTPDebug = 2; // write 0 if you don't want to see client/server communication in page
	  $mailer->CharSet  = "utf-8";
	}
	*/
