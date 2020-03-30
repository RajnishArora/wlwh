<?php
/**
 * @package
 *
 */


 add_shortcode('wlwh_showheart', function($atts,$content){
 		$atts = shortcode_atts(
 				array(
 						'visibility'	=> 'visible'
 				), $atts
 		);

 		extract($atts);
 		if ( !isset($wlwh_heart_object) ){
 				$wlwh_heart_object = new wlwh_show_hearts;
 		}
//      return $wlwh_heart_object;
 		return $wlwh_heart_object->wlwhplugin_add_short_wishbox($visibility);
 });


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

add_shortcode('wlwh_the_wishlist',function(){
		if( !isset($wlwh_wishlist_object) ){
				$wlwh_wishlist_object = new wlwh_the_wishlist;
		}
		return $wlwh_wishlist_object->create_wishlist();

});

//[wlwh_showbutton btnlabel="add to shortlist"]
//[wlwh_the_wishlist]
