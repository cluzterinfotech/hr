$(document).ready(function()
{   
	$("#submitIpcToSup").button(); 
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
	
	$("#dialogIpc").dialog({
		draggable:false,            
        modal: true,
        autoOpen: false,
        height:550,
        width:850,
        zIndex: 12000,
        resizable: false,
        title:'IPC FORM',
        position:'top',
	});
	//pmsMainNew
	$(document.body).on('click','.pmsMainNew',function(e) { 
		e.preventDefault();
		var id = e.target.id; 
		var formId = '#ipcForm';
		clearForm(formId);
		$('#ipcids').val(id);
		$("#dialogIpc").dialog({ 
		      buttons : {
		        "Add New Objective" : function() { 
		        	$.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
		            var formValues = {};
		            var formId = '#ipcForm'; 
		            formValues = getValues(formId); 
		            var request = $.ajax({ 
		                url: "/pmsform/saveobjective", 
		                type: "POST", 
		                data: { formVal : formValues } 
		            }).done(function(data) { 
		            	clearForm(formId);
		                $.unblockUI(); 
		                $("#dialogIpc").dialog("close");
		                $(location).attr('href','/pmsform/ipc');
		            }).fail(function() { 
		                alert("Error! Problem in saving IPC details for this employee");
		            });              
		            return false;
		        },
		        "Cancel" : function() {
		        	$(this).dialog("close");  
		        }
		      }
		}); 
		$("#dialogIpc").dialog("open"); 
	});
	
	$(document.body).on('click','.pmsSubNew',function(e) { 
		e.preventDefault();
		var id = e.target.id; 
		var formId = '#ipcForm';
		clearForm(formId);
		$('#ipcids').val(id);
		$("#dialogIpc").dialog({ 
		      buttons : {
		        "Add Sub Objective" : function() { 
		        	$.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
		            var formValues = {};
		            var formId = '#ipcForm'; 
		            formValues = getValues(formId); 
		            var request = $.ajax({ 
		                url: "/pmsform/savenewsubobjective", 
		                type: "POST", 
		                data: { formVal : formValues } 
		            }).done(function(data) { 
		            	clearForm(formId);
		                $.unblockUI(); 
		                $("#dialogIpc").dialog("close");
		                $(location).attr('href','/pmsform/ipc');
		            }).fail(function() { 
		                alert("Error! Problem in saving IPC details for this employee");
		            });              
		            return false;
		        },
		        "Cancel" : function() {
		        	$(this).dialog("close");  
		        }
		      }
		}); 
		$("#dialogIpc").dialog("open"); 
	});
	
	$(document.body).on('click','.editIpc',function(e) { 
		e.preventDefault();
		var id = e.target.id; 
		$("#dialogIpc").dialog({ 
		      buttons : {
		        "Update Objective" : function() { 
		        	$.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
		            var formValues = {};
		            var formId = '#ipcForm'; 
		            formValues = getValues(formId); 
		            var request = $.ajax({ 
		                url: "/pmsform/updateobjective", 
		                type: "POST", 
		                data: { formVal : formValues } 
		            }).done(function(data) { 
		            	clearForm(formId);
		                $.unblockUI(); 
		                $("#dialogIpc").dialog("close");
		                $(location).attr('href','/pmsform/ipc');
		            }).fail(function() { 
		                alert("Error! Problem in saving IPC details for this employee");
		            });              
		            return false;
		        },
		        "Cancel" : function() {
		        	$(this).dialog("close");  
		        }
		      }
		}); 
		$("#dialogIpc").dialog("open"); 
		var formId = '#ipcForm'; 
        loadIpcForm(formId,id); 
	});  
    
	
	$(document.body).on('click','.editIpcDtls',function(e) { 
		e.preventDefault();
		var id = e.target.id; 
		$("#dialogIpc").dialog({ 
		      buttons : {
		        "Update Subobjective" : function() { 
		        	$.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
		            var formValues = {};
		            var formId = '#ipcForm'; 
		            formValues = getValues(formId); 
		            var request = $.ajax({ 
		                url: "/pmsform/updatesubobjective", 
		                type: "POST", 
		                data: { formVal : formValues } 
		            }).done(function(data) { 
		            	clearForm(formId);
		                $.unblockUI(); 
		                $("#dialogIpc").dialog("close");
		                $(location).attr('href','/pmsform/ipc');
		            }).fail(function() { 
		                alert("Error! Problem in saving IPC details for this employee");
		            });              
		            return false;
		        },
		        "Cancel" : function() {
		        	$(this).dialog("close");  
		        }
		      }
		}); 
		$("#dialogIpc").dialog("open"); 
		var formId = '#ipcForm'; 
		loadIpcDtlsDtlsForm(formId,id); 
	});
	
    
	$(document.body).on('click','.deleteIpc',function(e) { 
		e.preventDefault();
		var idd = e.target.id;
		var id = idd.substring(1,idd.length); 
		//var id = e.target.id; 
		$("#dialogIpc").dialog({ 
		      buttons : {
		        "Delete Objective" : function() { 
		        	$.blockUI({ message: '<h4>Please Wait...while removing Data</h4>' });
		            var formValues = {};
		            var formId = '#ipcForm'; 
		            formValues = getValues(formId); 
		            var request = $.ajax({ 
		                url: "/pmsform/deleteobjective", 
		                type: "POST", 
		                data: { formVal : formValues } 
		            }).done(function(data) { 
		            	clearForm(formId);
		                $.unblockUI(); 
		                $("#dialogIpc").dialog("close");
		                $(location).attr('href','/pmsform/ipc');
		            }).fail(function() { 
		                alert("Error! Problem in deleting IPC details for this employee");
		            });              
		            return false;
		        },
		        "Cancel" : function() {
		        	$(this).dialog("close");  
		        }
		      }
		}); 
		$("#dialogIpc").dialog("open"); 
		var formId = '#ipcForm'; 
        loadIpcForm(formId,id); 
	});
	
	$(document.body).on('click','.deleteIpcDtls',function(e) { 
		e.preventDefault();
		var idd = e.target.id;
		var id = idd.substring(1,idd.length);
		$("#dialogIpc").dialog({ 
		      buttons : {
		        "Delete Subobjective" : function() { 
		        	$.blockUI({ message: '<h4>Please Wait...while delete Data</h4>' });
		            var formValues = {};
		            var formId = '#ipcForm'; 
		            formValues = getValues(formId); 
		            var request = $.ajax({ 
		                url: "/pmsform/deletesubobjective", 
		                type: "POST", 
		                data: { formVal : formValues } 
		            }).done(function(data) { 
		            	clearForm(formId);
		                $.unblockUI(); 
		                $("#dialogIpc").dialog("close");
		                $(location).attr('href','/pmsform/ipc'); 
		            }).fail(function() { 
		                alert("Error! Problem in deleting IPC details for this employee");
		            });              
		            return false;
		        },
		        "Cancel" : function() {
		        	$(this).dialog("close");  
		        }
		      }
		}); 
		$("#dialogIpc").dialog("open"); 
		var formId = '#ipcForm'; 
		loadIpcDtlsDtlsForm(formId,id); 
	});
	
    
    function loadIpcForm(formId,id) {
    	var request = $.ajax({ 
            url: "/pmsform/getdtlsbyid", 
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
        }).fail(function() { 
            alert("Error! Problem in loading details");
        });    
    	return true; 
    }
    
    function loadIpcDtlsDtlsForm(formId,id) {
    	var request = $.ajax({ 
            url: "/pmsform/getdtlsdtlsbyid", 
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
        }).fail(function() { 
            alert("Error! Problem in loading details");
        });    
    	return true; 
    } 
    
    $('#submitIpcToSup').on('click',function(e) {  
		e.preventDefault();     	
		$("#subIpcToSupDialog").dialog({
		      buttons : {
		        "Yes" : function() {       
		            var request = $.ajax({
		                url: "/pmsform/submittosup", 
		                type: "POST",
		                /*data: { 
	                    	from : f,
	                    	to : t,
	                    	employee:emp 
	                    },*/  
		            }).done(function(data) {  	            	
		            	var obj = jQuery.parseJSON(data); 
		            	if(obj.s == 12) {
		            		alert(obj.m); 
		            	} else {
		            		window.location.replace("/pmsform/status");
		            	}
		               
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