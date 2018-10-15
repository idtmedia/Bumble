(function ($) {

    "use strict";

    jQuery('.currency-format').blur(function () {
    	// console.log('fdafsa');
    	var value = parseFloat(jQuery(this).val().replace(/,/g, ""))
            .toFixed(2)
            .toString()
            // .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        jQuery(this).val(value);
    });
    // document.getElementById("number").onblur =function (){
    //     this.value = parseFloat(this.value.replace(/,/g, ""))
    //         .toFixed(2)
    //         .toString()
    //         .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    //
    //     document.getElementById("display").value = this.value.replace(/,/g, "")
    //
    // }

})(jQuery);
