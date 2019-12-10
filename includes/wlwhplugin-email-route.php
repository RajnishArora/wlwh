<?php

add_action('rest_api_init', 'wlwhManageEmail');

function wlwhManageEmail() {
	register_rest_route('wlwh/v1', 'sendemail', array(
		'methods' => 'POST',
		'callback' => 'sendMail'
	));

}


function sendMail($data) {
		// wp_kses_allowed_html
		$allowed_html = array(
										'br' => array(),
										'span' => array(
															'class'=>array(),
															'id' 	 =>array()
															),
										'img' => array(
            								'alt' => array(),
														'height' => array(),
									          'src' => array(),
														'srcset' => array(),
									          'width' => array(),
									          'class' => array(),
									          'id' => array(),
									          'style' => array(),
									          'title' => array()

													),
										 'div'	=> array(
														 'class'=>array(),
														 'id' 	 =>array()
										 			),
										 'a'		=> array(
											 			'href'	=> array(),
														'class'	=> array()
										 )
									);
		//wp_kses($str,$arr);


    $productId = sanitize_text_field($data['productId']);
		$post_id = sanitize_text_field($data['postId']);
		$to = sanitize_email($data['mailto']);
		$subject = sanitize_text_field($data['mailsub']);
		$message = wp_kses($data['emailmsg'] , $allowed_html);
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

		$headers = array('Content-Type: text/html; charset=UTF-8');
		// show it to user before sending so that he can edit
		// pending because of sanitaion issues
		//use wp_kses and wp_kses_allowed_html
		$mailSent = wp_mail( $to, $subject, $message, $headers );
		return $mailSent;
}
