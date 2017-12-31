$(document).ready(function()
{   
	$('#refundTo,#refundDate').datepicker({
        dateFormat: 'yy-mm-dd',
	    changeMonth: true,
	    changeYear: true,
    });  
	
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
		
	});
    
    $('#employeeIdPf').combobox({
        select: function(event,ui) {
        	var employeeNumber = $(this).val(); 
        	viewPfRefund(employeeNumber); 
        }  
    });   
    
    function viewPfRefund(employeeNumber) {
    	$.blockUI({ message: '<h4>Please Wait...loading PF Data</h4>' });
    	var request = $.ajax({
            url: "/pfrefund/getpflastrefund",
            type: "POST",
            data: {
            	empNumber : employeeNumber 
            }
        }).done(function(data) {                                
        	var obj = jQuery.parseJSON(data);  
        	$('#refundFrom').val(obj.refundFrom); 
        	$('#refundTo').val("");
        	$('#refundAmount').val("");
        	$('#pfDtls').html("");  
            $.unblockUI(); 
        }).fail(function() {
            alert("Error! Problem in loading Entitlement details for this employee");
        });              
        return true; 
    }   
    
    $('#refundTo').on('change',function() { 
    	$.blockUI({ message: '<h4>Please Wait...loading PF Data</h4>' });
    	var employeeNumber = $('#employeeIdPf').val();
    	var refundFromDate = $('#refundFrom').val(); 
    	var refundToDate = $(this).val(); 
    	var request = $.ajax({
            url: "/pfrefund/getpfdtls",
            type: "POST",
            data: {
            	empNumber : employeeNumber,
            	refFrom :refundFromDate,
            	refTo : refundToDate
            }
        }).done(function(data) {                                
        	var obj = jQuery.parseJSON(data);  
        	$('#refundAmount').val(obj.refundAmount); 
        	$('#pfDtls').html(obj.dtls);  
            $.unblockUI(); 
        }).fail(function() {
            alert("Error! Problem in loading Entitlement details for this employee");
        });              
        return true; 
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