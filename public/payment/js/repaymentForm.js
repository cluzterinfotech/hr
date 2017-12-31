$(document).ready(function()
{   
	$('#advanceHousingFromDate').datepicker({
        dateFormat: 'yy-mm-dd',
	    changeMonth: true,
	    changeYear: true,
    }); 
	
	$("#dialog").dialog({
	    autoOpen: false,
	    modal: true
	});
	
	$(document.body).on('click','.removeRepayment a',function(e) { 
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
		              alert("Error! Problem in removing Repayment Details");
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
    
    $('#employeeIdRepayment,#advanceType').combobox({
        select: function(event,ui) { 
        	var employeeNumber = $('#employeeIdRepayment').val(); 
        	var advanceType = $('#advanceType').val(); 
        	if((employeeNumber !== '') && (advanceType !== '')) {
        		clearValues();
        		changeRepayment(employeeNumber,advanceType);
        	} 
        } 
    }); 
    
    function clearValues() {
    	$('#monthsPending').val("");  
        $('#amountPending').val("");  
        $('#monthlyDue').val("");
        $('#amountPaying').val(""); 
        $('#monthsPaying').val(""); 
        $('#notes').val("");  
    }
    
    function changeRepayment(employeeNumber,advanceType) {
    	// console.log("fetching detail here"); 
    	$.blockUI({ message: '<h4>Please Wait...loading Repayment Data</h4>' });
    	var request = $.ajax({
            url: "/repaymentadvance/getrepayment", 
            type: "POST",
            data: {
            	empNumber : employeeNumber, 
            	advType : advanceType
            }
        }).done(function(data) {                                
        	var obj = jQuery.parseJSON(data);              
            $('#monthsPending').val(obj.pendingMonths);  
            $('#amountPending').val(obj.totalAmount);  
            $('#monthlyDue').val(obj.dueAmount);     
            $.unblockUI(); 
        }).fail(function() {
            alert("Error! Problem in loading repayment details for this employee");
        });              
        return true;
    } 
    
    $('#monthsPaying').on('keyup',function() { 
    	var noOfMonths = $(this).val();
    	var monthlyDue = $('#monthlyDue').val(); 
    	var amt = (noOfMonths * 1) * (monthlyDue * 1);
    	$('#amountPaying').val(amt); 
    });
    
    $('#advanceRepaymentForm').submit(function(e) { 
    	e.preventDefault(); 
    }).validate({ 
    	rules: { 
    		employeeIdRepayment_combobox: { required: true },
    		advanceType_combobox: { required: true },
    		monthsPending: { required: true },
    		monthlyDue: { required: true },
    		monthsPaying: { required: true },
    		amountPending: { required: true },
    		amountPaying: { required: true } 
        }, 
        messages: { 
        	employeeIdRepayment_combobox: "please select employee",
        	advanceType_combobox: "please select Advance Type"
        	//numberOfMonthsHousing: "please enter number of months",
        	//advanceHousingFromDate: "please select advance housing starting date"
        }, 
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {};
            var formArray = $("#advanceRepaymentForm").serializeArray(); 
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
                url: "/repaymentadvance/saverepayment", 
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {                                  
            	clearValues();
                table(); 
                $.unblockUI(); 
            }).fail(function() { 
                alert("Error! Problem in saving details");
            });              
            return false; 
        }
    }); 
    
    /*function clearAdvanceHousingForm()
    { 
    	$('#employeeNumberHousing').val("");
    	$('#employeeNumberHousing_combobox').val(""); 
    	$('#advanceHousingFromDate').val(""); 
        $('#numberOfMonthsHousing').val("");
        $('#housingAmount').val(""); 
        $('#housingTax').val("");
        $('#housingNetAmount').val(""); 
        return 0;
    }*/
    // loads table on page load 
    // table();
    function table(){
        $("#advanceRepaymentContainer").zfTable('/repaymentadvance/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#advanceRepaymentContainer').serialize(); 
                return '&' + data;
            },
         }); 
    } 
}); 