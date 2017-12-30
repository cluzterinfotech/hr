$(document).ready(function()
{   
	/*$('#relievingDate').datepicker({
        dateFormat: 'yy-mm-dd',
	    changeMonth: true,
	    changeYear: true,
    });*/   
	
	$("#dialog").dialog({
	    autoOpen: false,
	    modal: true
	});
	
	$(document.body).on('click','.removeAdvanceHousing a',function(e) { 
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
		              alert("Error! Problem in removing Advance Housing for this employee");
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
		/*$.blockUI({ message: '<h4>Please Wait...loading Housing Data</h4>' });
    	var request = $.ajax({
            url: "/advancehousing/getadvancehousingdetails",
            type: "POST",
            data: {
            	empNumber : employeeNumber, 
            	noOfMonth : noOfMonths
            }
        }).done(function(data) {                                
        	var obj = jQuery.parseJSON(data);              
            $('#housingAmount').val(obj.amount);  
            $('#housingTax').val(obj.tax); 
            $('#housingNetAmount').val(obj.net);     
            $.unblockUI(); 
        }).fail(function() {
            alert("Error! Problem in loading Housing details for this employee");
        });              
        return true;
		//console.log("remover working");
		*/
	});
    
    $('#employeeNumberFinalEntitlement').combobox({
        select: function(event,ui) {
        	var employeeNumber = $(this).val(); 
        	viewEntitlement(employeeNumber); 
        }  
    });  
    
    function viewEntitlement(employeeNumber) {
    	$.blockUI({ message: '<h4>Please Wait...loading Entitlement Data</h4>' });
    	var request = $.ajax({
            url: "/finalentitlement/getentitlementdetails",
            type: "POST",
            data: {
            	empNumber : employeeNumber 
            }
        }).done(function(data) {                                
        	var obj = jQuery.parseJSON(data);  
        	
        	$('#employmentDate').val(obj.employmentDate); 
        	$('#relievingDate').val(obj.relievingDate); 
        	$('#yearsOfService').val(obj.yearsOfService); 
        	$('#nonPayDays').val(obj.nonPayDays);  
        	$('#zeroToTenAmount').val(obj.zeroToTenAmount);
        	$('#zeroToTenAmount').val(obj.zeroToTenAmount); 
        	$('#tenToFifteenAmount').val(obj.tenToFifteenAmount); 
        	$('#fifteenToTwentyAmount').val(obj.fifteenToTwentyAmount); 
        	$('#twentyToTwentyFiveAmount').val(obj.twentyToTwentyFiveAmount); 
        	$('#twentyFiveandAboveAmount').val(obj.twentyFiveandAboveAmount); 
        	$('#afterServiceBenefitTotal').val(obj.afterServiceBenefitTotal); 
        	$('#balanceLeaveDays').val(obj.balanceLeaveDays); 
        	$('#leaveDaysAmount').val(obj.leaveDaysAmount); 
        	$('#leaveDaysToCompany').val(obj.leaveDaysToCompany); 
        	$('#leaveAllowanceToEmployee').val(obj.leaveAllowanceToEmployee); 
        	$('#leaveAllowanceFromEmployee').val(obj.leaveAllowanceFromEmployee); 
        	$('#personalLoanPending').val(obj.personalLoanPending); 
        	$('#AdvanceSalaryPending').val(obj.AdvanceSalaryPending); 
        	$('#advanceHousingPending').val(obj.advanceHousingPending); 
        	$('#lastMonthDueToCompany').val(obj.lastMonthDueToCompany); 
        	$('#lastMonthDueFormCompany').val(obj.lastMonthDueFormCompany); 
        	$('#carLoanToCompany').val(obj.carLoanToCompany); 
        	$('#splLoanToCompany').val(obj.splLoanToCompany); 
        	$('#phoneToCompany').val(obj.phoneToCompany); 
        	$('#overPaymentToCompany').val(obj.overPaymentToCompany);  
            
        	// console.log(obj.splLoanToCompany); 
        	$('#totalAllowance').val(obj.totalAllowance); 
        	$('#totalDeduction').val(obj.totalDeduction); 
        	$('#finalAmount').val(obj.finalAmount); 
        	
        	//$('#specialCompensation').val(obj.specialCompensation); 
        	//$('#specialCompensationToCompany').val(obj.specialCompensationToCompany); 
        	$('#salaryDifference').val(obj.salaryDifference); 
        	$('#salaryDifferenceToCompany').val(obj.salaryDifferenceToCompany); 
        	$('#carRent').val(obj.carRent); 
        	$('#carRentToCompany').val(obj.carRentToCompany);   
            
        	$('#feDtls').html(obj.dtls);  
        	
            $.unblockUI(); 
        }).fail(function() {
            alert("Error! Problem in loading Entitlement details for this employee");
        });              
        return true;
    } 
    
    $('#numberOfMonthsHousing').on('keyup',function() { 
    	var noOfMonths = $(this).val();
    	var employeeNumber = $('#employeeNumberHousing').val(); 
    	if(employeeNumber) {
    	    changeAdvanceHousing(employeeNumber,noOfMonths);
    	}
    }); 
    
    $('#advanceHousingForm').submit(function(e) { 
    	e.preventDefault(); 
    }).validate({ 
    	rules: { 
    		employeeNumberHousing_combobox: { required: true },
    		numberOfMonthsHousing: { required: true },
    		advanceHousingFromDate: { required: true }
        }, 
        messages: { 
        	employeeNumberHousing_combobox: "please select employee",
        	numberOfMonthsHousing: "please enter number of months required in advance",
        	advanceHousingFromDate: "please select advance housing starting date"
        }, 
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {};
            var formArray = $("#advanceHousingForm").serializeArray(); 
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
                url: "/advancehousing/saveadvancehousing", 
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {                                  
            	clearAdvanceHousingForm(); 
                table(); 
                $.unblockUI(); 
            }).fail(function() { 
                alert("Error! Problem in loading promotion details for this employee");
            });              
            return false; 
        }
    }); 
    
    function clearAdvanceHousingForm()
    { 
    	$('#employeeNumberHousing').val("");
    	$('#employeeNumberHousing_combobox').val(""); 
    	$('#advanceHousingFromDate').val(""); 
        $('#numberOfMonthsHousing').val("");
        $('#housingAmount').val(""); 
        $('#housingTax').val("");
        $('#housingNetAmount').val(""); 
        return 0;
    }
    // loads table on page load 
    // table();
    
    function table(){
        $("#advanceHousingContainer").zfTable('/advancehousing/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#advanceHousingForm').serialize(); 
                return '&' + data;
            },
         }); 
    }
    
}); 