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
			this.jsonorrest = '/?rest_route=';
			this.di;

			this.shortcode = $("#shortinput");

      this.events();
	}


	place_wishboxes_firsttime(){

	}

		show_toast(currentWishBox){
			//console.log("show_toast called")
			let wishAdded = currentWishBox.next(".added-wish");
			let cwbOffest = currentWishBox.offset();
			let cwbTop = cwbOffest.top;
			let cwbLeft = cwbOffest.left;
			cwbTop +=4;

			if(this.place == '1' || this.place == '3'){
					cwbLeft += 50;
			} else if(this.place == '2' || this.place == '4'){
					cwbLeft -= 180;
			}
			$(wishAdded[0]).removeClass("hidden");
			$(wishAdded[0]).offset({left: cwbLeft ,top: cwbTop});
			currentWishBox.removeClass("wish-box_hover");

			window.onscroll = function (e){
					$(wishAdded[0]).addClass("hidden");
			}

			setTimeout( function(){
						wishAdded.addClass("hidden");
						currentWishBox.addClass("wish-box_hover");
					},
					3000);

		}

		show_toastbutton(currentbtn){
					//console.log(currentbtn);
					var wishAddedbtn = currentbtn.next().next(".added-wishbutton");
					//console.log(wishAddedbtn);

					var cwbOffest = currentbtn.offset();
					var cwbTop = cwbOffest.top;
					var cwbLeft = cwbOffest.left;
			//		console.log(cwbLeft);
					cwbTop += 10;
					cwbLeft += 150;
					$(wishAddedbtn).removeClass("hidden");
					$(wishAddedbtn).offset({left: cwbLeft ,top: cwbTop});

					window.onscroll = function (e){
							$(wishAddedbtn).addClass("hidden");
					}

					setTimeout( function(){
								wishAddedbtn.addClass("hidden");

							},
							3000);
		}



			show_toast_inwishlist(currentbtn){
							//console.log(currentbtn);
							let wishAddedbtn = currentbtn.next(".inwishlistbtn");
							//console.log(wishAddedbtn);
							var cbOffset = currentbtn.offset();
							var cbTop = cbOffset.top;
							var cbLeft = cbOffset.left;

							cbTop += 10;
							cbLeft += 150;
							//console.log(cbLeft);
							//console.log(cbTop);
							$(wishAddedbtn).removeClass("hidden");
							$(wishAddedbtn).offset({left: cbLeft ,top: cbTop});

							window.onscroll = function (e){
									$(wishAddedbtn).addClass("hidden");
							}

							setTimeout( function(){
										$(wishAddedbtn).addClass("hidden");
									},
									3000);
				}

		place_wishboxes( ){

						console.log("place called");
						let i=0;
						let allWishBoxes = document.getElementsByClassName("wish-box");
						//console.log(allWishBoxes.length);
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

						for(i=0; i<allWishBoxes.length; i++){
							let short = $(allWishBoxes[i]).attr('data-short');
							let shorttrue="true";
							let shortcheck = shorttrue.localeCompare(short);
							//console.log("Short ")
							//console.log(short);
							if(shortcheck == 0) {
										$(allWishBoxes[i]).removeClass("hidden");
										continue; // skip the current iteration
									}
							let shorthidden="hidden";
							let hiddencheck = shorthidden.localeCompare(short);
							if( hiddencheck == 0) {
									continue;
							}
							this.di = $(allWishBoxes[i]).parent().find('img');
							let displayImage = $(allWishBoxes[i]).parent().find('img');
							//console.log(displayImage[0]);
							if(displayImage.length < 0 ){
									$(allWishBoxes[i]).removeClass("hidden");
									console.log("Javascript placement fails");
									//$(allWishBoxes[i]).addClass("wish-box-topleft");
									// let postioning of css take place ie on top left
							} else {
										$(displayImage[0]).one("load", function() {
													  if(this.complete){
																$(this).load();
														}
													});

								let dImgWidth = $(displayImage[0]).width();
								let dImgHeight = $(displayImage[0]).height();

								let posImg = $(displayImage[0]).offset();


								let leftPos = posImg.left + dImgWidth*0.1;
								let rightPos =   posImg.left + dImgWidth*0.87;
								let topPos = posImg.top +  dImgHeight*0.1;
								let bottomPos =posImg.top + dImgHeight*0.85;
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

							} // outer else ends

						} 	// for ends

				//});

			}



	//events
	events() {
		//alert(this.shortcode.val());
    this.wishBox.on("click", this.ourClickDispatcher.bind(this));
    this.trashBox.on("click", this.ourTrashWish.bind(this));
    this.singleWishBox.on("click", this.singleProductAddWish.bind(this));
		$(window).load(this.place_wishboxes.bind(this));
		$(window).on("resize",this.place_wishboxes.bind(this));

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

		//if( currentWishBox.attr('data-logged') == 'yes'){
			currentWishBox.attr('data-exists', 'yes');
		//} else {
		//			alert("Please log in to create a wish list");
		//			return;
					// not logged;
		 // }
		if(currentWishBox.attr('data-isjson') == true) {
			this.jsonorrest = '/wp-json';
		} else {
			this.jsonorrest = '/?rest_route=';
		}
    //currentWishBox.html('<div class="filter_loading"> <img src="'+crockeryData.theme_uri+'/images/loading_spinner.gif" alt="" /></div>');
    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', wlwhData.nonce);
      },
    //  url: wlwhData.root_url + '/wp-json/wlwh/v1/manageWish',
	//	url: wlwhData.root_url + '/?rest_route=/wlwh/v1/manageWish',
		url: wlwhData.root_url + this.jsonorrest + '/wlwh/v1/manageWish',

      type: 'POST',
      data: {'productId': currentWishBox.attr('data-product-id') },
      success: (response) => {
				console.log(response);
				currentWishBox.attr('data-exists', 'yes');
				this.show_toast(currentWishBox);
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
			if(currentWishBox.attr('data-isjson') == true) {
					this.jsonorrest = '/wp-json';
				} else {
					this.jsonorrest = '/?rest_route=';
			}
      //currentWishBox.html('<div class="filter_loading"> <img src="'+crockeryData.theme_uri+'/images/loading_spinner.gif" alt="" /></div>');
  		$.ajax({
	      beforeSend: (xhr) => {
	        xhr.setRequestHeader('X-WP-Nonce', wlwhData.nonce);
	      },
//	      url:  wlwhData.root_url + '/wp-json/wlwh/v1/manageWish',
		url: wlwhData.root_url + this.jsonorrest + '/wlwh/v1/manageWish',
		data: {'productId': currentWishBox.attr('data-product-id') },
	      type: 'DELETE',
	      success: (response) => {
					currentWishBox.attr('data-exists', 'no');
        	//console.log(currentWishBox.attr('data-exists'));
					console.log("success");
					//console.log(currentWishBox.attr('data-product-id'))
	        //console.log(response);
	      },
	      error: (response) => {
					currentWishBox.attr('data-exists', oldStatus);
					//console.log("fail");
					//console.log(currentWishBox.attr('data-product-id'))
	        console.log(response);
	      }
	    });

  	}


