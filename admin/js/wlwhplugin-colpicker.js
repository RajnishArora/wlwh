window.$ = window.jQuery = $ = jQuery  ;

class ColPicker{
    constructor() {
        this.wpcolpicker= $('.wlwh-color-field');
        this.showpicker();

    }

//$('.my-color-field').wpColorPicker();
    showpicker(){
        //  alert("hi from col picker");
        this.wpcolpicker.wpColorPicker();
    }


}

var colpicker = new ColPicker();
