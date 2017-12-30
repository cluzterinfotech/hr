$(document).ready(function()
{   
	$('#effectiveDate,#appliedDate').datepicker({
        dateFormat: 'yy-mm-dd',
	    changeMonth: true,
	    changeYear: true,
    }); 
	
	$("#dialog").dialog({
	    autoOpen: false,
	    modal: true
	}); 
	
	$(document.body).on('click','.removePositionAllowanceRow a',function(e) { 
		e.preventDefault(); 
		//console.log("Position allowance working"); 
		targetUrl = $(this).attr('href'); 
		$("#dialog").dialog({ 
		      buttons : {
		        "Remove" : function() { 
		            var request = $.ajax({
		                url: targetUrl,
		                type: "POST",
		            }).done(function(data) {    
                        // console.log("success");
                        table(); 	                
		          }).fail(function() {
		              alert("Error! Problem in removing position allowance"); 
		          });    
		          $(this).dialog("close"); 
		          return true; 	          
		        }, 
		        "Cancel" : function() {
		        	$(this).dialog("close");  
		        }
		      }
		}); 
		$("#dialog").dialog("open"); 
	}); 
	
	/*$(document.body).on('click','.editPositionAllowanceRow a',function(e) { 
		e.preventDefault(); 
		//console.log("Position allowance working"); 
		targetUrl = $(this).attr('href'); 
		$("#edit").dialog({ 
		      buttons : {
		        "Update" : function() { 
		            var request = $.ajax({
		                url: targetUrl,
		                type: "POST",
		            }).done(function(data) {    
                        // console.log("success");
                        table(); 	                
		          }).fail(function() {
		              alert("Error! Problem in removing position allowance"); 
		          });    
		          $(this).dialog("close"); 
		          return true; 	          
		        }, 
		        "Cancel" : function() {
		        	$(this).dialog("close");  
		        }
		      }
		}); 
		$("#edit").dialog("open"); 
	});*/ 
    
    $('#positionAllowanceForm').submit(function(e) { 
    	e.preventDefault(); 
    	// console.log("Position form submit working");
    }).validate({ 
    	rules: { 
    		positionName_combobox: { required: true },
    		positionAllowanceName_combobox: { required: true }, 
        }, 
        messages: { 
        	positionName_combobox: "please select position",
        	positionAllowanceName_combobox: "please select allowance",
        }, 
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {};
            var formArray = $("#positionAllowanceForm").serializeArray(); 
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
            var request = $.ajax({ 
                url: "/positionallowance/savepositionallowance", 
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {                                  
            	clearPositionAllowanceForm(); 
                table(); 
                $.unblockUI(); 
            }).fail(function() { 
                alert("Error! Problem in saving this position allowance"); 
            });              
            return false; 
        }
    }); 
    
    function clearPositionAllowanceForm()
    { 
    	$('#positionName').val("");
    	$('#positionName_combobox').val(""); 
    	$('#positionAllowanceName').val("");
    	$('#positionAllowanceName_combobox').val("");  
        return 0; 
    } 
    
    // loads table on page load 
    // table();
    
    function table() { 
        $("#positionAllowanceContainer").zfTable('/positionallowance/ajaxlistnew', {
            sendAdditionalParams: function() {
                var data = $('#positionAllowanceForm').serialize();  
                return '&' + data;
            },
         }); 
    }  
    
}); 