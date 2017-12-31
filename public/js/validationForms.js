$(document).ready(function()
{   
    $("#position").validate({ 
        rules: {
            reportingPosition_combobox: {required: true},
            section_combobox: {required: true},
            positionid: {required:true,minlength:5},
            positionName: {required:true}
        },
        messages: {
            reportingPosition_combobox: "please select Reporting Position",
            section_combobox: "please select section",
            positionid: "please enter position id, min 5 char",
            positionName: "please enter Position name,min 5 char",  
        }
    }); 
    
    $("#LocationForm").validate({
    	rules: {
        	locationName: { required: true,minlength:3 },
        	overtimeHour: { required: true,minlength:3,maxlength:3 },
        	locationStatus_combobox: { required: true }
        },
        messages: {
        	locationName: "please enter location name",
        	locationStatus_combobox: "please select location status",
        	overtimeHour:"Please check working hours"
        }
    }); 
    
    // Effective date form validation compulsory for all
    $('#EffectiveDateForm').validate({ 
    	rules: { }, 
        messages: { }
    }); 
    
}); 