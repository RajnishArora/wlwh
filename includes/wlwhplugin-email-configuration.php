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
