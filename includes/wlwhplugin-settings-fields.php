<?php

function wlwhplugin_settings() {
  // If plugin settings don't exist, then create them
  if( false == get_option( 'wlwhplugin_settings' ) ) {
      add_option( 'wlwhplugin_settings' );
  }

  // Define (at least) one section for our fields
  add_settings_section(
    // Unique identifier for the section
    'wlwhplugin_settings_section',
    // Section Title
    __( '', 'wlwhplugin' ),
    // Callback for an optional description
    'wlwhplugin_settings_section_callback',
    // Admin page to add section to
    'wlwhplugin'
  );

    // Input Text Field
  add_settings_field(
    // Unique identifier for field
    'wlwhplugin_settings_label_text',
    // Field Title
    __( 'Label for Wish List ', 'wlwhplugin'),
    // Callback for field markup
    'wlwhplugin_settings_label_text_callback',
    // Page to go on
    'wlwhplugin',
    // Section to go in
    'wlwhplugin_settings_section'
  );

  register_setting(
    'wlwhplugin_settings',
    'wlwhplugin_settings'
  );

}

add_action( 'admin_init', 'wlwhplugin_settings' );

function wlwhplugin_settings_section_callback() {

  esc_html_e( '', 'wlwhplugin' );

}

function wlwhplugin_settings_label_text_callback() {

  $options = get_option( 'wlwhplugin_settings' );

	$wlwh_label = '';
	if( isset( $options[ 'wlwh_label' ] ) ) {
		$wlwh_label = esc_html( $options['wlwh_label'] );
	}

  echo '<input type="text" id="wlwhplugin_labeltext" name="wlwhplugin_settings[wlwh_label]" value="' . $wlwh_label . '" />';

}
