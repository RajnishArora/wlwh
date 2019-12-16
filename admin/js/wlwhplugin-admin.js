window.$ = window.jQuery = $ = jQuery  ;

class Switch{

  //this.y = document.getElementsByClassName('waiting');
  //this.waiting = y[0];

  //jquery not working in admin side may be jquery loads later ?


  constructor() {
      this.waiting ;
      this.msgcontent;
      this.subject;
      this.events();
  }




  events(){
      var evtDet;
      var temp;
      var postid;

      this.waiting = $(".waiting");


      //var y = document.getElementsByClassName('waiting');
      //waiting = y[0];

    document.addEventListener("click",function(e){

      if(e.target.type  ==  'button'){

        evtDet = $(e.target);

        if(evtDet.hasClass('emailbutton') ){
          temp = evtDet.data("productid");
          postid = evtDet.data("postid");
          //console.log( evtDet.parent().parent());
          evtDet.parent().parent().next(".modal").removeClass("hidden");

      }else if(evtDet.hasClass('cancelupper') ){
          //$(e.target).parent().parent().addClass("hidden");
          $(e.target).parent().parent().parent().addClass("hidden");
        }

        else if(evtDet.hasClass('cancelbtn')  ){
          $(e.target).parent().parent().addClass("hidden");
          //$(e.target).parent().parent().parent().addClass("hidden");
        } else if( evtDet.hasClass( 'okbtn') ){
                  this.mailto = $(".mailto");
                  this.subject = $(".mailsub");
                  this.msgcontent = $("#createmetaboxmsg");
                //  var mailmsg = this.msgcontent.html();
                //  alert(this.mailto.val());

                //  var evtDet = $(e.target);
                //  var temp = evtDet.data("productid");
                //  var postid = evtDet.data("postid");
                $(".waiting").removeClass("hidden");
                  $.ajax({
                    beforeSend: (xhr) => {
                      xhr.setRequestHeader('X-WP-Nonce', wlwhData.nonce);
                    },
                    url: wlwhData.root_url + '/wp-json/wlwh/v1/sendemail',
                    type: 'POST',
                    data: {'productId': temp,
                           'postId': postid,
                           'mailto':this.mailto.val(),
                           'mailsub':this.subject.val(),
                           'emailmsg': this.msgcontent.html()
                   },
                    success: (response) => {
                              $(".waiting").addClass("hidden");
                              let rep = response;
                              console.log("passed");
                              console.log(rep);
                              if(rep == true) {
                          			alert("Mail Sent"); //repalce alert by custom message box
                                $(e.target).parent().parent().addClass("hidden");

                          		}
                          		else if(rep == false) {
                          			alert("Mail couldnot be sent. Please check server settings");
                                //$(e.target).parent().parent().addClass("hidden");

                          		}
                              // when then not working one after another with alert

                    },
                    error: (response) => {
                        $(".waiting").addClass("hidden");
                        console.log("failed");
                        console.log(response);
                        alert("Mail couldnot be sent.Please try again");
                    }
                  }); //ajax call ends
        } // if ok button clicked

    }  // target type is button
    else if(e.target.id == 'modalcross'){
      $(e.target).parent().parent().parent().addClass("hidden");

    }
  }); // eventlistener
  }  //events

}

var switch1 = new Switch();
