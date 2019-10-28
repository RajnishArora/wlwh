window.$ = window.jQuery = $ = jQuery  ;

class WishList {
	constructor(){
  //     alert("hi from wishlist");
			this.wishBox = $(".wish-box");
      this.trashBox = $(".trashwishitem");
//      this.singleWishBox = $(".single-addtowishList") ;
		  // alert($(this.trashBox).data("trashitem"));
      this.events();
	}

	//events
	events() {
    this.wishBox.on("click", this.ourClickDispatcher.bind(this));
    this.trashBox.on("click", this.ourTrashWish.bind(this));
  //  this.singleWishBox.on("click", this.singleProductAddWish.bind(this));
  	}

	//functions

 	ourClickDispatcher(e) {

 		var currentWishBox = $(e.target).closest(".wish-box");
		e.preventDefault();
    	if (currentWishBox.attr('data-exists') == 'yes') {
    		console.log("data exists so delete wish")
      		this.deleteWish(currentWishBox);
    		} else {
    		console.log("data exists false");
      		this.createWish(currentWishBox);
    	}
 	}




 createWish(currentWishBox) {
 		console.log(" createWish ");
    //currentWishBox.html('<div class="filter_loading"> <img src="'+crockeryData.theme_uri+'/images/loading_spinner.gif" alt="" /></div>');
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', wlwhData.nonce);
      },
      url: wlwhData.root_url + '/wp-json/wlwh/v1/manageWish',
      type: 'POST',
      data: {'productId': currentWishBox.data('product-id') },
      success: (response) => {
        currentWishBox.html( `
                              <i class = "fa fa-heart-o "></i>
                              <i class = "fa fa-heart"></i>
                              `);
        currentWishBox.attr('data-exists', 'yes');
       // rest baad mein
        console.log(response);
      },
      error: (response) => {
        currentWishBox.html( `
                              <i class = "fa fa-heart-o "></i>
                              <i class = "fa fa-heart"></i>
                              `);
        alert("Could not WishListed! Please check if you are logged in")
        console.log(response);
      }
    });
  }


 deleteWish(currentWishBox) {
  		console.log(" deleteWish ");
  		//var temp = currentWishBox.data('product-id');
  		//console.log(temp);
      //currentWishBox.html('<div class="filter_loading"> <img src="'+crockeryData.theme_uri+'/images/loading_spinner.gif" alt="" /></div>');
  		$.ajax({
	      beforeSend: (xhr) => {
	        xhr.setRequestHeader('X-WP-Nonce', wlwhData.nonce);
	      },
	      url:  wlwhData.root_url + '/wp-json/wlwh/v1/manageWish',
	      data: {'productId': currentWishBox.data('product-id') },
	      type: 'DELETE',
	      success: (response) => {
          currentWishBox.html( `
                              <i class = "fa fa-heart-o "></i>
                              <i class = "fa fa-heart"></i>
                              `);

	        currentWishBox.attr('data-exists', 'no');
	        //console.log(response);
	      },
	      error: (response) => {
          currentWishBox.html( `
                              <i class = "fa fa-heart-o "></i>
                              <i class = "fa fa-heart"></i>
                              `);
	        console.log(response);
	      }
	    });

  	}

    /*
    singleProductAddWish(e){
        //var that = this;
        var evtDet = $(e.target);
        var temp = evtDet.data("singleproductid");

        var status = evtDet.data("singleexiststatus");
        //alert(status);
        if(status == 'no') {
              $.ajax({
              beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', crockeryData.nonce);
              },
              url: crockeryData.root_url + '/wp-json/crockery/v1/manageWish',
              type: 'POST',
              data: {'productId': temp },
              success: (response) => {
                debugger;
                this.singleWishBox.data("singleexiststatus",'yes');
                alert("Added to wishlist");
               // rest baad mein
                console.log(response);
              },
              error: (response) => {
                console.log(response);
              }
            });

        } else if (status == 'yes'){
             console.log("already exists in wish list");
          } else {
              console.log("invalid entry");
          }


    }


*/

		ourTrashWish(evt){

      var evtDet = $(evt.target);
      var temp = $(evtDet).data("trashitem");

			alert(" trash clicked ");
			alert(temp);

      $.ajax({
        beforeSend: (xhr) => {
          xhr.setRequestHeader('X-WP-Nonce', wlwhData.nonce);
        },
        url:  wlwhData.root_url + '/wp-json/wlwh/v1/manageWish',
        data: {'productId': temp },
        type: 'DELETE',
        success: (response) => {
          //dynamically delete the list element whose id is temp
          $(`#${temp}`).remove();
          //console.log(response);
        },
        error: (response) => {
          console.log(response);
        }
      });

    }


}

var wl = new WishList();
