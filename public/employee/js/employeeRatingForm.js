$(document).ready(function()
{   
	/*$('#effectiveDate,#appliedDate').datepicker({
        dateFormat: 'yy-mm-dd',
	    changeMonth: true,
	    changeYear: true,
    });*/  
	
	$("#dialog").dialog({
	    autoOpen: false,
	    modal: true
	});
	
	$(document.body).on('click','.removeRow a',function(e) { 
		e.preventDefault();
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
		              alert("Error! Problem in removing phone deduction details for this employee");
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
    
    /*$('#employeeNumberConfirmation').combobox({ 
        select: function(event,ui) {
        	var employeeNumber = $(this).val();  
        	changeEmployeeConfirmation(employeeNumber);
        } 
    });*/  
    
    
    
    /*$('#adjustedAmount').on('keyup',function() { 
    	var newAmount = $(this).val(); 
    });*/ 
    
    $('#employeeTelephoneForm').submit(function(e) { 
    	e.preventDefault(); 
    }).validate({ 
    	rules: { 
    		employeeNumberTelephone_combobox: { required: true },
    		phoneAmount: { required: true }
        }, 
        messages: { 
        	employeeNumberTelephone_combobox: "please select employee",
        	phoneAmount: "please enter the Phone Deduction Amount"
        }, 
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {};
            var formArray = $("#employeeTelephoneForm").serializeArray(); 
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
                url: "/telephone/saveemployeetelephone", 
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {                                  
            	clearEmployeeTelephoneForm(); 
                table(); 
                $.unblockUI(); 
            }).fail(function() { 
                alert("Error! Problem in saving telephone details for this employee");
            });              
            return false; 
        }
    });
    
    function clearEmployeeTelephoneForm()
    { 
    	$('#employeeNumberTelephone').val("");
    	$('#employeeNumberTelephone_combobox').val(""); 
    	$('#phoneAmount').val(""); 
        return 0;
    } 
    
    // loads table on page load 
    // table();
    
    function table() { 
        $("#employeeTelephoneContainer").zfTable('/telephone/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#employeeTelephoneForm').serialize(); 
                return '&' + data;
            }, 
         }); 
    } 
    
}); 