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

			this.leftPlace;
			this.topPlace;
			this.place;

			this.leftCorrection =0;
			this.rightCorrection=0;


		  this.place_wishboxes();
      this.events();
	}


		place_wishboxes(){
				let i=0;
				let allWishBoxes = document.getElementsByClassName("wish-box");
				if ( allWishBoxes.length < 0) return;
				//console.log(allWishBoxes[0]);
				this.place = $(allWishBoxes[0]).attr('data-place');
				let lc= document.getElementsByClassName("left_correction");
				if(lc.length > 0){
						this.leftCorrection = Number(lc[0].innerText);
				}

				let rc= document.getElementsByClassName("right_correction");
				if(rc.length > 0){
						this.rightCorrection = Number(rc[0].innerText);
				}

				//alert(this.rightCorrection);

				for(i=0; i<allWishBoxes.length; i++){
					let displayImage = $(allWishBoxes[i]).parent().find('img');
					if(displayImage.length < 0 ){
							$(allWishBoxes[i]).removeClass("hidden");
							console.log("Javascript placement fails, reverting to top left pos");
						// let postioning of css take place ie on top left
					} else {
						let dImgWidth = displayImage.width();
						let dImgHeight = displayImage.height();
						//console.log(dImgWidth);
						//console.log(dImgHeight);

						let posImg = displayImage.offset();
						let leftPos = posImg.left + dImgWidth*0.1;
						let rightPos =   posImg.left + dImgWidth*0.87;
						let topPos = posImg.top +  dImgHeight*0.1;
						let bottomPos =posImg.top + dImgHeight*0.87;
						$(allWishBoxes[i]).removeClass("hidden");
						$(allWishBoxes[i]).removeClass("wish-box-topleft");
						this.leftPlace = leftPos;
						this.topPlace =topPos;
						if(this.place == '1'){
							this.leftPlace = leftPos;
							this.topPlace =topPos;
						} else if(this.place =='2'){
							this.leftPlace = rightPos;
							this.topPlace =topPos;
						}else if (this.place =='3'){
							this.leftPlace = leftPos;
							this.topPlace =bottomPos;
						}else if(this.place =='4'){
							this.leftPlace = rightPos;
							this.topPlace = bottomPos;
						}
						this.leftPlace+= this.leftCorrection;
						this.topPlace+= this.rightCorrection;

						$(allWishBoxes[i]).offset({left: this.leftPlace,top: this.topPlace});

					}

				}
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
		} else {
					alert("Please log in to create a wish list");
					// not logged;
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
				let wishAdded = currentWishBox.next(".added-wish");
				let cwbOffest = currentWishBox.offset();
				let cwbTop = cwbOffest.top;
				let cwbLeft = cwbOffest.left;
				cwbTop -=4;
				if(this.place == '1' || this.place == '3'){
						cwbLeft += 30;
				} else if(this.place == '2' || this.place == '4'){
						cwbLeft -= 180;
				}
				wishAdded.removeClass("hidden");
				$(wishAdded).offset({left: cwbLeft ,top: cwbTop});
				currentWishBox.removeClass("wish-box_hover");

				window.onscroll = function (e){
				    wishAdded.addClass("hidden");
				}

				setTimeout( function(){
							wishAdded.addClass("hidden");
							currentWishBox.addClass("wish-box_hover");
						},
						3000);

      },
      error: (response) => {
				currentWishBox.attr('data-exists', oldStatus);
        alert("Could not WishListed! Please try again")
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
