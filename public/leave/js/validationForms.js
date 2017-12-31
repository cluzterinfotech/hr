$(function() { 
	
    $("#annualLeaveForm").validate({ 
    	rules: { 
    		employeeNameAnnualLeave_combobox: { required: true },
        	advanceRequired_combobox: { required: true },
        	delegatedEmployee_combobox: { required: true }, 
        	position_combobox: { required: true }, 
        	department_combobox: { required: true }, 
        	location_combobox: { required: true }, 
        	joinDate: { required: true },
        	daysEntitled: { required: true },
    		leaveFrom: { required: true },
    		leaveTo: { greaterThan: ['#leaveFrom','#employeeNameAnnualLeave'] } 
        },  
        messages: {
        	joinDate: "please enter join date",
        	leaveFrom: "please enter Leave from date",
        	//leaveTo: "Please enter Leave to date, Should be greater than or equal to from",
        	employeeNameAnnualLeave_combobox: "please select Employee" 
        }
    }); 
    
    /*$("#delegatedEmployee").autocomplete({
    	  source : yourSource,
    	  change : yourChangeHandler
    });*/
    /*$(function () {  
        var companyList = $("#delegatedEmployee").autocomplete({ 
    	        change: function() {
    	            alert('changed');
    	        }
    	});
    	companyList.autocomplete('option','change').call(companyList);
    });
    var companyList = $("#delegatedEmployee").autocomplete({ 
        change: function() {
            alert('changed');
        }
     });*/
    /*$("#delegatedEmployee").autocomplete({
    	  //source : yourSource,
    	  change : function() {
              alert('changed');
          }
    });*/ 
    /*var cb = $("#delegatedEmployee").combobox();
    cb.combobox.onChange = function() {
        alert('test'); //Other logic to update hidden elements.
    };
    $("#delegatedEmployee").change(function() {
    	alert("test");
        alert($(this).val()); 
    });*/ 
    $('select').on('change', function (event) {
    	alert('text'); 
    });  
    //$($('.ui-combobox-input')[3]).css('width','300px'); 
    //$("#toggle").click(function () {
        //$("#Supplier_Sel").toggle(); 
    //}); 
    //$("#delegatedEmployee").data("ui-autocomplete")._trigger("change")
    //companyList.autocomplete('option','change').call(companyList);
    /*$("select").on('change',function() {
    	alert("test");
        alert($(this).val());
    });*/ 
    
    
}); 