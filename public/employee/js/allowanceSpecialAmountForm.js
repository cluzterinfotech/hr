$(document).ready(function()
{   
    	
	$("#dialog").dialog({ 
	    autoOpen: false,
	    modal: true
	});
	
	$("#oldInitial").attr('readOnly',true);
	
	$(document.body).on('click','.removeSpecialAmountRow a',function(e) { 
		e.preventDefault(); 
		targetUrl = $(this).attr('href'); 
		$("#dialog").dialog({
		      buttons : {
		        "Remove" : function() { 
		            var request = $.ajax({
		                url: targetUrl,
		                type: "POST",
		            }).done(function(data) {    
                        table(); 	                
		          }).fail(function() {
		              alert("Error! Problem in removing special amount");
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
    
    /*$('#adjustedAmount').on('keyup',function() { 
    	var newAmount = $(this).val(); 
    });*/ 
    
    $('#allowanceSpecialAmountForm').submit(function(e) { 
        e.preventDefault();  
    }).validate({ 
    	rules: { 
    		employeeNumberAllowance_combobox: { required: true },
    		allowanceId_combobox: { required: true },
    		effectiveDate: { required: true }, 
    		oldAmount: { required: true }, 
    		newAmount: { required: true }
        }, 
        messages: { 
        	employeeNumberAllowance_combobox: "please select employee",
        	allowanceId_combobox: "please select allowance",
        	oldAmount: "please Enter oldwAmount",
        	effectiveDate: "please Enter effectiveDate",
       	    newAmount: "please Enter newAmount"
        }, 
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {};
            var formArray = $("#allowanceSpecialAmountForm").serializeArray(); 
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
                url: "/allowancespecialamount/saveemployeeSpecialAmount", 
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {                                  
            	clearAllowancespecialamountForm();  
                table(); 
                $.unblockUI(); 
            }).fail(function() { 
                alert("Error! Problem in saving initial for this employee");
            });              
            return false; 
        }
    }); 
    
    function clearAllowancespecialamountForm()
    { 
    	$('#employeeNumberAllowance').val("");
    	$('#employeeNumberAllowance_combobox').val(""); 
    	$('#allowanceId').val("");   	
    	$('#allowanceId_combobox').val(""); 
    	$('#oldAmount').val(""); 
    	$('#newAmount').val(""); 
     	$('#effectiveDate').val(""); 
       return 0;
    } 
    
    $('#employeeNumberAllowance,#allowanceId').combobox({ 
        select: function(event,ui) {
        	//alert("testtttttttttt");
        	var employeeNumber = $('#employeeNumberAllowance').val();
        	var allowanceId = $('#allowanceId').val();
        	if(employeeNumber && allowanceId) {
        		changeEmployeeAllowance(employeeNumber , allowanceId);
        	}
        } 
    }); 
    
    function changeEmployeeAllowance(employeeNumber , allowanceId) {
    	// $('#oldInitial').val(0); 
    	$.blockUI({ message: '<h4>Please Wait...loading Old Amount</h4>' });
    	var request = $.ajax({
            url: "/allowancespecialamount/getoldallowance", 
            type: "POST", 
            data: { 
            	empNumber : employeeNumber ,
            	allowId : allowanceId 
            }
        }).done(function(data) {                                
        	var obj = jQuery.parseJSON(data);              
        	 $('#oldAmount').val(obj.oldAmount);     
            $.unblockUI(); 
        }).fail(function() {
            alert("Error! Problem in loading old Initial for this employee"); 
        });              
        return true;
    }
    
     
    
    // loads table on page load  
    // table(); 
    
    function table() { 
        $("#employeeSpecialAmountContainer").zfTable('/allowancespecialamount/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#allowanceSpecialAmountForm').serialize();  
                return '&' + data;
            }, 
         }); 
    } 
    
}); 