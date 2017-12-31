$(function() {
	
	// Default Setup
	//$('select').combobox();
    
    $( "#effectiveDate").datepicker({
        dateFormat: 'yy-mm-dd',
    	changeMonth: true,
    	changeYear: true,
    });
    
	/*
    // Executes while employee were selected
	$("#employeeName").combobox({select : function(event, ui) { 
		
        $("#position").val(ui.item.value);
        $("#position_combobox").val($("#position").find("option:selected").text());
        $("#department").val(ui.item.value);
        $("#department_combobox").val($("#department").find("option:selected").text());
        $("#location").val(ui.item.value);
        $("#location_combobox").val($("#location").find("option:selected").text());
        
        $("#joinDate").val('2007-02-20'); 
        $("#daysEntitled").val('12'); 
        $("#outstandingBalance").val('20'); 
        $("#daysTaken").val('10'); 
        $("#thisLeaveDays").val('3'); 
        $("#revisedDays").val('0'); 
        $("#remainingDays").val('19');  
        
    }});  
    */
}); 