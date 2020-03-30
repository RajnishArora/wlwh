<?php
if ( ! defined( 'ABSPATH' ) ) {
	die;
}


function wlwhplugin_email_settings() {
  // If plugin settings don't exist, then create them
  if( false == get_option( 'wlwhplugin_email_settings' ) ) {
      add_option( 'wlwhplugin_email_settings' );
  }


  // Define (at least) one section for our fields
  add_settings_section(
    // Unique identifier for the section
    'wlwhplugin_email_settings_section',
    // Section Title
    __( '', 'wlwhplugin_email' ),
    // Callback for an optional description
    'wlwhplugin_email_settings_section_callback',
    // Admin page to add section to
    'wlwhplugin_email'
  );
        // Input Text Field
        add_settings_field(
                // Unique identifier for field
                'wlwhplugin_subject_text',
                // Field Title
                __( 'Email Subject', 'wlwhplugin'),
                // Callback for field markup
                'wlwhplugin_email_subject_callback',
                // Page to go on
                'wlwhplugin_email',
                // Section to go in
                'wlwhplugin_email_settings_section'
        );

        // Input Text Area
        add_settings_field(
                // Unique identifier for field
                'wlwhplugin_email_content_before',
                // Field Title
                __( 'Email Content Before Product', 'wlwhplugin'),
                // Callback for field markup
                'wlwhplugin_email_content_before_callback',
                // Page to go on
                'wlwhplugin_email',
                // Section to go in
                'wlwhplugin_email_settings_section'
        );


                // Input Text Area
                add_settings_field(
                        // Unique identifier for field
                        'wlwhplugin_email_content_after',
                        // Field Title
                        __( 'Email Content After Product', 'wlwhplugin'),
                        // Callback for field markup
                        'wlwhplugin_email_content_after_callback',
                        // Page to go on
                        'wlwhplugin_email',
                        // Section to go in
                        'wlwhplugin_email_settings_section'
                );

  register_setting(
    'wlwhplugin_email_settings',
    'wlwhplugin_email_settings'
  );

}

add_action( 'admin_init', 'wlwhplugin_email_settings' );

function wlwhplugin_email_settings_section_callback() {
  esc_html_e( '', 'wlwhplugin' );
}

function wlwhplugin_email_subject_callback() {
  $options = get_option( 'wlwhplugin_email_settings' );
	$wlwh_label = '';
	if( isset( $options[ 'wlwh_email_subject' ] ) ) {
		$wlwh_label = esc_html( $options['wlwh_email_subject'] );
	}
  //_e( '<textarea rows="1" cols="80" id="wlwhplugin_email_subject" name="wlwhplugin_email_settings[wlwh_email_subject]" value="' . $wlwh_label . '" > </textarea>' );
  _e( '<input id="wlwhplugin_email_subject" size="77" name="wlwhplugin_email_settings[wlwh_email_subject]" value="' . $wlwh_label . '" /> ' );
}


function wlwhplugin_email_content_before_callback() {
  $options = get_option( 'wlwhplugin_email_settings' );
	$wlwh_label = '';
	if( isset( $options[ 'wlwh_email_content_before' ] ) ) {
		$wlwh_label = esc_html( $options['wlwh_email_content_before'] );
	}

  _e('<textarea id="wlwhplugin_email_content_before" name="wlwhplugin_email_settings[wlwh_email_content_before]" rows="5" cols="80">' . $wlwh_label . '</textarea>');;

  //_e( '<textarea rows="15" cols="80" id="wlwhplugin_email_content" name="wlwhplugin_email_settings[wlwh_email_content]" value="'  '" >. $wlwh_label . </textarea>' );
}


function wlwhplugin_email_content_after_callback() {
  $options = get_option( 'wlwhplugin_email_settings' );
	$wlwh_label = '';
	if( isset( $options[ 'wlwh_email_content_after' ] ) ) {
		$wlwh_label = esc_html( $options['wlwh_email_content_after'] );
	}

  _e('<textarea id="wlwhplugin_email_content_after" name="wlwhplugin_email_settings[wlwh_email_content_after]" rows="10" cols="80">' . $wlwh_label . '</textarea>');;

  //_e( '<textarea rows="15" cols="80" id="wlwhplugin_email_content" name="wlwhplugin_email_settings[wlwh_email_content]" value="'  '" >. $wlwh_label . </textarea>' );
}
