<?php

add_action('rest_api_init', 'wlwhManageEmail');

function wlwhManageEmail() {
	register_rest_route('wlwh/v1', 'sendemail', array(
		'methods' => 'POST',
		'callback' => 'sendMail'
	));

}


function sendMail($data) {
    $productId = sanitize_text_field($data['productId']);

		$post_id = sanitize_text_field($data['postId']);

		$user_id=substr(get_the_title($post_id),10 ) ;
		//echo $user_id;
		$user_info=get_userdata($user_id);
		$to = $user_info->user_email;

		$options = get_option( 'wlwhplugin_email_settings' );
		$subject = $options['wlwh_email_subject'];
		$message1 = $options['wlwh_email_content_before'];
		$message2 = $options['wlwh_email_content_after'];


		$currentproduct = wc_get_product( $productId );
		$currentThumbnail = get_the_post_thumbnail( $productId, array(50,50) );
		$currentTitle = $currentproduct->get_title();
		$currentPrice = $currentproduct->get_price_html();
		$productDetails = $currentThumbnail.$currentTitle.$currentPrice;

		$message = $message1.$productDetails.$message2;
		$headers = array('Content-Type: text/html; charset=UTF-8');


	//	wp_die();

		$mailSent = wp_mail( $to, $subject, $message, $headers );
		return $mailSent;
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
