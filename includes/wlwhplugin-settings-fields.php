<?php

function wlwhplugin_settings() {
  // If plugin settings don't exist, then create them
  if( false == get_option( 'wlwhplugin_settings' ) ) {
      add_option( 'wlwhplugin_settings' );
  }
// add a custom post type


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


  // Checkbox Field
  add_settings_field(
    'wlwhplugin_single_selector_checkbox',
    __( 'Show Heart on Single Product', 'wlwhplugin'),
    'wlwhplugin_single_selector_checkbox_callback',
    'wlwhplugin',
    'wlwhplugin_settings_section',
    [
      'label' => 'Click to View on Single Product Page'
    ]
  );


    // Checkbox Field
    add_settings_field(
      'wlwhplugin_other_selector_checkbox',
      __( 'Show Heart on Product Loop ', 'wlwhplugin'),
      'wlwhplugin_other_selector_checkbox_callback',
      'wlwhplugin',
      'wlwhplugin_settings_section',
      [
        'label' => 'Click to View anywhere Product image shows'
      ]
    );


        // Checkbox Field
        add_settings_field(
          'wlwhplugin_show_button_checkbox',
          __( 'Add to WishList (button) ', 'wlwhplugin'),
          'wlwhplugin_show_button_checkbox_callback',
          'wlwhplugin',
          'wlwhplugin_settings_section',
          [
            'label' => 'Click to show on Single Product Page'
          ]
        );

        // Input Text Field
        add_settings_field(
                // Unique identifier for field
                'wlwhplugin_button_text',
                // Field Title
                __( 'Add to WishList Button Text ', 'wlwhplugin'),
                // Callback for field markup
                'wlwhplugin_button_text_callback',
                // Page to go on
                'wlwhplugin',
                // Section to go in
                'wlwhplugin_settings_section'
        );




        // Input Text Field
        add_settings_field(
                // Unique identifier for field
                'wlwhplugin_toast_text',
                // Field Title
                __( 'Add to WishList Toast Text ', 'wlwhplugin'),
                // Callback for field markup
                'wlwhplugin_toast_text_callback',
                // Page to go on
                'wlwhplugin',
                // Section to go in
                'wlwhplugin_settings_section'
        );

        // Input Text Field
      add_settings_field(
        // Unique identifier for field
        'wlwhplugin_settings_label_text',
        // Field Title
        __( 'Title for Wish List Page ', 'wlwhplugin'),
        // Callback for field markup
        'wlwhplugin_settings_label_text_callback',
        // Page to go on
        'wlwhplugin',
        // Section to go in
        'wlwhplugin_settings_section'
      );

/*
    // Checkbox Field
    add_settings_field(
      'wlwhplugin_description_selector_checkbox',
      __( 'Choose which Description to show on WishList Page', 'wlwhplugin'),
      'wlwhplugin_description_selector_checkbox_callback',
      'wlwhplugin',
      'wlwhplugin_settings_section',
      [
        'label' => ' '
      ]
    );
*/

  // Radio Field
  add_settings_field(
    'wlwhplugin_description_selector_checkbox',
    __( 'Choose which Description to show on WishList Page', 'wlwhplugin'),
    'wlwhplugin_description_selector_checkbox_callback',
    'wlwhplugin',
    'wlwhplugin_settings_section',
    [
      'option_one' => 'Short Description',
      'option_two' => 'Long Description'
    ]
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

  _e( '<input type="text" id="wlwhplugin_labeltext" name="wlwhplugin_settings[wlwh_label]" value="' . $wlwh_label . '" />' );

}

function wlwhplugin_single_selector_checkbox_callback( $args ) {

  $options = get_option( 'wlwhplugin_settings' );

  $checkbox = '';
	if( isset( $options[ 'single_checkbox' ] ) ) {
		$checkbox = esc_html( $options['single_checkbox'] );

	}

	$html = '<input type="checkbox" id="wlwhplugin_single_checkbox" name="wlwhplugin_settings[single_checkbox]" value="1"' . checked( 1, $checkbox, false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="wlwhplugin_single_checkbox">' . $args['label'] . '</label>';

	_e($html);

}


function wlwhplugin_other_selector_checkbox_callback( $args ) {

  $options = get_option( 'wlwhplugin_settings' );

  $checkbox = '';
	if( isset( $options[ 'other_checkbox' ] ) ) {
		$checkbox = esc_html( $options['other_checkbox'] );
	}
	$html = '<input type="checkbox" id="wlwhplugin_other_checkbox" name="wlwhplugin_settings[other_checkbox]" value="1"' . checked( 1, $checkbox, false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="wlwhplugin_other_checkbox">' . $args['label'] . '</label>';
	_e($html);
}

function wlwhplugin_show_button_checkbox_callback( $args ) {

  $options = get_option( 'wlwhplugin_settings' );

  $checkbox = '';
	if( isset( $options[ 'show_button' ] ) ) {
		$checkbox = esc_html( $options['show_button'] );
	}


	$html = '<input type="checkbox" id="wlwhplugin_show_button" name="wlwhplugin_settings[show_button]" value="1"' . checked( 1, $checkbox, false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="wlwhplugin_show_button">' . $args['label'] . '</label>';
  $html .= '&nbsp;';$html .= '&nbsp;';
  _e($html);

}

function wlwhplugin_button_text_callback() {

  $options = get_option( 'wlwhplugin_settings' );

	$wlwh_buttontext = '';
	if( isset( $options[ 'wlwh_buttontext' ] ) ) {
		$wlwh_buttontext = esc_html( $options['wlwh_buttontext'] );
	}
  _e( '<input type="text" id="wlwhplugin_buttontext" name="wlwhplugin_settings[wlwh_buttontext]" value="' . $wlwh_buttontext . '" />' );
}


function wlwhplugin_toast_text_callback() {

  $options = get_option( 'wlwhplugin_settings' );

	$wlwh_toast = '';
	if( isset( $options[ 'wlwh_toast' ] ) ) {
		$wlwh_toast = esc_html( $options['wlwh_toast'] );
	}
  _e( '<input type="text" id="wlwhplugin_toasttext" name="wlwhplugin_settings[wlwh_toast]" value="' . $wlwh_toast . '" />' );
}




function wlwhplugin_description_selector_checkbox_callback( $args ) {
  $options = get_option( 'wlwhplugin_settings' );

  $radio = '';
	if( isset( $options[ 'radio' ] ) ) {
		$radio = esc_html( $options['radio'] );
	}

	$html = '<input type="radio" id="wlwhplugin_settings_radio_one" name="wlwhplugin_settings[radio]" value="1"' . checked( 1, $radio, false ) . '/>';
	$html .= ' <label for="wlwhplugin_settings_radio_one">'. $args['option_one'] .'</label> &nbsp;';
	$html .= '<input type="radio" id="wlwhplugin_settings_radio_two" name="wlwhplugin_settings[radio]" value="2"' . checked( 2, $radio, false ) . '/>';
	$html .= ' <label for="wlwhplugin_settings_radio_two">'. $args['option_two'] .'</label>';
  _e($html);
	//echo $html;
}
