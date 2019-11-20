window.$ = window.jQuery = $ = jQuery  ;

class WishList {
	constructor(){
  //     alert("hi from wishlist");
			if(performance.navigation.type == 2){
	//				alert("about to be reloaded ");
					location.reload(true);
			}


			this.wishBox = $(".wish-box");
      this.trashBox = $(".trashwishitem");
      this.singleWishBox = $(".single-addtowishList") ;
		  // alert($(this.trashBox).data("trashitem"));
      this.events();
	}

	//events
	events() {
    this.wishBox.on("click", this.ourClickDispatcher.bind(this));
    this.trashBox.on("click", this.ourTrashWish.bind(this));
    this.singleWishBox.on("click", this.singleProductAddWish.bind(this));
		//this.singleWishBox.on("click", this.ourClickDispatcher.bind(this));

  	}

	//functions

 	ourClickDispatcher(e) {

 		let currentWishBox = $(e.target).closest(".wish-box");
		e.preventDefault();
    	if (currentWishBox.attr('data-exists') == 'yes') {
  //  		console.log("data exists so delete wish")
      		this.deleteWish(currentWishBox);
    		} else {
    //		console.log("data exists false");
      		this.createWish(currentWishBox);
    	}
 	}




 createWish(currentWishBox) {
 		console.log(" createWish ");
		let oldStatus = currentWishBox.attr('data-exists');

		if( currentWishBox.attr('data-logged') == 'yes'){
			currentWishBox.attr('data-exists', 'yes');
		}

    //currentWishBox.html('<div class="filter_loading"> <img src="'+crockeryData.theme_uri+'/images/loading_spinner.gif" alt="" /></div>');
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', wlwhData.nonce);
      },
      url: wlwhData.root_url + '/wp-json/wlwh/v1/manageWish',
      type: 'POST',
      data: {'productId': currentWishBox.data('product-id') },
      success: (response) => {
				currentWishBox.attr('data-exists', 'yes');
		//		console.log(currentWishBox.attr('data-exists'));

        //currentWishBox.html( `
        //                      <i class = "fa fa-heart-o "></i>
        //                      <i class = "fa fa-heart"></i>
        //                      `);


				let wishAdded = currentWishBox.find(".added-wish");
				//console.log(wishAdded);
				wishAdded.removeClass("hidden");
				currentWishBox.removeClass("wish-box_hover");
				setTimeout( function(){
							wishAdded.addClass("hidden");
							currentWishBox.addClass("wish-box_hover");
						},
						3000);

      },
      error: (response) => {
				currentWishBox.attr('data-exists', oldStatus);
        //alert("Could not WishListed! Please check if you are logged in")
        console.log(response);
      }
    });
  }


 deleteWish(currentWishBox) {
  		console.log(" deleteWish ");
			let oldStatus = currentWishBox.attr('data-exists');
			currentWishBox.attr('data-exists', 'no');
      //currentWishBox.html('<div class="filter_loading"> <img src="'+crockeryData.theme_uri+'/images/loading_spinner.gif" alt="" /></div>');
  		$.ajax({
	      beforeSend: (xhr) => {
	        xhr.setRequestHeader('X-WP-Nonce', wlwhData.nonce);
	      },
	      url:  wlwhData.root_url + '/wp-json/wlwh/v1/manageWish',
	      data: {'productId': currentWishBox.data('product-id') },
	      type: 'DELETE',
	      success: (response) => {
        //  currentWishBox.html( `
        //                      <i class = "fa fa-heart-o "></i>
        //                      <i class = "fa fa-heart"></i>
        //                      `);

	        //currentWishBox.attr('data-exists', 'no');
					console.log(currentWishBox.attr('data-exists'));
	        //console.log(response);
	      },
	      error: (response) => {
					currentWishBox.attr('data-exists', oldStatus);
	        console.log(response);
	      }
	    });

  	}


singleProductAddWish(e){
        //var that = this;

        var evtDet = $(e.target);
        var temp = evtDet.data("singleproductid");

				let currentWishBox = $('.single-product').find(".wish-box");
				if(currentWishBox.length <= 0){
								console.log("Wish Box could not be located");
								return;
				}

				let oldStatus = currentWishBox.attr('data-exists');

				let status = currentWishBox.attr('data-exists');
				//console.log(status);
        //var status = evtDet.data("singleexiststatus");
				//alert(status);
				if( currentWishBox.attr('data-logged') == 'yes'){
					currentWishBox.attr('data-exists', 'yes');
				}

				if(status == 'no') {
              $.ajax({
              beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', wlwhData.nonce);
              },
              url: wlwhData.root_url + '/wp-json/wlwh/v1/manageWish',
              type: 'POST',
              data: {'productId': temp },
              success: (response) => {
                //this.singleWishBox.attr("data-singleexiststatus",'yes');
								currentWishBox.attr('data-exists', 'yes');
//								currentWishBox.html( `
//			                              <i class = "fa fa-heart-o "></i>
//			                              <i class = "fa fa-heart"></i>
//			                              `);
                //alert("Added to wishlist");
               // rest baad mein
                console.log(response);
              },
              error: (response) => {
								currentWishBox.attr('data-exists', oldStatus);
                console.log(response);
              }
            });

        } else if (status == 'yes'){
             console.log("already exists in wish list");
          } else {
              console.log("invalid entry");
          }


    }




		ourTrashWish(evt){

      var evtDet = $(evt.target);
      var temp = $(evtDet).data("trashitem");

		//	alert(" trash clicked ");
		//	alert(temp);

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
