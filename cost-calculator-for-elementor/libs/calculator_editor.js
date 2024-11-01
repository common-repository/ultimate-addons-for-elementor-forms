(function($) {
    "use strict";
    $( document ).ready( function () { 
        $("body").on("click",'.elementor-control-tag-area[data-setting="formula"]',function(e){
            var container = $(this).closest('.wpforms-field-option-row');
            var id = $(this).attr("id").match(/\d+/)[0];
            if( $(this).data("check") != "ok" ) {
              var value = $(this).val();
               $(this).focus().val('').val(value);
              $(this).after('<div class="elementor-control-dynamic-switcher elementor-control-unit-1 elementor-cost-calculator-add-tag" data-tooltip="add Tags" original-title=""><i class="eicon-database" aria-hidden="true"></i><span class="elementor-screen-only">Dynamic Tags</span></div>');
              $(this).data("check","ok");
              $(this).wrap( "<div id='elementor-control-default-container-"+id+"' class='elementor-control-default-container'></div>" );
               if (typeof elementor_calculator !== 'undefined' && elementor_calculator !== null) {
                 var tributeAttributes = {
                    autocompleteMode: true,
                    noMatchTemplate: "",
                    values: elementor_calculator.data,
                    selectTemplate: function(item) {
                      if (typeof item === "undefined") return null;
                      if (this.range.isContentEditable(this.current.element)) {
                        return (
                          '<span contenteditable="false"><a>' +
                          item.original.key +
                          "</a></span>"
                        );
                      }

                      return item.original.value;
                    },
                    menuItemTemplate: function(item) {
                      return item.string;
                    }
                  };
                  var tributeAutocompleteTestArea = new Tribute(
                    Object.assign(
                      {
                        menuContainer:  document.getElementById("elementor-control-default-container-"+id),
                        replaceTextSuffix: "",
                      },
                      tributeAttributes
                    )
                  );
                  tributeAutocompleteTestArea.attach(
                    document.getElementById("elementor-control-default-c"+id)
                  );
                }
            }
        }) 
        $("body").on("click",".elementor-cost-calculator-add-tag",function(e){
           var html ='<ul class="elementor-cost-calculator-sync">';
           var form = $(this).closest(".elementor-repeater-fields-wrapper");
           $(".elementor-form-field-shortcode",form).each(function() {
            const regex = /\".*?\"/gm;
            let m;
            var name = $(this).val();
            while ((m = regex.exec(name)) !== null) {
                if (m.index === regex.lastIndex) {
                    regex.lastIndex++;
                }
                m.forEach((match, groupIndex) => {
                    name = match.replaceAll('"',"");
                });
            }
             html +='<li title="Copy shortcode name">'+name+'</li>'; 
           });
          html +='</ul>';
          $(this).closest(".elementor-control-input-wrapper").append(html);
        })
        
        $(document).mouseup(function(e) 
        {
            var container = $(".elementor-cost-calculator-sync");

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) 
            {
                container.hide();
            }
        });
        $("body").on("click",".elementor-cost-calculator-sync li",function(e){
           var vl = $(this).html();
           navigator.clipboard.writeText(vl);
           $(this).html("Copied to Clipboard");
           setTimeout(function(){ 
          $(".elementor-cost-calculator-sync").remove();
          }, 500);
        })
    })
})(jQuery);