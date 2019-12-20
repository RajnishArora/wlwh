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

'add_new_item' => __('Add User','wlwhplugin'),

$html = '<input type="radio" id="wlwhplugin_settings_radio_bottomleft" name="wlwhplugin_settings[heart_place]" value="3"' . checked( 3, $radio, false ) . '/>';
$html .= ' <label for="wlwhplugin_settings_radio_bottomleft">'. $args['option_bottomleft'] .'</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$html .= '<input type="radio" id="wlwhplugin_settings_radio_bottomright" name="wlwhplugin_settings[heart_place]" value="4"' . checked( 4, $radio, false ) . '/>';
$html .= ' <label for="wlwhplugin_settings_radio_bottomright">'. $args['option_bottomright'] .'</label>';


var img = document.getElementById('imageid');
//or however you get a handle to the IMG
var width = img.clientWidth;
var height = img.clientHeight;


<?php
$optionChosen ='1';
if( isset( $this->options['heart_place'] ) ) {
		$optionChosen = $this->options['heart_place'];
		if( $optionChosen == '1'){ ?>

		<?php
	} else if ( $optionChosen == '2'){ ?>
				<span class="wish-box  hidden wish-box_hover" style = " cursor:url('<?php _e($heart_url) ;  ?>' ) 6 6 ,cell" data-exists="<?php _e($existStatus); ?>"  data-product-id="<?php _e($currentProductId) ; ?>"  data-logged="<?php _e($logged); ?>">
		<?php
	} else if( $optionChosen == '3' ){ ?>
			<span class="wish-box  hidden wish-box_hover" style = " cursor:url('<?php _e($heart_url) ;  ?>' ) 6 6 ,cell" data-exists="<?php _e($existStatus); ?>"  data-product-id="<?php _e($currentProductId) ; ?>"  data-logged="<?php _e($logged); ?>">
		<?php
	} else if( $optionChosen == '4' ){ ?>
			<span class="wish-box  hidden  wish-box_hover" style = " cursor:url('<?php _e($heart_url) ;  ?>' ) 6 6 ,cell" data-exists="<?php _e($existStatus); ?>"  data-product-id="<?php _e($currentProductId) ; ?>"  data-logged="<?php _e($logged); ?>">
		<?php
	}
}
 ?>
 //$user_id=substr(get_the_title($post_id),10 ) ;
 //echo $user_id;
 //$user_info= get_userdata($user_id);
 //$to = sanitize_email($user_info->user_email);

 //$options = get_option( 'wlwhplugin_email_settings' );
 //$subject = sanitize_text_field($options['wlwh_email_subject']);
 //$message1 = sanitize_textarea_field($options['wlwh_email_content_before']);
 //$message2 = sanitize_textarea_field($options['wlwh_email_content_after']);


 //$currentproduct = wc_get_product( $productId );
 //$currentThumbnail = get_the_post_thumbnail( $productId, array(100,100) );
 //$currentTitle = $currentproduct->get_title();
 //$currentPrice = $currentproduct->get_price_html();
 //$productDetails = $currentThumbnail."  ".$currentTitle."  ".$currentPrice;

 //$message = $message1."<br>".$productDetails."<br>".$message2;


 /******************************
    WISH LIST
 ******************************/


 .wish-box{
       /*  height: 20px;
     width: 20px;
   */
     color: #ff0000;
     font-size:1.5rem;
     z-index: 100;
 }

 .wish-box-topleft{
     position: absolute;
     left: 20px;
     top: 20px;
 }

 .wish-box_hover{
   transform: rotate(30deg);
 }

 .wish-box:hover {
         transform: scale(1.4,1.4) !important;
 }

 .wish-box .fa-heart {
     position: absolute;
     visibility: hidden;
     transition: all .1s ease-out;
     transform: scale(.2);
     opacity: 0;
 }

 .fa-heart{
     left: 0;
 }

 .wish-box .fa-heart-o {
     left: 0;
     position: absolute;
 }

 .wish-box[data-exists="yes"] .fa-heart {
     position: absolute;
     transform: scale(1);
     visibility: visible;
     opacity: 1;
 }

 .wish-box[data-exists="yes"] .fa-heart-o {
     position: absolute;
     visibility: hidden;
     opacity: 0;
 }

 .wish-button{
     background-color: #e8e8eb;
     margin-left: 12px;
     margin-right: auto;
     margin-top: auto;
     margin-bottom: auto;
     color: #000000;
     padding: 12px;
     box-sizing: border-box;
     cursor: pointer;
 }

 .wish-button:hover{
     color: #ff0000;
 }

 .added-wish {
   position: relative;
   left: 30px;
   top: -10px;
   color: #ff0000;
   font-size:1rem;

 }


 .hidden  {
   display: none;
 }

 .show {
   display: block;
 }

 .wish-header {
   text-align: center;
 }

 transition: all .1s ease-out;
 transform: scale(.2);



 //		console.log(currentWishBox.attr('data-exists'));

 //currentWishBox.html( `
 //                      <i class = "fa fa-heart-o "></i>
 //                      <i class = "fa fa-heart"></i>
 //                      `);
 //let textToDisplay = $(allWishBoxes[i]).next('span');
 //console.log(textToDisplay)

 //  currentWishBox.html( `
 //                      <i class = "fa fa-heart-o "></i>
 //                      <i class = "fa fa-heart"></i>
 //                      `);

 	//currentWishBox.attr('data-exists', 'no');
	//this.singleWishBox.attr("data-singleexiststatus",'yes');


	<?php
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
	/*
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup server
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'jswan';                            // SMTP username
	$mail->Password = 'secret';                           // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted




	define( 'SMTP_USER',   'user@example.com' );    // Username to use for SMTP authentication
	define( 'SMTP_PASS',   'smtp password' );       // Password to use for SMTP authentication
	define( 'SMTP_HOST',   'smtp.example.com' );    // The hostname of the mail server
	define( 'SMTP_FROM',   'website@example.com' ); // SMTP From email address
	define( 'SMTP_NAME',   'e.g Website Name' );    // SMTP From name
	define( 'SMTP_PORT',   '25' );                  // SMTP port number - likely to be 25, 465 or 587
	define( 'SMTP_SECURE', 'tls' );                 // Encryption system to use - ssl or tls
	define( 'SMTP_AUTH',    true );                 // Use SMTP authentication (true|false)
	define( 'SMTP_DEBUG',   0 );                    // for debugging purposes only set to 1 or 2

	add_action( 'phpmailer_init', function( $phpmailer ) {
		if ( !is_object( $phpmailer ) )
			$phpmailer = (object) $phpmailer;

		$phpmailer->Mailer     = 'smtp';
		$phpmailer->Host       = SMTP_HOST;
		$phpmailer->SMTPAuth   = SMTP_AUTH;
		$phpmailer->Port       = SMTP_PORT;
		$phpmailer->Username   = SMTP_USER;
		$phpmailer->Password   = SMTP_PASS;
		$phpmailer->SMTPSecure = SMTP_SECURE;
		$phpmailer->From       = SMTP_FROM;
		$phpmailer->FromName   = SMTP_NAME;
	});
