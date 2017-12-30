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
	
	$(document.body).on('click','.removeSgAllowanceRow a',function(e) { 
		e.preventDefault();
		//console.log("sg allowance working");
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
		              alert("Error! Problem in removing salary grade allowance"); 
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
    
    $('#salaryGradeAllowanceForm').submit(function(e) { 
    	e.preventDefault(); 
    	// console.log("sg form submit working"); 
    }).validate({ 
    	rules: { 
    		salaryGrade_combobox: { required: true },
    		sgAllowanceName_combobox: { required: true },
    		isApplicableToAll_combobox: { required: true }, 
    		sgAmount: { required: true }
        }, 
        messages: { 
        	salaryGrade_combobox: "please select salary grade",
        	sgAllowanceName_combobox: "please select allowance",
        	isApplicableToAll_combobox: "please select applicable status",
        	sgAmount: "Please enter amount",
        }, 
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {};
            var formArray = $("#salaryGradeAllowanceForm").serializeArray(); 
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
                url: "/salarygradeallowance/savesgallowance", 
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {                                  
            	clearSalaryGradeAllowanceForm(); 
                table(); 
                $.unblockUI(); 
            }).fail(function() { 
                alert("Error! Problem in saving this salary grade allowance"); 
            });              
            return false; 
        }
    }); 
     
    function clearSalaryGradeAllowanceForm()
    { 
    	$('#lkpSalaryGradeId').val(""); 
    	$('#lkpSalaryGradeId_combobox').val("");  
    	$('#allowanceId').val("");
    	$('#allowanceId_combobox').val(""); 
    	$('#isApplicableToAll').val("");
    	$('#isApplicableToAll_combobox').val(""); 
    	$('#amount').val("");  
        return 0; 
    } 
    
    // loads table on page load 
    // table();
    
    function table() { 
        $("#sgAllowanceContainer").zfTable('/salarygradeallowance/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#salaryGradeAllowanceForm').serialize();  
                return '&' + data;
            }, 
         });  
    }  
    
    /*$('#employeeNumberConfirmation').combobox({ 
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
		//var employeeNumber = $('#employeeNumberHousing').val(); 
		//if(employeeNumber) {
		    //changeAdvanceHousing(employeeNumber,noOfMonths);
		//}
	});*/
    
}); 