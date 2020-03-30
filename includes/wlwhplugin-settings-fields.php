<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}


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
    __( 'Heart Icon Settings', 'wlwhplugin' ),
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

    // Color Picker for heart
    add_settings_field(
            // Unique identifier for field
            'wlwhplugin_heart_color',
            // Field Title
            __( 'Choose Heart Color ', 'wlwhplugin'),
            // Callback for field markup
            'wlwhplugin_heart_picker_callback',
            // Page to go on
            'wlwhplugin',
            // Section to go in
            'wlwhplugin_settings_section'
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
                  __( 'Move heart icon left/right or top/down (if needed) ', 'wlwhplugin'),
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


          // Radio Field
          add_settings_field(
            'wlwhplugin_heart_cursor_radio',
            __( 'Choose the cursor ', 'wlwhplugin'),
            'wlwhplugin_heart_cursor_callback',
            'wlwhplugin',
            'wlwhplugin_settings_section',
            [
              'option_pointer' => 'Pointer',
              'option_cell' => 'Cell',
              'option_crosshair' => 'Crosshair',
              'option_default' => 'Default'
            ]
          );

                  // Input Text Field
          add_settings_field(
                          // Unique identifier for field
                      'wlwhplugin_toast_text',
                          // Field Title
                      __( 'Toast(Added to WishList ...) Text ', 'wlwhplugin'),
                          // Callback for field markup
                      'wlwhplugin_toast_text_callback',
                          // Page to go on
                      'wlwhplugin',
                          // Section to go in
                      'wlwhplugin_settings_section'
              );



          // Define (at least) one section for our fields
          add_settings_section(
            // Unique identifier for the section
            'wlwhplugin_button_settings_section',
            // Section Title
            __( 'Add to Wishlist Button Settings', 'wlwhplugin' ),
            // Callback for an optional description
            'wlwhplugin_button_settings_section_callback',
            // Admin page to add section to
            'wlwhplugin'
          );


                  // Input Text Field
                  add_settings_field(
                          // Unique identifier for field
                          'wlwhplugin_button_text',
                          // Field Title
                          __( 'Button Text (Add to WishList button)  ', 'wlwhplugin'),
                          // Callback for field markup
                          'wlwhplugin_button_text_callback',
                          // Page to go on
                          'wlwhplugin',
                          // Section to go in
                          'wlwhplugin_button_settings_section'
                  );


									  // Checkbox Field
									  add_settings_field(
									    'wlwhplugin_btnicon_selector_checkbox',
									    __( 'Show List Icon on Button', 'wlwhplugin'),
									    'wlwhplugin_btnicon_selector_checkbox_callback',
									    'wlwhplugin',
									    'wlwhplugin_button_settings_section',
									    [
									      'label' => 'Click to View on All buttons'
									    ]
									  );

                  // Input Text Field
                  add_settings_field(
                          // Unique identifier for field
                          'wlwhplugin_button_toast_text',
                          // Field Title
                          __( 'Button Toast (Added to WishList ...)  ', 'wlwhplugin'),
                          // Callback for field markup
                          'wlwhplugin_button_toast_text_callback',
                          // Page to go on
                          'wlwhplugin',
                          // Section to go in
                          'wlwhplugin_button_settings_section'
                  );


                  // Input Text Field
                  add_settings_field(
                          // Unique identifier for field
                          'wlwhplugin_button_inwishlist_text',
                          // Field Title
                          __( 'Button Toast (Already in WishList ...)  ', 'wlwhplugin'),
                          // Callback for field markup
                          'wlwhplugin_button_inwishlist_text_callback',
                          // Page to go on
                          'wlwhplugin',
                          // Section to go in
                          'wlwhplugin_button_settings_section'
                  );


                // Dropdown
           add_settings_field(
             'wlwhplugin_settings_select',
             __( 'Select Place for Wishlist Button', 'wlwhplugin'),
             'wlwhplugin_settings_select_callback',
             'wlwhplugin',
             'wlwhplugin_button_settings_section',
             [
               'option_one' => '   Put the button BEFORE "Add to Cart   "',
               'option_two' => '   Put the button AFTER "Add to Cart   "',
               'option_three' => '   Button Not Required / Use shortcode   '
             ]
           );

        add_settings_section(
          // Unique identifier for the section
          'wlwhplugin_wishlistpage_settings_section',
          // Section Title
          __( 'Wish List Page Settings', 'wlwhplugin' ),
          // Callback for an optional description
          'wlwhplugin_settings_section_callback',
          // Admin page to add section to
          'wlwhplugin'
        );

              // Dropdown
         add_settings_field(
           'wlwhplugin_settings_page_select',
           __( 'Select Page for Wishlist', 'wlwhplugin'),
           'wlwhplugin_settings_page_select_callback',
           'wlwhplugin',
           'wlwhplugin_wishlistpage_settings_section'

         );


          // Input Text Field
        add_settings_field(
          // Unique identifier for field
          'wlwhplugin_settings_label_text',
          // Field Title
          __( 'Heading for Wish List Page ', 'wlwhplugin'),
          // Callback for field markup
          'wlwhplugin_settings_label_text_callback',
          // Page to go on
          'wlwhplugin',
          // Section to go in
          'wlwhplugin_wishlistpage_settings_section'
        );

        // Checkbox Field
        add_settings_field(
          'wlwhplugin_feature_image_checkbox',
          __( 'Show feature image of wishlist Page', 'wlwhplugin'),
          'wlwhplugin_feature_image_callback',
          'wlwhplugin',
          'wlwhplugin_wishlistpage_settings_section',
          [
            'label' => 'Check to use the feature image as Heading Background'
          ]
        );


        // Radio Field
        /*
        add_settings_field(
          'wlwhplugin_description_selector_checkbox',
          __( 'Choose which Description to show on WishList Page', 'wlwhplugin'),
          'wlwhplugin_description_selector_checkbox_callback',
          'wlwhplugin',
          'wlwhplugin_wishlistpage_settings_section',
          [
            'option_one' => 'Short Description',
            'option_two' => 'Long Description',
            'option_three' => 'No Description'
          ]
        );
*/

  register_setting(
    'wlwhplugin_settings',
    'wlwhplugin_settings'
  );

}

