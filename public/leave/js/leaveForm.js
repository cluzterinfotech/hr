$(function() {
	
	// Default Setup
	$('select').combobox();
	$("#position").combobox("option", "disabled", true);
    $("#department").combobox("option", "disabled", true);
    $("#location").combobox("option", "disabled", true);
    
    $( "#leaveFrom,#leaveTo").datepicker({
        dateFormat: 'yy-mm-dd',
    	changeMonth: true,
    	changeYear: true,
    });
	
    // Executes while employee were selected
	$("#employeeNameAnnualLeave").combobox({select : function(event, ui) { 
		// console.log(ui);
		// todo - using selected employee number get basic info  through ajax 
		var request = $.ajax({
            url: '/annualleave/employeeleaveinfo', 
            type: "POST",
            data: {  
                empNumber:ui.item.value
            } 
        }).done(function(data) { 
            var obj = jQuery.parseJSON(data);
            $("#positionId").val($.trim(obj.position));
            $("#positionId_combobox").val($("#positionId").find("option:selected").text());
            $("#departmentId").val($.trim(obj.department));
            $("#departmentId_combobox").val($("#departmentId").find("option:selected").text());
            $("#locationId").val($.trim(obj.location));
            $("#locationId_combobox").val($("#locationId").find("option:selected").text());  
            $("#joinDate").val(obj.doj); 
            $("#daysEntitled").val(obj.daysEntitled); 
            $("#outstandingBalance").val(obj.outstandingBalance); 
            $("#daysTaken").val(obj.daysTaken); 
            $("#thisLeaveDays").val(obj.thisLeaveDays); 
            $("#revisedDays").val(obj.revisedDays); 
            $("#remainingDays").val(obj.remainingDays);  
            prepareThisLeaveDays();
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
	
}); 