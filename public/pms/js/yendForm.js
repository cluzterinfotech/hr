$(document).ready(function()
{   
	
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
	
	$("#dialogYend").dialog({
		draggable:false,            
        modal: true,
        autoOpen: false,
        height:550,
        width:850,
        zIndex: 12000,
        resizable: false,
        title:'YEAR END FORM',
        position:'top',
	});
    
	
	$(document.body).on('click','.editYend',function(e) { 
		e.preventDefault();
		var id = e.target.id; 
		$("#dialogYend").dialog({ 
		      buttons : {
		        "Update Objective" : function() { 
		        	$.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
		            var formValues = {};
		            var formId = '#yendForm'; 
		            formValues = getValues(formId); 
		            var request = $.ajax({ 
		                url: "/yendform/updateobjective", 
		                type: "POST", 
		                data: { formVal : formValues } 
		            }).done(function(data) { 
		            	clearForm(formId);
		                $.unblockUI(); 
		                $("#dialogYend").dialog("close");
		                $(location).attr('href','/yendform/yend');
		            }).fail(function() { 
		                alert("Error! Problem in saving YEAR END details for this employee");
		            });              
		            return false;
		        },
		        "Cancel" : function() {
		        	$(this).dialog("close");  
		        }
		      }
		}); 
		$("#dialogYend").dialog("open"); 
		var formId = '#yendForm'; 
        loadYendForm(formId,id); 
	});  
    
	
	$(document.body).on('click','.editYendDtls',function(e) { 
		e.preventDefault();
		var id = e.target.id; 
		$("#dialogYend").dialog({ 
		      buttons : {
		        "Update Subobjective" : function() { 
		        	$.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
		            var formValues = {};
		            var formId = '#yendForm'; 
		            formValues = getValues(formId); 
		            var request = $.ajax({ 
		                url: "/yendform/updatesubobjective", 
		                type: "POST", 
		                data: { formVal : formValues } 
		            }).done(function(data) { 
		            	clearForm(formId);
		                $.unblockUI(); 
		                $("#dialogYend").dialog("close");
		                $(location).attr('href','/yendform/yend');
		            }).fail(function() { 
		                alert("Error! Problem in saving YEAR END details for this employee");
		            });              
		            return false;
		        },
		        "Cancel" : function() {
		        	$(this).dialog("close");  
		        }
		      }
		});   
		$("#dialogYend").dialog("open"); 
		var formId = '#yendForm'; 
		loadYendDtlsDtlsForm(formId,id); 
	});
    
    function loadYendForm(formId,id) {
    	var request = $.ajax({ 
            url: "/yendform/getdtlsbyid", 
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
        	
        	$('#Rating').val(obj.Rating);
        	$('#Rating_combobox').val(obj.Rating); 
        	$('#Result').val(obj.Result);
        	$('#Impact').val(obj.Impact);
        	$('#Challenges').val(obj.Challenges);
        	$('#Effort').val(obj.Effort);
        }).fail(function() { 
            alert("Error! Problem in loading details");
        });    
    	return true; 
    }
    
    function loadYendDtlsDtlsForm(formId,id) {
    	var request = $.ajax({ 
            url: "/yendform/getdtlsdtlsbyid", 
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
        	
        	$('#Rating').val(obj.Rating);
        	$('#Rating_combobox').val(obj.Rating);
        	$('#Result').val(obj.Result);
        	$('#Impact').val(obj.Impact);
        	$('#Challenges').val(obj.Challenges);
        	$('#Effort').val(obj.Effort);
        }).fail(function() { 
            alert("Error! Problem in loading details");
        });    
    	return true; 
    } 
}); 