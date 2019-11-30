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


    } else if(e.target.type  ==  'button'){

        var evtDet = $(e.target);
        var temp = evtDet.data("productid");
        var postid = evtDet.data("postid");
//        alert(evtDet.data("postid"));
//        alert("Sending ajax");

        $.ajax({
          beforeSend: (xhr) => {
            xhr.setRequestHeader('X-WP-Nonce', wlwhData.nonce);
          },
          url: wlwhData.root_url + '/wp-json/wlwh/v1/sendemail',
          type: 'POST',
          data: {'productId': temp,
                 'postId': postid

         },
          success: (response) => {
                    console.log("passed");
                    console.log(response);
                    if(response == true) {
                      alert("Mail Sent");
                    }
                    else if(response == false) {
                      alert("Mail couldnot be sent. Please check server settings");
                    }
          },
          error: (response) => {
              console.log("failed");
              console.log(response);
              alert("Mail couldnot be sent.Please try again");
          }
        });
    } // else target type button
  }); // eventlistener
  }  //events

}

var switch1 = new Switch();
