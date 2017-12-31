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
		              alert("Error! Problem in removing confirmation details for this employee");
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
    
    $('#employeeNumberConfirmation').combobox({ 
        select: function(event,ui) {
        	var employeeNumber = $(this).val();  
        	changeEmployeeConfirmation(employeeNumber);
        } 
    });  
    
    function changeEmployeeConfirmation(employeeNumber) {
    	$.blockUI({ message: '<h4>Please Wait...loading Old Salary Data</h4>' });
    	var request = $.ajax({
            url: "/employeeconfirmation/getoldsalarydetails",
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
    } 
    
    $('#adjustedAmount').on('keyup',function() { 
    	var newAmount = $(this).val();
    	/*var employeeNumber = $('#employeeNumberHousing').val(); 
    	if(employeeNumber) {
    	    changeAdvanceHousing(employeeNumber,noOfMonths);
    	}*/
    }); 
    
    $('#employeeConfirmationForm').submit(function(e) { 
    	e.preventDefault(); 
    }).validate({ 
    	rules: { 
    		employeeNumberConfirmation_combobox: { required: true },
    		effectiveDate: { required: true },
    		adjustedAmount: { required: true }
        }, 
        messages: { 
        	employeeNumberConfirmation_combobox: "please select employee",
        	effectiveDate: "please enter the effective date",
        	adjustedAmount: "please enter the new Initial"
        }, 
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {};
            var formArray = $("#employeeConfirmationForm").serializeArray(); 
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
                url: "/employeeconfirmation/saveemployeeconfirmation", 
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {                                  
            	clearEmployeeConfirmationForm(); 
                table(); 
                $.unblockUI(); 
            }).fail(function() { 
                alert("Error! Problem in saving Confirmation details for this employee");
            });              
            return false; 
        }
    });
    
    function clearEmployeeConfirmationForm()
    { 
    	$('#employeeNumberConfirmation').val("");
    	$('#employeeNumberConfirmation_combobox').val(""); 
    	$('#effectiveDate').val(""); 
        $('#appliedDate').val("");
        $('#oldSalary').val(""); 
        $('#oldCola').val("");
        $('#adjustedAmount').val(""); 
        $('#percentage').val(""); 
        $('#confirmationNotes').val(""); 
        return 0;
    } 
    
    // loads table on page load 
    // table();
    
    function table() { 
        $("#employeeConfirmationContainer").zfTable('/employeeconfirmation/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#employeeConfirmationForm').serialize(); 
                return '&' + data;
            },
         }); 
    } 
    
    $('#adjustedAmount').on('change',function(e) { 
        var oldInitial =  $('#oldSalary').val(); 
        var newAmount = $('#adjustedAmount').val(); 
        var newPercentage = (newAmount*1) / (oldInitial*1);
        var percentage  = Math.round(100 * newPercentage) / 100; 
        $('#percentage').val(percentage);    
    }); 
    
    $('#percentage').on('change',function(e) { 
        var oldInitial =  $('#oldSalary').val();
        var newPercentage = $('#percentage').val();
        //newPercentage = 1 + ( Math.round(100 * newPercentage) / 100);
        var newValue = (oldInitial*1) * (newPercentage*1);
        var percentage  = Math.round(100 * newPercentage) / 100;
        var newInitial = Math.round(100 * newValue) / 100;
        //newValue = Math.round(100 * newValue) / 100;
        $('#adjustedAmount').val(newInitial);  
        //$('#percentage').val(percentage);    
    });  
    
}); 