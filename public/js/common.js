/*
 * any common applied functions should be included in this js file
 */ 
$(function() { 
	if (window!=top) { top.location.href=location.href; } 
	/*var omitformtags=["input", "textarea", "select"]
	omitformtags=omitformtags.join("|")
	function disableselect(e){
	    if (omitformtags.indexOf(e.target.tagName.toLowerCase())==-1)
	    return false
	}
	function reEnable() {
	    return true
	}
	if (typeof document.onselectstart!="undefined")
	    document.onselectstart=new Function ("return false")
	else {
	    document.onmousedown=disableselect
	    document.onmouseup=reEnable
	}*/
	
	$( "#startingDate,#endingDate,#otDate").datepicker({
        dateFormat: 'yy-mm-dd',
    	changeMonth: true,
    	changeYear: true,
    });
	//$('#fromTime,#toTime').timepicker();
	//$( "#fromTime").timepicker({
        //dateFormat: 'yy-mm-dd',
    	//changeMonth: true,
    	//changeYear: true,
    //});
	
	$( "#stmtDate,#leaveFromDate,#leaveToDate").datepicker({
        dateFormat: 'yy-mm-dd',
    	changeMonth: true,
    	changeYear: true,
    });
	
	$( "#paidDate,#fromDate,#toDate,#otFromDate,#otToDate").datepicker({
        dateFormat: 'yy-mm-dd',
    	changeMonth: true,
    	changeYear: true,
    });
	
	$( "#joinDate,#confirmationDate,#declarationDate,#bonusFrom,#bonusTo").datepicker({
        dateFormat: 'yy-mm-dd',
    	changeMonth: true,
    	changeYear: true,
    });
    
	$("#tabs").tabs();
    
    $(':input[type="text"]').addClass("ui-corner-all");
    $("textarea").addClass("ui-corner-all");
    $("textarea").css("width","250"); 
    $(':input[type="submit"]').button(); //.val("Submit");
    $(':input[type="password"]').addClass("ui-corner-all");
    $('select').combobox();
    $(':input[type="number"]').addClass("ui-corner-all");
    
    $.validator.setDefaults({
        errorPlacement: function(error, element)
        {
            element.attr('title', error.text());
            $(".error").tooltip(
            {
                position: 
                {
                    my: "left+29 center", 
                    at: "right center" 
                },  
                tooltipClass: "ttError" 
            });  
        }    
    });  
    
    /*$.validator.addMethod("greaterThan", 
        function(value, element, params) {
    	//return false; 
            if (!/Invalid|NaN/.test(new Date(value))) {
            	return new Date(value) >= new Date($(params[0]).val());
            }
        	return isNaN(value) && isNaN($(params[0]).val()) 
       	        || (Number(value) >= Number($(params[0]).val())); 
       	},'Must be greater than {0}.'
    );*/   
    
    /*var dispError = function() {
        return telNumberErrors[telNumberErrorNo];
    }*/
    
    $.validator.addMethod("greaterThan", 
    	function(value, element, params) { 
    	    var validator = this; 
     	    var errors = {};
     	    //validator.showErrors(errors); 
   		    var request = $.ajax({
            url: '/annualleave/ishaveoverlap', 
            type: "POST",
            data: {  
            	empNumber:$(params[1]).val(),
                fromDate:$(params[0]).val(),
                toDate:value
             }, 
             async: false
         }).done(function(data) {
        	 var obj = jQuery.parseJSON(data); 
        	 //console.log(obj); 
        	 //console.log(obj.success);
        	 if(obj.success == 1) {
        		 //console.log("inside success");
        		 return true; 
        	 } else { 
        		 errors[element.name] =  obj.message; 
        		 validator.showErrors(errors); 
        		 //console.log("inside fail"); 
        		 return false;   
        	 } 
        	 return true; 
         }).fail(function() { 
             alert("Sorry! error in validating date");  
         });  
   		 return true; 
    	},' '
    ); 
    
    $.validator.addMethod("dobRange", 
        function(value, element,params) { 
    	    var startDt = new Date(); 
    	    // alert(startDt); 
    	    var maxDate = new Date(startDt.getFullYear() - 17,startDt.getMonth(),startDt.getDate()); 
    	    //alert(maxDate); 
    	    // var endDt = 
	    	// var minDate = Date.parse("1940-01-01"); 
		    //var maxDate = Date.parse("2006-01-01");
		    var valueEntered = Date.parse($(params[0]).val()); 
            if(valueEntered > maxDate) {
            	//alert("fasle"); 
            	return false;  
            }
            return !/Invalid|NaN/.test(new Date(minDate)) 
        },
        "Please enter a valid date"
    ); 
    
    $.validator.addMethod("dojRange", 
            function(value, element,params) { 
        	    var startDt = new Date(); 
        	    var maxDate = new Date(startDt.getFullYear(),startDt.getMonth()-1,startDt.getDate()); 
    		    var valueEntered = Date.parse($(params[0]).val()); 
    		    var maxDt = Date.parse(maxDate);
                if(maxDt > valueEntered) {
                	return false;  
                }
                return !/Invalid|NaN/.test(new Date(minDate)) 
            },
            "Please enter a valid date"
        );
    
   /* $.validator.addMethod("overlap", 
        function(value, element, params) {
    	    //console.log("test overlap start");
        	//console.log(value);
        	//console.log(element);
        	//console.log(params);
        	//console.log("test overlap");
        	
        	},'you already have other leave {0}.'
    );*/ 
    
    $.validator.addMethod("empDelegatedEmp", 
        function(value, element, params) { 
    	    //alert(value); 
    	    //alert($(params).val()); 
    	return 0; 
       },'Error! Delegated employee and employee are same.'
    ); 
    
    $.datepicker.setDefaults({
    	    changeMonth: true,
    	    changeYear: true,
    	    dateFormat: 'yy-mm-dd', 
    }); 
    
    $("#navigation").treeview({
	    collapsed: true,
	    unique: true,
	    persist: "location"
	});
    
    $("#dialog").dialog({
	    autoOpen: false,
	    modal: true
	}); 
    
    $( "#applyeEfectiveDate").datepicker({
        dateFormat: 'yy-mm-dd',
    	changeMonth: true,
    	changeYear: true,
    }); 
    
    $("#applyeEfectiveDateForm").validate({ 
    	rules: { 
    		applyeEfectiveDate: { required: true } 
        },
        messages: {
        	joinDate: "Please enter effective date"
        }
    }); 
    
    
    
}); 