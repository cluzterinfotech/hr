$(function() {
	
	// Default Setup
	$('select').combobox();
	$("#travelingFormEmpPosition").combobox("option", "disabled", true); 
    // $("#department").combobox("option", "disabled", true);
    // $("#location").combobox("option", "disabled", true);
    
    $( "#effectiveFrom,#effectiveTo").datepicker({ 
        dateFormat: 'yy-mm-dd', 
    	changeMonth: true,
    	changeYear: true,
    });   
	
    // Executes while employee were selected
	$("#employeeNumberTravelingLocal").combobox({select : function(event,ui) {  
		// console.log(ui); 
		// todo - using selected employee number get basic info  through ajax 
		var request = $.ajax({ 
            url: '/travelinglocal/employeeposition',   
            type: "POST",  
            data: {  
            	empNumber:ui.item.value  
            }  
        }).done(function(data) {  
            var obj = jQuery.parseJSON(data);
            $("#travelingFormEmpPosition").val($.trim(obj.position));
            $("#travelingFormEmpPosition_combobox").val(
            	$("#travelingFormEmpPosition").find("option:selected").text());
            validateDelegation(); 
        }).fail(function() {
            alert("Sorry! an error occured"); 
        });
        
    }});     
	
	function getDaysBetweenDate(from,to) { 
    	var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
		var firstDate = new Date(from); 
		var secondDate = new Date(to); 
		return Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay))); 
    }  
	
	$('#leaveFrom,#leaveTo').on('change', function (event) {
		prepareThisLeaveDays();   
		
    });  
	
	// $('#employeeNumberTravelingLocal,#delegatedEmployee').on('change', function (event) {
	$("#delegatedEmployee").combobox({select : function(event,ui) { 
		//console.log("chage event"); 
		validateDelegation(); 
		// prepareThisLeaveDays();   
	}});     
	
	function validateDelegation() {
		if($("#employeeNumberTravelingLocal").val() == $("#delegatedEmployee").val()) { 
		    alert("please change delegated employee"); 
		    // id="delegatedEmployee_combobox" 
		    $("#delegatedEmployee_combobox").val(" "); 
		    $("#delegatedEmployee").val(" ");  
		}   	
	}     
	
	function prepareThisLeaveDays() { 
		var from = $("#leaveFrom").val();  
		var to = $("#leaveTo").val();   
		if(from && to) { 
		    var days = getDaysBetweenDate(from,to) + 1; 
		    days = (days * 1);  
		    $("#thisLeaveDays").val(days);   
		    var entitlement = $("#daysEntitled").val();    
		    var outstandingBalance = $("#outstandingBalance").val();   
		    var daysTaken = $("#daysTaken").val();   
		    // daysEntitled + outstandingBalance-alreadyTaken-thisDays 
		    var remainingDays =  (entitlement * 1) + (outstandingBalance * 1) -
		    (daysTaken * 1) - (days * 1);  
		    $("#remainingDays").val(remainingDays);     
		}  	
	}  
	
	$("#travelingLocalForm").validate({   
    	rules: {  
    		employeeNumberTravelingLocal_combobox: { required: true },
    		meansOfTransport_combobox: { required: true }, 
        	delegatedEmployee_combobox: { required: true },
        	position_combobox: { required: true }, 
        	fuelLiters : { required: true,number: true},
        	amount : { required: true,number: true}, 
        	expensesRequired : { required: true,number: true}, 
        	expenseApproved : { required: true,number: true}, 
        	effectiveFrom: { required: true },
        	effectiveTo: { greaterThan: ['#effectiveFrom','#employeeNumberTravelingLocal'] } 
        },    
        messages: { 
        	employeeNumberTravelingLocal_combobox: "please select Employee",
        	meansOfTransport_combobox: "please select Means of transport",
        	fuelLiters : "please enter valid number", 
        	amount : "please enter valid number", 
        	expensesRequired : "please enter valid number", 
        	expenseApproved : "please enter valid number", 
        }
    });   
	
}); 