add_action( 'admin_init', 'wlwhplugin_settings' );

function wlwhplugin_settings_section_callback() {
  esc_html_e( '', 'wlwhplugin' );
}

function wlwhplugin_button_settings_section_callback(){
  esc_html_e( '', 'wlwhplugin' );
}

function wlwhplugin_wishlistpage_settings_section(){
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

function wlwhplugin_heart_picker_callback() {

  $options = get_option( 'wlwhplugin_settings' );

	$wlwh_heart_picker_label = '';
	if( isset( $options[ 'wlwh_heart_picker_label' ] ) ) {
		$wlwh_heart_picker_label = esc_html( $options['wlwh_heart_picker_label'] );
	}

  _e( '<input type="text" value="' . $wlwh_heart_picker_label . '" class="wlwh-color-field" data-default-color="#ff0000" id="wlwhplugin_heart_picker" name="wlwhplugin_settings[wlwh_heart_picker_label]" size="25"  />' );

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


function wlwhplugin_btnicon_selector_checkbox_callback( $args ) {

  $options = get_option( 'wlwhplugin_settings' );

  $checkbox = '';
	if( isset( $options[ 'btnicon' ] ) ) {
		$checkbox = esc_html( $options['btnicon'] );

	}

	$html = '<input type="checkbox" id="wlwhplugin_btnicon_checkbox" name="wlwhplugin_settings[btnicon]" value="1"' . checked( 1, $checkbox, false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="wlwhplugin_btnicon_checkbox">' . $args['label'] . '</label>';

	_e($html);

}


function wlwhplugin_feature_image_callback( $args ) {

  $options = get_option( 'wlwhplugin_settings' );

  $checkbox = '';
	if( isset( $options[ 'img_background' ] ) ) {
		$checkbox = esc_html( $options['img_background'] );

	}

	$html = '<input type="checkbox" id="wlwhplugin_img_background" name="wlwhplugin_settings[img_background]" value="1"' . checked( 1, $checkbox, false ) . '/>';
	$html .= '&nbsp;';
	$html .= '<label for="wlwhplugin_img_background">' . $args['label'] . '</label>';

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

function wlwhplugin_button_text_callback() {

  $options = get_option( 'wlwhplugin_settings' );

	$wlwh_buttontext = '';
	if( isset( $options[ 'wlwh_buttontext' ] ) ) {
		$wlwh_buttontext = esc_html( $options['wlwh_buttontext'] );
	}
  _e( '<input type="text" id="wlwhplugin_buttontext" name="wlwhplugin_settings[wlwh_buttontext]" size="25" value="' . $wlwh_buttontext . '" />' );
}


function wlwhplugin_button_toast_text_callback() {

  $options = get_option( 'wlwhplugin_settings' );

	$wlwh_btntoast = '';
	if( isset( $options[ 'wlwh_btntoast' ] ) ) {
		$wlwh_btntoast = esc_html( $options['wlwh_btntoast'] );
	}
  _e( '<input type="text" id="wlwhplugin_btntoast" name="wlwhplugin_settings[wlwh_btntoast]" size="25" value="' . $wlwh_btntoast . '" />' );
}

function wlwhplugin_button_inwishlist_text_callback() {

  $options = get_option( 'wlwhplugin_settings' );

	$wlwh_inwishlist = '';
	if( isset( $options[ 'wlwh_inwishlist' ] ) ) {
		$wlwh_inwishlist = esc_html( $options['wlwh_inwishlist'] );
	}
  _e( '<input type="text" id="wlwhplugin_inwishlist" name="wlwhplugin_settings[wlwh_inwishlist]" size="25" value="' . $wlwh_inwishlist . '" />' );
}


function wlwhplugin_settings_select_callback( $args ) {

  $options = get_option( 'wlwhplugin_settings' );

  $select = '';
	if( isset( $options[ 'select' ] ) ) {
		$select = esc_html( $options['select'] );
	}

  $html = '<select id="wlwhplugin_settings_options" name="wlwhplugin_settings[select]">';

  $html .= '<option value="option_one"' . selected( $select, 'option_one', false) . '>' . $args['option_one'] . '</option>';
	$html .= '<option value="option_two"' . selected( $select, 'option_two', false) . '>' . $args['option_two'] . '</option>';
	$html .= '<option value="option_three"' . selected( $select, 'option_three', false) . '>' . $args['option_three'] . '</option>';
	$html .= '</select>';

  $html .= '<br><br><br><br>';
	_e($html);

}

function wlwhplugin_settings_page_select_callback(  ) {

  $options = get_option( 'wlwhplugin_settings' );

  $pageselect = '';
	if( isset( $options[ 'pageselect' ] ) ) {
		  $pageselect = esc_html( $options['pageselect'] );
	}


  $option0 = "Use Shortcode to place the wishlist Anywhere";
  $html = '<select id="wlwhplugin_settings_page_select_options" name="wlwhplugin_settings[pageselect]">';
  $html .= '<option value="-1">';
  $html .= $option0;
  $html .= '</option>';

              $pages = get_pages();
              $selected = " ";
              foreach ( $pages as $page ) {
                  if( $pageselect == $page->ID ) { $selected = " selected ";  } else { $selected =" ";  }

                  $html  .= '<option value= "' . $page->ID .'"' .  $selected . ' >';
                  $html .= $page->post_title;
                  $html .= '</option>';
              }
	$html .= '</select>';

	_e($html);

}


function wlwhplugin_toast_text_callback() {

  $options = get_option( 'wlwhplugin_settings' );

	$wlwh_toast = '';
	if( isset( $options[ 'wlwh_toast' ] ) ) {
		$wlwh_toast = esc_html( $options['wlwh_toast'] );
	}
  _e( '<input type="text" id="wlwhplugin_toasttext" name="wlwhplugin_settings[wlwh_toast]" maxlength="25" size="25" value="' . $wlwh_toast . '" />' );
  _e('<br><br><br><br>');
}


/*

function wlwhplugin_description_selector_checkbox_callback( $args ) {
  $options = get_option( 'wlwhplugin_settings' );

  $radio = '';
	if( isset( $options[ 'radio' ] ) ) {
		$radio = esc_html( $options['radio'] );
	}

	$html = '<input type="radio" id="wlwhplugin_settings_radio_one" name="wlwhplugin_settings[radio]" value="1"' . checked( 1, $radio, false ) . '/>';
	$html .= ' <label for="wlwhplugin_settings_radio_one">'. $args['option_one'] .'</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	$html .= '<input type="radio" id="wlwhplugin_settings_radio_two" name="wlwhplugin_settings[radio]" value="2"' . checked( 2, $radio, false ) . '/>';
	$html .= ' <label for="wlwhplugin_settings_radio_two">'. $args['option_two'] .'</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  $html .= '<input type="radio" id="wlwhplugin_settings_radio_three" name="wlwhplugin_settings[radio]" value="3"' . checked( 3, $radio, false ) . '/>';
	$html .= ' <label for="wlwhplugin_settings_radio_three">'. $args['option_three'] .'</label>';
  $html .= '<br><br><br><br>';

  _e($html);

}

*/
function wlwhplugin_heart_cursor_callback( $args ) {
  $options = get_option( 'wlwhplugin_settings' );

  $radio = '';
	if( isset( $options[ 'heart_cursor' ] ) ) {
		$radio = esc_html( $options['heart_cursor'] );
	}

	$html = '<input type="radio" id="wlwhplugin_settings_radio_pointer" name="wlwhplugin_settings[heart_cursor]" value="1"' . checked( 1, $radio, false ) . '/>';
	$html .= ' <label for="wlwhplugin_settings_radio_pointer">'. $args['option_pointer'] .'</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	$html .= '<input type="radio" id="wlwhplugin_settings_radio_cell" name="wlwhplugin_settings[heart_cursor]" value="2"' . checked( 2, $radio, false ) . '/>';
	$html .= ' <label for="wlwhplugin_settings_radio_cell">'. $args['option_cell'] .'</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
  $html .= '<input type="radio" id="wlwhplugin_settings_radio_crosshair" name="wlwhplugin_settings[heart_cursor]" value="3"' . checked( 3, $radio, false ) . '/>';
	$html .= ' <label for="wlwhplugin_settings_radio_crosshair">'. $args['option_crosshair'] .'</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	$html .= '<input type="radio" id="wlwhplugin_settings_radio_default" name="wlwhplugin_settings[heart_cursor]" value="4"' . checked( 4, $radio, false ) . '/>';
	$html .= ' <label for="wlwhplugin_settings_radio_default">'. $args['option_default'] .'</label>';
  _e($html);

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

}
