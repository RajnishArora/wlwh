window.$ = window.jQuery = $ = jQuery  ;

class WishBoxPlacer {
	constructor(){
			this.findall_wishboxes();
      this.events();
		} //constructor


		findall_wishboxes(){
			let i=0;
			let allWishBoxes = document.getElementsByClassName("wish-box");
			if ( allWishBoxes.length < 0) return;
			//console.log(allWishBoxes[0]);
			let place = $(allWishBoxes[0]).attr('data-place');
			//alert(place);
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
					let rightPos =   posImg.left + dImgWidth*0.85;
					let topPos = posImg.top +  dImgHeight*0.1;
					let bottomPos =posImg.top + dImgHeight*0.85;
					$(allWishBoxes[i]).removeClass("hidden");
					$(allWishBoxes[i]).removeClass("wish-box-topleft");
					let leftPlace = leftPos;
					let topPlace =topPos;
					if(place == '1'){
						leftPlace = leftPos;
						topPlace =topPos;
					} else if(place =='2'){
						leftPlace = rightPos;
						topPlace =topPos;
					}else if (place =='3'){
						leftPlace = leftPos;
						topPlace =bottomPos;
					}else if(place =='4'){
						leftPlace = rightPos;
						topPlace = bottomPos;
					}
					$(allWishBoxes[i]).offset({left: leftPlace,top: topPlace});

				}

			}
		}
			events(){

			}


} //class ends


var wbp = new WishBoxPlacer();
