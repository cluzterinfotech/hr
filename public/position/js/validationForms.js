$(document).ready(function()
{   
    $("#positionForm").validate({ 
    	rules: { 
    		section_combobox: { required: true },
    		reportingPosition_combobox: { required: true },
    		status_combobox: { required: true },
    		organisationLevel_combobox: { required: true },
        },
        messages: { 
        	section_combobox: "please select Section", 
        	reportingPosition_combobox: "please select reporting position",
        	status_combobox: "please select position status", 
        	organisationLevel_combobox: "please select organisation level",
        }
    }); 
    

}); 