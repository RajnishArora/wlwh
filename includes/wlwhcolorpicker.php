add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );
function mw_enqueue_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'my-script-handle', plugins_url('my-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}

1
<input type="text" value="#bada55" class="my-color-field" data-default-color="#effeff" />

jQuery(document).ready(function($){
    $('.my-color-field').wpColorPicker();
});
