(function($) {
    "use strict";
    $( document ).ready( function () { 
        $(".elementor-number-format").autoNumeric();
        $("body").on("click",".elementor-number-format",function(){
            $(this).autoNumeric();
            var data = $(this).autoNumeric("get");
            $(this).val(data);
        })
        $.elementor_calculator = function(form){
            var reg = [];
            $(".elementor-field",form).each(function () { 
                var check_id = $(this).attr("id");
                if( check_id !== undefined ){
                    var id = $(this).attr("id").replaceAll("form-field-", "");;
                    reg.push(id);
                }
            })
            $(".elementor-field-type-radio",form).each(function () { 
                var id = $(this).find("label").attr("for").replaceAll("form-field-", "");;
                reg.push(id);
            })
            $(".elementor-field-type-checkbox",form).each(function () { 
                var id = $(this).find("label").attr("for").replaceAll("form-field-", "");;
                reg.push(id);
            })
            $(".elementor-field-type-select",form).each(function () { 
                var id = $(this).find("select").attr("id").replaceAll("form-field-", "");;
                reg.push(id);
            })
            $(".elementor-field-calculator",form).each( function(){
                var eq = $(this).data("formula");
                eq = eq.replace(/\s/g,'')
                if(eq ==""){
                    return ;
                }
                var form_id = form.data("formid");
                var field = $(this);
                var match;
                var field_regexp = new RegExp( '('+reg.join("|")+')');
                while ( match = field_regexp.exec( eq ) ){ 
                    var vl = match[0];
                    var id = $("#form-field-"+vl,form);
                    if(id.length == 0 ){  
                        var id = $(".elementor-field-group-"+vl,form);
                        vl = "";
                        if( id.hasClass("elementor-field-type-radio") ) {
                            vl = id.find("input:checked").val();
                            if(vl === undefined){
                                vl =0;
                            }
                        }else if(id.hasClass("elementor-field-type-checkbox")){
                            id.find("input:checked").each(function() {
                                var data_vl = $(this).val();
                            vl = mexp.eval( vl +"+"+ data_vl);
                            });
                        }
                        else {
                        vl =0; 
                        }
                    }else{
                        if( id.hasClass("elementor-number-format") ){
                            id.autoNumeric();
                            vl = id.autoNumeric("get");
                        }else{
                            vl = $("#form-field-"+vl,form).val();
                            if( id.hasClass("elementor-field-date-time-date") ) {
                                vl = $.elementor_cover_date_format(vl,id);
                            }
                        }
                    }
                    if(vl == ""){
                        vl = 0;
                    }
                    eq = eq.replace( match[0], vl); 
                }
                eq = $.elementor_fomulas_days(eq);
                eq = $.elementor_fomulas_months(eq);
                eq = $.elementor_fomulas_years(eq);
                eq = $.elementor_fomulas_floor(eq);
                eq = $.elementor_fomulas_floor_2(eq);
                eq = $.elementor_fomulas_mod(eq);
                eq = $.elementor_fomulas_round(eq);
                eq = $.elementor_fomulas_round_2(eq);
                eq = $.elementor_fomulas_age(eq);
                eq = $.elementor_fomulas_age_2(eq)
                eq = $.elementor_fomulas_ceil(eq);
                eq = $.elementor_fomulas_sqrt(eq);
                eq = $.elementor_fomulas_avg(eq);
                eq = $.elementor_fomulas_max(eq);
                eq = $.elementor_fomulas_min(eq);
                eq = $.elementor_fomulas_sum(eq);
                eq = $.elementor_fomulas_log(eq);
                eq = $.elementor_fomulas_rand(eq);
                eq = $.elementor_fomulas_rounded_multiple(eq);
                eq = $.elementor_fomulas_elseif(eq);
                try{
                    var total = mexp.eval(eq); 
                }catch(e){
                }
                if( field.hasClass("elementor-number-format") ){
                    field.autoNumeric();
                    field.autoNumeric("set",total);
                    field.closest('.elementor-field').find(".elementor-number-show").autoNumeric();
                    field.closest('.elementor-field').find(".elementor-number-show").autoNumeric("set",total);
                }else{
                    field.val(total);
                    field.closest('.elementor-field').find(".elementor-number-show").html(total);
                }
            })
        }
        $.elementor_fomulas_rand = function(x){ 
            var re = /random\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                x = x.replace(/[random()]/g, '');
                    var datas = x.split(",");
                    return Math.floor(Math.random() * parseInt(datas[1])) + parseInt(datas[0]);
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_rand(x);
            }
            return x;
        }
        $.elementor_fomulas_log = function(x){ 
            var re = /log10\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    x = x.replace(/log10/g, '');
                    x = mexp.eval(x);
                    return "log "+Math.log(x);
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_log(x);
            }
            return x;
        }
        $.elementor_fomulas_avg = function(x){ 
            var re = /avg\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    x = x.replace(/[agv()]/g, '');
                    var elmt = x.split(",");
                    var sum = 0;
                    for( var i = 0; i < elmt.length; i++ ){
                        sum += parseInt( elmt[i], 10 ); //don't forget to add the base
                    }
                    return sum/elmt.length;
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_avg(x);
            }
            return x;
        }
        $.elementor_fomulas_max = function(x){ 
            var re = /max\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    x = x.replace(/[max()]/g, '');
                    var datas = x.split(",");
                    datas = datas.map(element => {
                        return element.trim();
                        });
                    return Math.max.apply(null,datas);
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_max(x);
            }
            return x;
        }
        $.elementor_fomulas_min = function(x){ 
            var re = /min\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    x = x.replace(/[min()]/g, '');
                    var datas = x.split(",");
                    datas = datas.map(element => {
                        return element.trim();
                    });
                    return Math.min.apply(null,datas);
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_min(x);
            }
            return x;
        }
        $.elementor_fomulas_sum = function(x){ 
            var re = /sum\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    x = x.replace(/[sum()]/g, '');
                    var datas = x.split(",");
                    var sum = 0;
                    for (let i = 0; i < datas.length; i++ ) {
                        sum += parseInt(datas[i]);
                    }
                    console.log(sum);
                    return sum;
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_sum(x);
            }
            return x;
        }
        $.elementor_fomulas_elseif = function(x){ 
            var re = /if\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    return $.elementor_fomulas_if(x);
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_elseif(x);
            }
            return x;
        }
        $.elementor_fomulas_if = function(x){
            x = x.replace(/[if()]/g, '');
            var data = x.split(",");
            var check_data = data[0].split("==");
            if( check_data.length > 1  ){
                if( check_data[0] == check_data[1] ){
                    return mexp.eval(data[1]);
                }else{
                    return mexp.eval(data[2]);
                }
            }else{
                try {
                    if(eval(data[0])){
                        return mexp.eval(data[1]);
                    }else{
                        return mexp.eval(data[2]);
                    }
                } catch (e) {
                    return 0;
                }  
            }
        }
        $.elementor_fomulas_days = function(x){ 
            var re = /days\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    x = x.replace(/[days()]/g, '');
                    var datas = x.split(",");
                    datas = datas.map(element => {
                        return element.trim();
                    });
                    if( datas[1] == "now" ){
                        var today = new Date();
                        var day_end1 = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    }else{
                        var day_end1= datas[1];
                    }
                    var day_end = $.elementor_fomulas_parse_date(day_end1);
                    if( datas[0] == "now" ){
                        var today = new Date();
                        var day_start1 = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                        console.log(day_start1);
                    }else{
                        var day_start1 = datas[0];
                    }
                    var day_start = $.elementor_fomulas_parse_date(day_start1);
                    console.log(day_start);
                    console.log(day_end);
                    if( isNaN(day_end) || isNaN(day_start) ){
                        return 0;
                    }else{
                        return $.elementor_fomulas_datediff(day_end,day_start);
                    }
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_days(x);
            }
            return x;
        }
        $.elementor_fomulas_months = function(x){ 
            var re = /months\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    x = x.replace(/[months()]/g, '');
                    var datas = x.split(",");
                        datas = datas.map(element => {
                        return element.trim();
                    });
                    if( datas[1] == "now" ){
                        var today = new Date();
                        var day_end1 = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    }else{
                        var day_end1= datas[1];
                    }
                    var day_end = $.elementor_fomulas_parse_date(day_end1);
                    if( datas[0] == "now" ){
                        var today = new Date();
                        var day_start1 = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    }else{
                        var day_start1 = datas[0];
                    }
                    var day_start = $.elementor_fomulas_parse_date(day_start1);
                    if( isNaN(day_end) || isNaN(day_start) ){
                        return 0;
                    }else{
                        return day_start.getMonth() - day_end.getMonth() +  (12 * (day_start.getFullYear() - day_end.getFullYear()))
                    }
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_months(x);
            }
            return x;
        }
        $.elementor_fomulas_years = function(x){ 
            var re = /years\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    x = x.replace(/[years()]/g, '');
                    var datas = x.split(",");
                    datas = datas.map(element => {
                        return element.trim();
                    });
                    if( datas[1] == "now" ){
                        var today = new Date();
                        var day_end1 = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    }else{
                        var day_end1= datas[1];
                    }
                    var day_end = $.elementor_fomulas_parse_date(day_end1);
                    if( datas[0] == "now" ){
                        var today = new Date();
                        var day_start1 = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    }else{
                        var day_start1 = datas[0];
                    }
                    var day_start = $.elementor_fomulas_parse_date(day_start1);
                    if( isNaN(day_end) || isNaN(day_start) ){
                        return 0;
                    }else{
                        return day_start.getFullYear() - day_end.getFullYear();
                    }
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_years(x);
            }
            return x;
        }
        $.elementor_fomulas_round = function(x){ 
            var re = /round\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    x = x.replace(/[round()]/g, '');
                    x = mexp.eval(x);
                    return Math.round(x);
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_round(x);
            }
            return x;
        }
        $.elementor_fomulas_round_2 = function(x){ 
            var re = /round2\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    x = x.replace(/[round2()]/g, '');
                    x = mexp.eval(x);
                     return Math.round(x * 100) / 100
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_round_2(x);
            }
            return x;
        }
        $.elementor_fomulas_floor = function(x){ 
            var re = /floor\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    x = x.replace(/[floor()]/g, '');
                    x = mexp.eval(x);
                    return Math.floor(x);
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_floor(x);
            }
            return x;
        }
        $.elementor_fomulas_floor_2 = function(x){ 
            var re = /floor2\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    x = x.replace(/[floor2()]/g, '');
                    x = mexp.eval(x);
                     return Math.floor(x * 100) / 100
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_floor_2(x);
            }
            return x;
        }
        $.elementor_fomulas_ceil = function(x){ 
            var re = /ceil\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    x = x.replace(/[ceil()]/g, '');
                    x = mexp.eval(x);
                    return Math.ceil(x);
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_ceil(x);
            }
            return x;
        }
        $.elementor_fomulas_mod = function(x){ 
            var re = /mod\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    x = x.replace(/[mod()]/g, '');
                    var datas = x.split(",");
                    return  datas[0] % datas[1];
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_mod(x);
            }
            return x;
        }
        $.elementor_fomulas_age = function(x){ 
            var re = /age\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    x = x.replace(/age\(|\)/g, '');
                    var dob = new Date(x);
                    var today = new Date();
                    return Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_age(x);
            }
            return x;
        }
        $.elementor_fomulas_age_2 = function(x){ 
            var re = /age2\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    x = x.replace(/age2\(|\)/g, '');
                    var datas = x.split(",");
                    var dob = new Date(datas[0]);
                    var today = new Date(datas[1]);
                    return Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_age_2(x);
            }
            return x;
        }
        $.elementor_fomulas_sqrt = function(x){ 
            var re = /sqrt\(([^()]*)\)/gm;
            console.log(x);
            x = x.replace( re,function (x) {
                    x = x.replace(/sqrt\(|\)/g, '');
                    console.log(x);
                    if(x != ""){
                        x = mexp.eval(x);
                    }
                    console.log(x);
                    return Math.sqrt(x);
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_sqrt(x);
            }
            return x;
        }
        $.elementor_fomulas_rounded_multiple = function(x){ 
            var re = /rounded_multiple\(([^()]*)\)/gm;
            x = x.replace( re,function (x) {
                    x = x.replace(/rounded_multiple\(|\)/g, '');
                    var datas = x.split(",");
                    var tt1  = mexp.eval(datas[0]);
                    return Math.ceil(tt1 / datas[1]) * datas[1];
                });
            if( x.match(re) ){
                x = $.elementor_fomulas_rounded_multiple(x);
            }
            return x;
        }
        $.elementor_fomulas_parse_date = function(str){
            return new Date(str);
        }
        $.elementor_cover_date_format = function(str,id){
            var date="";
            var format = id.data("date-format");
            if( format == "m/d/Y" ) {
                var datas = str.split("/");
                date = datas[2] + "-" + datas[0] + "-" + datas[1];
            } else if( format == "d/m/Y") {
                var datas = str.split("/");
                date = datas[2] + "-" + datas[1] + "-" + datas[0];
            } else if( format == "F j, Y"){
                date = str;
            }
            return date;
        }
        $.elementor_fomulas_datediff = function(first, second){
            return Math.round((second-first)/(1000*60*60*24));
        }
        $(".elementor-form").each(function(){
            $.elementor_calculator($(this));
        })
        $("body").on("change keyup",".elementor-form input, .elementor-form select",function(e){
            console.log(1);
            var form = $(this).closest("form");
            $.elementor_calculator(form);
        })
        //free
        $.elementor_calculator_free = function(){
            var reg = [];
            $(".elementor-number, .elementor-total").each(function () { 
                var id = $(this).attr("id");
                reg.push(id);
            })
            $(".elementor-total").each( function(){
                var eq = $(this).data("formula");
                var field = $(this);
                if(eq ==""){
                    return ;
                }
                var match;
                var field_regexp = new RegExp( '('+reg.join("|")+')');
                while ( match = field_regexp.exec( eq ) ){ 
                    var vl = match[0];
                    var id = $("#"+vl);
                    if( id.hasClass("elementor-number-format") ){
                        id.autoNumeric();
                        vl = id.autoNumeric("get");
                    }else{
                        vl = $("#"+vl).val();
                        if( id.hasClass("elementor-field-date-time-date") ) {
                            vl = $.elementor_cover_date_format(vl,id);
                        }
                    }
                    eq = eq.replace( match[0], vl); 
                }
                eq = $.elementor_fomulas_elseif(eq);
                eq = $.elementor_fomulas_days(eq);
                eq = $.elementor_fomulas_months(eq);
                eq = $.elementor_fomulas_years(eq);
                eq = $.elementor_fomulas_floor(eq);
                eq = $.elementor_fomulas_mod(eq);
                try{
                    var total = mexp.eval(eq); 
                }catch(e){
                }
                if( field.hasClass("elementor-number-format") ){
                    field.autoNumeric();
                    field.autoNumeric("set",total);
                }else{
                    field.val(total);
                }
            })
        }
        $(".elementor-total").each(function(){ 
            $.elementor_calculator_free();
        })
        $("body").on("change keyup",".elementor-number",function(e){
            $.elementor_calculator_free();
        })
    })
})(jQuery);