singleProductAddWish(e){
        //var that = this;

				//var wishbtn = $(".added-wishbutton");
				var currentWishBox;
				var evtDet = $(e.target);
        //var temp = evtDet.data("singleproductid");
				var temp = evtDet.attr('data-singleproductid');
				let currentbtn = $(e.target).closest(".wish-button");
				let btnProductId = currentbtn.attr('data-singleproductid');
				let allWishBoxes = $(":root").find(".wish-box");
				if(allWishBoxes.length <= 0){
					alert("No heart found . Either select from settings or add heart via shortcode You may add a hidden heart if not needed ");
					return;
				}
				//console.log(allWishBoxes);
				allWishBoxes.each( function(){
						//console.log( $(this).attr('data-product-id') );
						if($(this).attr('data-product-id') == btnProductId){
									currentWishBox= $(this);
						}
				});
				//console.log(currentWishBox);
				//console.log(currentWishBox.length);
				if (currentWishBox == null){
						this.singleWishBox.remove();
						alert("No heart found . Either select from settings or add heart via shortcode You may add a hidden heart if not needed ");
						return;
				}
				if(currentWishBox.length <= 0 ){
						this.singleWishBox.remove();
						alert("No heart found . Either select from settings or add heart via shortcode You may add a hidden heart if not needed ");
						return;

				}

				let oldStatus = currentWishBox.attr('data-exists');

				let status = currentWishBox.attr('data-exists');
				// let status = oldStatus'
				//console.log(status);
				//console.log(currentWishBox.attr('data-product-id'));
        //var status = evtDet.data("singleexiststatus");
				//alert(status);
				if( currentWishBox.attr('data-logged') == 'yes'){
					currentWishBox.attr('data-exists', 'yes');
				}

				if(currentWishBox.attr('data-isjson') == true) {
					this.jsonorrest = '/wp-json';
				} else {
					this.jsonorrest = '/?rest_route=';
				}

			if(status == 'no') {
              $.ajax({
              beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', wlwhData.nonce);
              },
              //url: wlwhData.root_url + '/wp-json/wlwh/v1/manageWish',
						  url: wlwhData.root_url + this.jsonorrest + '/wlwh/v1/manageWish',
						  type: 'POST',
			              data: {'productId': temp },
			              success: (response) => {
											currentWishBox.attr('data-exists', 'yes');
											this.show_toast(currentWishBox);
											this.show_toastbutton(currentbtn);
			              },
			              error: (response) => {
											currentWishBox.attr('data-exists', oldStatus);
			                console.log(response);
			              }
			            });

        } else if (status == 'yes'){
							this.show_toast_inwishlist(currentbtn);
             console.log("already exists in wish list");
						 //show a modal as in added to wishlist
          } else {
              console.log("invalid entry");
          }


    }




	ourTrashWish(evt){

      var evtDet = $(evt.target);
      //var temp = $(evtDet).data("trashitem");
	  //var temp2= $(evtDet).data("trashjson");
		var temp = $(evtDet).attr('data-trashitem');
		var temp2= $(evtDet).attr('data-trashjson');
		//	alert(" trash clicked ");
		//	alert(temp);
		if(temp2 == true) {
					this.jsonorrest = '/wp-json';
				} else {
					this.jsonorrest = '/?rest_route=';
				}

      $.ajax({
        beforeSend: (xhr) => {
          xhr.setRequestHeader('X-WP-Nonce', wlwhData.nonce);
        },
    //    url:  wlwhData.root_url + '/wp-json/wlwh/v1/manageWish',
		url: wlwhData.root_url + this.jsonorrest + '/wlwh/v1/manageWish',
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
