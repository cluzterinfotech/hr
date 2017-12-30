$(document).ready(function()
{   
	$( "#suspendFromDate,#suspendToDate").datepicker({
        dateFormat: 'yy-mm-dd',
    	changeMonth: true,
    	changeYear: true,
    });    
	
	/*$("#terminationDate").validate({ 
    	rules: { 
    		terminationDate: { required: true } 
        },
        messages: {
        	terminationDate: "Please enter termination date"
        }
    });*/ 
	
	$("#dialog").dialog({
	    autoOpen: false,
	    modal: true
	}); 
	
	$(document.body).on('click','.removeRowSus a',function(e) { 
		e.preventDefault();
		targetUrl = $(this).attr('href'); 
		//console.log(targetUrl);
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
		              alert("Error! Problem in removing Suspend details for this employee");
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
    
    /*$('#employeeNumberTermination').combobox({ 
        select: function(event,ui) {
        	var employeeNumber = $(this).val();  
        	changeEmployeeTermination(employeeNumber);
        } 
    });  
    
    function changeEmployeeTermination(employeeNumber) {
    	$.blockUI({ message: '<h4>Please Wait...loading Old Salary Data</h4>' });
    	var request = $.ajax({
            url: "/employeeTermination/getoldsalarydetails",
            type: "POST",
            data: {
            	empNumber : employeeNumber
            }
        }).done(function(data) {                                
        	var obj = jQuery.parseJSON(data);              
            $('#oldSalary').val(obj.oldInitial);  
            $('#oldCola').val(obj.oldCola);     
            $.unblockUI(); 
        }).fail(function() {
            alert("Error! Problem in loading old salary details for this employee");
        });              
        return true;
    } */ 
    
    $('#adjustedAmount').on('keyup',function() { 
    	var newAmount = $(this).val();
    	/*var employeeNumber = $('#employeeNumberHousing').val(); 
    	if(employeeNumber) {
    	    changeAdvanceHousing(employeeNumber,noOfMonths);
    	}*/
    }); 
    
    $('#employeeSuspendForm').submit(function(e) { 
    	e.preventDefault(); 
    }).validate({  
    	rules: { 
    		employeeNumberSuspend_combobox: { required: true },
    		suspendFromDate: { required: true }, 
    		suspendToDate: { greaterThan: ['#suspendFromDate','#employeeNumberSuspend'] } 
        },    
        messages: { 
        	employeeNumberSuspend_combobox: "please select employee", 
        	suspendFromDate: "please enter to from date", 
        	suspendToDate: "please enter to date, and must be greater than from" 
        },    
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {}; 
            var formArray = $("#employeeSuspendForm").serializeArray(); 
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
                url: "/employeesuspend/saveemployeesuspend", 
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {                                  
            	clearEmployeeSuspendForm(); 
                table(); 
                $.unblockUI(); 
            }).fail(function() { 
                alert("Error! Problem in saving Suspend details for this employee"); 
            });              
            return false; 
        }
    }); 
    
    function clearEmployeeSuspendForm()
    { 
    	$('#employeeNumberSuspend').val("");
    	$('#employeeNumberSuspend_combobox').val(""); 
    	$('#suspendFromDate').val("");
    	$('#suspendToDate').val("");
        $('#suspendReason').val("");
        // $('#terminationNotes').val(""); 

        return 0;   
    } 
    
    // loads table on page load 
    // table(); 
    
    function table() {  
        $("#tableContainer").zfTable('/employeesuspend/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#employeeSuspendForm').serialize(); 
                return '&' + data;   
            }, 
         });   
    } 
    
}); 