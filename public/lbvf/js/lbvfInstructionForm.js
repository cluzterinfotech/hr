$(document).ready(function()
{   
	$('#DeadLine,#DeadLineAssessment').datepicker({
        dateFormat: 'yy-mm-dd',
	    changeMonth: true,
	    changeYear: true,
    }); 
	
	$("#instructionForm").validate({ 
    	rules: {  
    		LbvfName: { required: true },
    		DeadLine: { required: true },
    		DeadLineAssessment: { required: true },
    		Notes: { required: false },
    		Status_combobox: { required: true },
    		NominationEndorsement_combobox: { required: true },
    		AllowAssess_combobox: { required: true },
    		AllowReport_combobox: { required: true }
        }, messages: {  
        	LbvfName: "please Enter LBVF Name",
        	DeadLine: "please Enter Deadline Nomination and Endorsement Date",
        	DeadLineAssessment: "please Enter Deadline for assessment",
        	Notes: "please enter Notes",
        	Status_combobox: "please select state",
        	NominationEndorsement_combobox: "please select employee type",
        	AllowAssess_combobox: "please select employee salary grade",
        	AllowReport_combobox: "please select employee job grade", 
        }   
    }); 
	
    
}); 