(function($) {
    "use strict";
    $( document ).ready( function () { 
        var data_class = ["number_format_symbols","number_format_symbols_position","number_format_thousand_sep","number_format_decimal_sep","number_format_num_decimals"];
        $("body").on("change",".wpforms-field-option-row-number_format input",function(){
            if( $(this).is(":checked") ) {
                $.each(data_class, function( index, value ) {
                  $(".wpforms-field-option-row-"+value).removeClass("wpforms-hidden");
                });
            }else{
                $.each(data_class, function( index, value ) {
                  $(".wpforms-field-option-row-"+value).addClass("wpforms-hidden");
                });
            }
        })
    })
})(jQuery);