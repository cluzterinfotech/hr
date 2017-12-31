$(document).ready(function()
{   
	$('#differenceFromDate,#differenceToDate').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: new Date(),
	    changeMonth: true,
	    changeYear: true,
    }); 
	
	$("#dialog").dialog({
	    autoOpen: false,
	    modal: true
	});
	
	$("#differenceForm").validate({ 
    	rules: { 
    		differenceFromDate: { required: true },
    		differenceToDate: { required: true },
    		diffShortDescription: { required: true },
	
        },
        messages: {
        	differenceFromDate: "Please enter difference from date",
        	differenceToDate: "Please enter difference to date",
        	diffShortDescription: "Please enter short description about difference",
        }
    });
	
    
}); 