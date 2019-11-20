window.$ = window.jQuery = $ = jQuery  ;

class Switch{
  constructor() {
      this.events();
  }

  events(){
    document.addEventListener("click",function(e){

      if (e.target.type  ==  'checkbox' ){
        var cc = e.target.id;

        if( 'wlwhplugin_complete_checkbox' == cc ) {
            if( ($('#wlwhplugin_short_checkbox').prop('checked') == false) && ($('#wlwhplugin_complete_checkbox').prop('checked') == false)  ){
                $('#wlwhplugin_short_checkbox').prop('checked',true);
                $('#wlwhplugin_complete_checkbox').prop('checked',false);
            }
            if( $('#wlwhplugin_complete_checkbox').is( ':checked') ){
                $('#wlwhplugin_short_checkbox').prop('checked',false);
            } else {
                $('#wlwhplugin_short_checkbox').prop('checked',true);
            }
        }
        if( 'wlwhplugin_short_checkbox' == cc ){
          if( $('#wlwhplugin_complete_checkbox').is( ':checked') ){
              $('#wlwhplugin_complete_checkbox').prop('checked',false);
          } else {
              $('#wlwhplugin_complete_checkbox').prop('checked',true);
          }
        }

        /*
        if( 'wlwhplugin_complete_checkbox' == cc ) {
            if( $('#wlwhplugin_short_checkbox').is( ':checked') ){
                $('#wlwhplugin_short_checkbox').prop('checked',false);
            } else {
                $('#wlwhplugin_short_checkbox').prop('checked',true);
            }
        }
        if( 'wlwhplugin_short_checkbox' == cc ){
          if( $('#wlwhplugin_complete_checkbox').is( ':checked') ){
              $('#wlwhplugin_complete_checkbox').prop('checked',false);
          } else {
              $('#wlwhplugin_complete_checkbox').prop('checked',true);
          }
        }
        */

    }
  }); // eventlistener
  }  //events

}

var switch1 = new Switch();
