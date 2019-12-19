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
          __( 'Show Button ', 'wlwhplugin'),
          'wlwhplugin_show_button_checkbox_callback',
          'wlwhplugin',
          'wlwhplugin_settings_section',
          [
            'label' => 'Click to show on Single Product Page'
          ]
        );

          // Radio Field
          add_settings_field(
            'wlwhplugin_heart_place_radio',
            __( 'Place of heart on Images', 'wlwhplugin'),
            'wlwhplugin_heart_place_radio_callback',
            'wlwhplugin',
            'wlwhplugin_settings_section',
            [
              'option_topleft' => 'Top Left',
              'option_topright' => 'Top Right',
              'option_bottomleft' => 'Bottom Left',
              'option_bottomright' => 'Bottom Right'
            ]
          );

          // Input Text Field
          add_settings_field(
                  // Unique identifier for field
                  'wlwhplugin_correction_text',
                  // Field Title
                  __( 'Correction in Placement(if needed) ', 'wlwhplugin'),
                  // Callback for field markup
                  'wlwhplugin_correction_text_callback',
                  // Page to go on
                  'wlwhplugin',
                  // Section to go in
                  'wlwhplugin_settings_section',

                  [
                    'option_left' => 'Left Correction',
                    'option_top' => 'Top Correction'
                  ]
          );



        // Input Text Field
        add_settings_field(
                // Unique identifier for field
                'wlwhplugin_button_text',
                // Field Title
                __( 'Button(Add to WishList button) Text ', 'wlwhplugin'),
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
                __( 'Toast(Added to WishList) Text ', 'wlwhplugin'),
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

  _e( '<input type="text" id="wlwhplugin_labeltext" name="wlwhplugin_settings[wlwh_label]" size="25" value="' . $wlwh_label . '" />' );

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
  _e( '<input type="text" id="wlwhplugin_buttontext" name="wlwhplugin_settings[wlwh_buttontext]" size="25" value="' . $wlwh_buttontext . '" />' );
}


function wlwhplugin_toast_text_callback() {

  $options = get_option( 'wlwhplugin_settings' );

	$wlwh_toast = '';
	if( isset( $options[ 'wlwh_toast' ] ) ) {
		$wlwh_toast = esc_html( $options['wlwh_toast'] );
	}
  _e( '<input type="text" id="wlwhplugin_toasttext" name="wlwhplugin_settings[wlwh_toast]" maxlength="25" size="25" value="' . $wlwh_toast . '" />' );
}




function wlwhplugin_description_selector_checkbox_callback( $args ) {
  $options = get_option( 'wlwhplugin_settings' );

  $radio = '';
	if( isset( $options[ 'radio' ] ) ) {
		$radio = esc_html( $options['radio'] );
	}

	$html = '<input type="radio" id="wlwhplugin_settings_radio_one" name="wlwhplugin_settings[radio]" value="1"' . checked( 1, $radio, false ) . '/>';
	$html .= ' <label for="wlwhplugin_settings_radio_one">'. $args['option_one'] .'</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	$html .= '<input type="radio" id="wlwhplugin_settings_radio_two" name="wlwhplugin_settings[radio]" value="2"' . checked( 2, $radio, false ) . '/>';
	$html .= ' <label for="wlwhplugin_settings_radio_two">'. $args['option_two'] .'</label>';
  _e($html);
	//echo $html;
}


function wlwhplugin_heart_place_radio_callback( $args ) {
  $options = get_option( 'wlwhplugin_settings' );

  $radio = '';
	if( isset( $options[ 'heart_place' ] ) ) {
		$radio = esc_html( $options['heart_place'] );
	}

	$html = '<input type="radio" id="wlwhplugin_settings_radio_topleft" name="wlwhplugin_settings[heart_place]" value="1"' . checked( 1, $radio, false ) . '/>';
	$html .= ' <label for="wlwhplugin_settings_radio_topleft">'. $args['option_topleft'] .'</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	$html .= '<input type="radio" id="wlwhplugin_settings_radio_topright" name="wlwhplugin_settings[heart_place]" value="2"' . checked( 2, $radio, false ) . '/>';
	$html .= ' <label for="wlwhplugin_settings_radio_topright">'. $args['option_topright'] .'</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  $html .= '<input type="radio" id="wlwhplugin_settings_radio_bottomleft" name="wlwhplugin_settings[heart_place]" value="3"' . checked( 3, $radio, false ) . '/>';
	$html .= ' <label for="wlwhplugin_settings_radio_bottomleft">'. $args['option_bottomleft'] .'</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	$html .= '<input type="radio" id="wlwhplugin_settings_radio_bottomright" name="wlwhplugin_settings[heart_place]" value="4"' . checked( 4, $radio, false ) . '/>';
	$html .= ' <label for="wlwhplugin_settings_radio_bottomright">'. $args['option_bottomright'] .'</label>';

  _e($html);
	//echo $html;
}


function wlwhplugin_correction_text_callback() {

  $options = get_option( 'wlwhplugin_settings' );

	$wlwh_correction_left = '';
	if( isset( $options[ 'wlwh_correction_left' ] ) ) {
		$wlwh_correction_left = esc_html( $options['wlwh_correction_left'] );
	}

  $wlwh_correction_right = '';
	if( isset( $options[ 'wlwh_correction_right' ] ) ) {
		$wlwh_correction_right = esc_html( $options['wlwh_correction_right'] );
	}

  $html = '<input type="number" id="wlwhplugin_correction_lefttext" name="wlwhplugin_settings[wlwh_correction_left]" min="-999" max="999" value="' . $wlwh_correction_left . '" />';
  $html .= ' <label for="wlwhplugin_correction_lefttext">'. "Left Correction" .'</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  $html .= '<input type="number" id="wlwhplugin_correction_righttext" name="wlwhplugin_settings[wlwh_correction_right]" min="-999" max="999" value="' . $wlwh_correction_right . '" />';
  $html .= ' <label for="wlwhplugin_settings_correction_text">'. "Top Correction " .'</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

  _e($html);
  //_e( '<input type="number" id="wlwhplugin_correction_lefttext" name="wlwhplugin_settings[wlwh_correction_left]" maxlength="4" size="4" value="' . $wlwh_correction_left . '" />' );
}
