<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

if(!function_exists('wlwhManageEmail')){
	function wlwhManageEmail() {
		register_rest_route('wlwh/v1', 'sendemail', array(
			'methods' => 'POST',
			'callback' => 'wlwh_sendMail'
		));

	}

	add_action('rest_api_init', 'wlwhManageEmail');


}




if(!function_exists('wlwh_sendMail')){
	function wlwh_sendMail($data) {
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
			//wp_kses($str,$arr) ends;

			$productId = sanitize_text_field($data['productId']);
			$post_id = sanitize_text_field($data['postId']);
			$to = sanitize_email($data['mailto']);
			$subject = sanitize_text_field($data['mailsub']);
			$message = wp_kses($data['emailmsg'] , $allowed_html);
			$headers = array('Content-Type: text/html; charset=UTF-8');
			$mailSent = wp_mail( $to, $subject, $message, $headers );
			return $mailSent;
	}

}
