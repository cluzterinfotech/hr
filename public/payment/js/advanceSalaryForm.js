$(document).ready(function()
{   
	$('#advancePaidDate').datepicker({
        dateFormat: 'yy-mm-dd',
	    changeMonth: true,
	    changeYear: true,
    }); 
	
	$('#netPay').attr('readonly', 'true');
	$('#numberOfMonthsDue').attr('readonly', 'true'); 
	
	$("#dialog").dialog({
	    autoOpen: false,
	    modal: true
	});
	
	$(document.body).on('click','.removeAdvanceSalary a',function(e) { 
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
		              alert("Error! Problem in removing Advance Salary for this employee");
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
    
    $('#employeeNumberAdvSalary').combobox({
        select: function(event,ui) {
        	var employeeNumber = $(this).val();
        	var noOfMonths = $('#numberOfMonthsHousing').val(); 
        	getNetAmount(employeeNumber);
        } 
    });
    
    function getNetAmount(employeeNumber) {
    	$.blockUI({ message: '<h4>Please Wait...loading Housing Data</h4>' });
    	var request = $.ajax({
            url: "/advancesalary/getadvancesalarydetails",
            type: "POST",
            data: {
            	empNumber : employeeNumber
            }
        }).done(function(data) {                                
        	var obj = jQuery.parseJSON(data);              
            $('#netPay').val(obj.employeeNetAmount);       
            $.unblockUI(); 
        }).fail(function() {
            alert("Error! Problem in loading Net Amount for this employee");
        });              
        return true;
    } 
    
    $('#numberOfMonthsNetPay').on('keyup',function() { 
    	var noOfMonths = $(this).val();
    	var employeeNumber = $('#employeeNumberAdvSalary').val(); 
    	if(employeeNumber) {
    	    changeAdvanceSalary(employeeNumber,noOfMonths);
    	}
    }); 
    
    function changeAdvanceSalary(employeeNumber,noOfMonths) { 
    	if(noOfMonths > 2) {
    	    alert("you cant provide more than two months"); 
    	    $('#numberOfMonthsDue').val(""); 
    	    $('#advanceAmount').val("");   
            $('#monthlyDue').val(""); 
    	} else { 
    		var netAmt = $('#netPay').val();  
    		var noOfNetPay = $('#numberOfMonthsNetPay').val();  
    		var advAmt = noOfNetPay * netAmt;  
    		var noOfMonths = noOfNetPay * 2;  
    		var monthDue = advAmt/noOfMonths; 
    		$('#numberOfMonthsDue').val(noOfMonths); 
    	    $('#advanceAmount').val(advAmt);   
            $('#monthlyDue').val(monthDue);   
    	} 
    } 
    
    $('#advanceSalaryForm').submit(function(e) {  
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
            var formArray = $("#advanceSalaryForm").serializeArray(); 
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
                url: "/advancesalary/saveadvancesalary",  
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {                                  
            	clearAdvanceSalaryForm(); 
                table(); 
                $.unblockUI(); 
            }).fail(function() { 
                alert("Error! Problem in saving advance salary for this employee");
            });              
            return false; 
        }
    });  
    
    function clearAdvanceSalaryForm()
    { 
    	$('#employeeNumberAdvSalary').val("");
    	$('#employeeNumberAdvSalary_combobox').val(""); 
    	$('#advancePaidDate').val(""); 
        $('#netPay').val("");
        $('#numberOfMonthsNetPay').val(""); 
        $('#advanceAmount').val("");
        $('#numberOfMonthsDue').val(""); 
        $('#monthlyDue').val("");  
        return 0; 
    } 
    
    function table(){
        $("#advanceSalaryContainer").zfTable('/advancesalary/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#advanceSalaryForm').serialize();  
                return '&' + data; 
            },
         });  
    } 
    
}); 