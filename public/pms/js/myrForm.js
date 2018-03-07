$(document).ready(function()
{   
	$("#submitMyrToSup").button(); 
	function getValues(formId) { 
    	var formValues = {};
    	var formArray = $(formId).serializeArray(); 
        $.each(formArray, function() {
            if (formValues[this.name]) {
                if (!formValues[this.name].push) {
                	formValues[this.name] = [formValues[this.name]];
                }
                formValues[this.name].push(this.value || '');
            } else {
            	formValues[this.name] = this.value || '';
            }
        }); 
        return formValues; 
    }
    
    function clearForm(formId) {
    	var formValues = {};
    	var formArray = $(formId).serializeArray(); 
        $.each(formArray, function() {
        	var nme = this.name;
	    	$('#'+this.name).val("");
	    	
        }); 
        return true;
    }
	
	//$('textarea').autogrow({onInitialize: true});
	$('#effectiveDate,#appliedDate').datepicker({
        dateFormat: 'yy-mm-dd',
	    changeMonth: true,
	    changeYear: true,
    }); 
	
	$("#dialogMyr").dialog({
		draggable:false,            
        modal: true,
        autoOpen: false,
        height:550,
        width:850,
        zIndex: 12000,
        resizable: false,
        title:'MYR FORM',
        position:'top',
	});
    
	
	$(document.body).on('click','.editMyr',function(e) { 
		e.preventDefault();
		var id = e.target.id; 
		$("#dialogMyr").dialog({ 
		      buttons : {
		        "Update Objective" : function() { 
		        	$.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
		            var formValues = {};
		            var formId = '#myrForm'; 
		            formValues = getValues(formId); 
		            var request = $.ajax({ 
		                url: "/myrform/updateobjective", 
		                type: "POST", 
		                data: { formVal : formValues } 
		            }).done(function(data) { 
		            	clearForm(formId);
		                $.unblockUI(); 
		                $("#dialogMyr").dialog("close");
		                $(location).attr('href','/myrform/myr');
		            }).fail(function() { 
		                alert("Error! Problem in saving MYR details for this employee");
		            });              
		            return false;
		        },
		        "Cancel" : function() {
		        	$(this).dialog("close");  
		        }
		      }
		}); 
		$("#dialogMyr").dialog("open"); 
		var formId = '#myrForm'; 
        loadMyrForm(formId,id); 
	});  
    
	
	$(document.body).on('click','.editMyrDtls',function(e) { 
		e.preventDefault();
		var id = e.target.id; 
		$("#dialogMyr").dialog({ 
		      buttons : {
		        "Update Subobjective" : function() { 
		        	$.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
		            var formValues = {};
		            var formId = '#myrForm'; 
		            formValues = getValues(formId); 
		            var request = $.ajax({ 
		                url: "/myrform/updatesubobjective", 
		                type: "POST", 
		                data: { formVal : formValues } 
		            }).done(function(data) { 
		            	clearForm(formId);
		                $.unblockUI(); 
		                $("#dialogMyr").dialog("close");
		                $(location).attr('href','/myrform/myr');
		            }).fail(function() { 
		                alert("Error! Problem in saving MYR details for this employee");
		            });              
		            return false;
		        },
		        "Cancel" : function() {
		        	$(this).dialog("close");  
		        }
		      }
		}); 
		$("#dialogMyr").dialog("open"); 
		var formId = '#myrForm'; 
		loadMyrDtlsDtlsForm(formId,id); 
	});
    
    function loadMyrForm(formId,id) {
    	var request = $.ajax({ 
            url: "/myrform/getdtlsbyid", 
            type: "POST", 
            data: { dtlsid : id } 
        }).done(function(data) { 
        	var obj = jQuery.parseJSON(data); 
        	$('#ipcids').val(obj.id);
        	$('#Obj_Desc').val(obj.Obj_Desc);
        	$('#Obj_Weightage').val(obj.Obj_Weightage);
        	$('#Obj_PI').val(obj.Obj_PI);
        	$('#Obj_Base').val(obj.Obj_Base);
        	$('#Obj_Stretch_02').val(obj.Obj_Stretch_02);
        	$('#Obj_Stretch_01').val(obj.Obj_Stretch_01);
        	$('#Myr_Result').val(obj.Myr_Result);
        	$('#Myr_Gap').val(obj.Myr_Gap);
        	$('#Myr_Action_Plan').val(obj.Myr_Action_Plan);
        	$('#Myr_Superior_Comments').val(obj.Myr_Superior_Comments);
        }).fail(function() { 
            alert("Error! Problem in loading details");
        });    
    	return true; 
    }
    
    function loadMyrDtlsDtlsForm(formId,id) {
    	var request = $.ajax({ 
            url: "/myrform/getdtlsdtlsbyid", 
            type: "POST", 
            data: { dtlsid : id } 
        }).done(function(data) { 
        	var obj = jQuery.parseJSON(data); 
        	$('#ipcids').val(obj.id);
        	$('#Obj_Desc').val(obj.Obj_Desc);
        	$('#Obj_Weightage').val(obj.Obj_Weightage);
        	$('#Obj_PI').val(obj.Obj_PI);
        	$('#Obj_Base').val(obj.Obj_Base);
        	$('#Obj_Stretch_02').val(obj.Obj_Stretch_02);
        	$('#Obj_Stretch_01').val(obj.Obj_Stretch_01);
        	
        	$('#Myr_Result').val(obj.Myr_Result);
        	$('#Myr_Gap').val(obj.Myr_Gap);
        	$('#Myr_Action_Plan').val(obj.Myr_Action_Plan);
        	$('#Myr_Superior_Comments').val(obj.Myr_Superior_Comments);
        }).fail(function() { 
            alert("Error! Problem in loading details");
        });    
    	return true; 
    }
    
    $('#submitMyrToSup').on('click',function(e) {  
		e.preventDefault();     	
		$("#subMyrToSupDialog").dialog({
		      buttons : {
		        "Yes" : function() {    
		        	$.blockUI({ message: '<h4>Please Wait...while checking form</h4>' });
		            var request = $.ajax({
		                url: "/myrform/submittosup", 
		                type: "POST",
		                /*data: { 
	                    	from : f,
	                    	to : t,
	                    	employee:emp 
	                    },*/  
		            }).done(function(data) {  	            	
		            	var obj = jQuery.parseJSON(data); 
		            	if(obj.s == 12) {
		            		$.unblockUI(); 
		            		alert(obj.m); 
		            	} else {
		            		window.location.replace("/pmsform/status");
		            	}
		            	//$.unblockUI(); 
		          }).fail(function() {
		              alert("Error! Problem in submitting to supervisor"); 
		          });     
		              $(this).dialog("close"); 
		              return true;   	          
		        },  
		        "No" : function() { 
		        	$(this).dialog("close");    
		        } 
		      }
		});  
		$("#subToSupDialog").dialog("open"); 
	}); 
}); 