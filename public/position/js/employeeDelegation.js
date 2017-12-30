$(document).ready(function() 
{   	 
	$( "#delegatedFrom,#delegatedTo").datepicker({
        dateFormat: 'yy-mm-dd',
    	changeMonth: true,
    	changeYear: true,
    });  
	
	$(document.body).on('click','.removeDelegation a',function(e) { 
		e.preventDefault();
		targetUrl = $(this).attr('href'); 
		$("#dialog").dialog({
		      buttons : {
		        "Remove" : function() { 
		            var request = $.ajax({
		                url: targetUrl,
		                type: "POST",
		            }).done(function(data) {    
                        //console.log("success"); 
                        table();
		          }).fail(function() {
		              alert("Error! Problem in removing Delegation for this employee");
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
	
    $('#delegationForm').submit(function(e) { 
    	e.preventDefault(); 
    }).validate({ 
    	rules: { 
    		employeeId_combobox: { required: true },
    		delegatedEmployeeId_combobox: { required: true },
    		delegatedFrom: { required: true },
    		delegatedTo: { required: true },
        }, 
        messages: { 
        	employeeId_combobox: "please select employee",
    		delegatedEmployeeId_combobox: "please select Delegated Employee",
    		delegatedFrom: "Please enter Delegated from date",
    		delegatedTo: "please enter Delegated to date" 
        },   
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {};
            var formArray = $("#delegationForm").serializeArray(); 
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
                url: "/delegation/savedelegation", 
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {      
            	if(data == 0) {
            	    alert("Sorry! Employee already have delegation"); 	
            	} 
            	clearDelegationForm();   
                table();  
                $.unblockUI();  
            }).fail(function() { 
                alert("Error! Problem in saving delegation for this employee"); 
            });              
            return false; 
        } 
    }); 
    
    function clearDelegationForm()
    { 
    	$('#employeeId').val("");
    	$('#employeeId_combobox').val(""); 
    	$('#delegatedEmployeeId').val("");
    	$('#delegatedEmployeeId_combobox').val("");
    	$('#delegatedFrom').val("");
    	$('#delegatedTo').val(""); 
        return 0;
    }
    
    function table() {
        $("#employeeDelegationContainer").zfTable('/delegation/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#delegationForm').serialize();  
                return '&' + data;
            },
         }); 
    }
    
}); 