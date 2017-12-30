$(function() {
    
	$( "#joinDate,#confirmationDate," +
			"#incrementFrom,#incrementTo").datepicker({
        dateFormat: 'yy-mm-dd',
    	changeMonth: true,
    	changeYear: true,
    });  
	
	$('#incrementCriteriaForm').validate({  
    	rules: { 
    		Year: { required: true },
    		joinDate: { required: true },
    		confirmationDate: { required: true }
        },  
        messages: { 
        	Year: "please enter year",  
        	joinDate: "please enter join date",  
        	confirmationDate: "please enter confirmation"  
        } 
	}); 
	
	$('#quartileRatingForm').validate({  
    	rules: { 
    		Rating: { required: true },
    		quartileOne: { required: true },
    		quartileTwo: { required: true },
    		quartileThree: { required: true },
    		quartileFour: { required: true },
        },  
        messages: { 
        	Rating: "please enter year",  
        	quartileOne: "please enter Quartile One Percentage",   
        	quartileTwo: "please enter Quartile Two Percentage",  
        	quartileThree: "please enter Quartile Three Percentage",   
        	quartileFour: "please enter Quartile Four Percentage"  
        } 
	});
	
	$('#salaryStructureForm').validate({  
    	rules: { 
    		salaryGradeId_combobox: { required: true },
    		minValue: { required: true },
    		midValue: { required: true },
    		maxValue: { required: true }, 
        },  
        messages: { 
        	salaryGradeId_combobox: "please enter year",  
        	minValue: "please enter Quartile One Percentage",   
        	midValue: "please enter Quartile Two Percentage",  
        	maxValue: "please enter Quartile Three Percentage" 
        } 
	});
	
}); 