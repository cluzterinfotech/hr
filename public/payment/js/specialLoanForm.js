$(document).ready(function()
{   
	$('#loanDate').datepicker({
        dateFormat: 'yy-mm-dd',
	    changeMonth: true,
	    changeYear: true,
    }); 
	
	$("#dialog").dialog({
	    autoOpen: false,
	    modal: true
	}); 
	
	$('#monthlyDue').attr('readonly', 'true'); 
	//$('#loanAmount').attr('readonly', 'true'); 
	
	$(document.body).on('click','.removeSpecialLoan a',function(e) { 
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
		              alert("Error! Problem in removing Special Loan for this employee");
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
    
	/*$('#employeeNumberSpecialLoan').combobox({
        select: function(event,ui) {
        	var employeeNumber = $(this).val();  
        	getLoanAmount(employeeNumber); 
        }  
    });*/   
    
    /*function getLoanAmount(employeeNumber) {
    	$.blockUI({ message: '<h4>Please Wait...loading Loan Data</h4>' });
    	var request = $.ajax({
            url: "/personalloan/getpersonalloanamount",
            type: "POST",
            data: {
            	empNumber : employeeNumber
            }
        }).done(function(data) {                                
        	var obj = jQuery.parseJSON(data);     
        	var amt = obj.employeeLoanAmount
        	var months = $('#numberOfMonthsLoanAmt').val();
        	var tot = (amt * 1) * (months * 1);
        	$('#basic').val(amt); 
            $('#loanAmount').val(tot);  
            $('#numberOfMonthsLoanDue').val('36');
            var noOfMonths = 36;
        	var loanAmount = $('#loanAmount').val();
        	var monthlyDue = Math.round((loanAmount/noOfMonths) * 100) / 100; 
        	$('#monthlyDue').val(monthlyDue); 
            $.unblockUI(); 
        }).fail(function() {
            alert("Error! Problem in loading Loan Amount for this employee");
        });              
        return true;
    }*/ 
    
    $('#numberOfMonthsSplLoanDue,#splLoanAmount').on('keyup',function() { 
    	//var noOfMonths = $(this).val();
    	//var loanAmount = $('#basic').val();
    	var amt = $('#splLoanAmount').val();
    	var months = $('#numberOfMonthsSplLoanDue').val();
    	//var tot = (amt * 1) * (months * 1);
        //$('#loanAmount').val(tot);  
        //$('#numberOfMonthsLoanDue').val('36');
        //var noOfMonths = 36;
    	//var loanAmount = $('#loanAmount').val();
    	var monthlyDue = Math.round((amt/months) * 100) / 100; 
    	$('#monthlyDue').val(monthlyDue);  
    }); 
    
    /*$('#monthlyDue').on('keyup',function() { 
    	var noOfMonths = $(this).val();
    }); 
    
    $('#loanAmount').on('keyup',function() { 
    	var noOfMonths = $(this).val(); 
    });*/ 
    
    
    
    $('#specialLoanForm').submit(function(e) { 
    	e.preventDefault(); 
    }).validate({ 
    	rules: { 
    		employeeNumberSpecialLoan_combobox : { required: true },
            loanDate : { required: true },
            splLoanAmount : { required: true },
            numberOfMonthsSplLoanDue : { required: true },
            monthlyDue : { required: true }
        }, 
        messages: { 
        	employeeNumberSpecialLoan_combobox : "please select employee",
            loanDate : "please enter loan date",
            splLoanAmount : "please enter loan amount",
            numberOfMonthsSplLoanDue : "please enter number of months due",
            monthlyDue : "please enter due amount" 
        }, 
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {};
            var formArray = $("#specialLoanForm").serializeArray();  
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
                url: "/specialloan/savespecialloan", 
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {                                  
            	clearSpecialLoanForm(); 
                table(); 
                $.unblockUI(); 
            }).fail(function() { 
                alert("Error! Problem in saving Loan details for this employee");
            });              
            return false; 
        }
    }); 
    
    function clearSpecialLoanForm()
    { 
    	$('#employeeNumberSpecialLoan').val("");
    	$('#employeeNumberSpecialLoan_combobox').val(""); 
        $('#loanDate').val("");
        $('#splLoanAmount').val(""); 
        $('#numberOfMonthsSplLoanDue').val("");
        $('#monthlyDue').val(""); 
        return 0; 
    } 
    
    // loads table on page load 
    // table(); 
    
    function table(){
        $("#specialLoanContainer").zfTable('/specialloan/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#specialLoanContainer').serialize();  
                return '&' + data; 
            },
         }); 
    }
    
}); 