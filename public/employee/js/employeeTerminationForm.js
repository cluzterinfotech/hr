$(document).ready(function()
{   
	$( "#terminationDate").datepicker({
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
	 
	$(document.body).on('click','.removeRowTerm a',function(e) { 
		e.preventDefault();
		// alert(" ");
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
		              alert("Error! Problem in removing Termination details for this employee");
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
    
    $('#employeeTerminationForm').submit(function(e) { 
    	e.preventDefault(); 
    }).validate({ 
    	rules: { 
    		employeeNumberTermination_combobox: { required: true },
    		terminationType_combobox: { required: true },
    		terminationDate: { required: true }
        },  
        messages: { 
        	employeeNumberTermination_combobox: "please select employee",
        	terminationType_combobox: "please select type",
        	terminationDate: "please enter the new Initial"
        },  
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {}; 
            var formArray = $("#employeeTerminationForm").serializeArray(); 
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
                url: "/employeetermination/saveemployeetermination", 
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {                                  
            	clearEmployeeTerminationForm(); 
                table(); 
                $.unblockUI(); 
            }).fail(function() { 
                alert("Error! Problem in saving Termination details for this employee");
            });              
            return false; 
        }
    }); 
    
    function clearEmployeeTerminationForm()
    { 
    	$('#employeeNumberTermination').val("");
    	$('#employeeNumberTermination_combobox').val(""); 
    	// $('#terminationType').val(""); 
    	$('#terminationType').val("");
    	$('#terminationType_combobox').val("");
        $('#terminationDate').val("");
        $('#terminationNotes').val(""); 
        //$('#oldCola').val("");
        //$('#adjustedAmount').val(""); 
        //$('#percentage').val(""); 
        //$('#terminationNotes').val(""); 
        return 0;   
    } 
    
    // loads table on page load 
    // table(); 
    
    function table() {  
        $("#tableContainerT").zfTable('/employeetermination/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#employeeTerminationForm').serialize(); 
                return '&' + data;   
            }, 
         });  
    } 
    
}); 