<?php
/**
 * @package
 *
 */
add_shortcode('wlwh_showbutton', function($atts,$content){
		$atts = shortcode_atts(
				array(
						'btnlabel'	=> 'Add to Wishlist'
				), $atts
		);

		extract($atts);
		if ( !isset($wlwh_button_object) ){
				$wlwh_button_object = new wlwh_create_button;
		}

		return $wlwh_button_object->wlwh_add_short_button($btnlabel);
});

//[wlwh_showbutton btnlabel="add to shortlist"]
