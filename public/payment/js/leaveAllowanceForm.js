$(document).ready(function()
{   
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
		              alert("Error! Problem in removing leave allowance list for this employee");
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
    
    /*function changeAdvanceHousing(employeeNumber,noOfMonths) {
    	$.blockUI({ message: '<h4>Please Wait...loading Housing Data</h4>' });
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
    } 
    
    $('#numberOfMonthsHousing').on('keyup',function() { 
    	var noOfMonths = $(this).val();
    	var employeeNumber = $('#employeeNumberHousing').val(); 
    	if(employeeNumber) {
    	    changeAdvanceHousing(employeeNumber,noOfMonths);
    	}
    });*/  
    
    $('#selectEmployeeLeaveAllowanceForm').submit(function(e) { 
    	e.preventDefault(); 
    }).validate({ 
    	rules: { 
    		employeeNumberLeaveAllowance_combobox: { required: true },
        }, 
        messages: { 
        	employeeNumberLeaveAllowance_combobox: "please select employee"
        }, 
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {};
            var formArray = $("#selectEmployeeLeaveAllowanceForm").serializeArray(); 
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
                url: "/leaveallowance/saveemployeetolist", 
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {                                  
            	clearLeaveAllowanceForm(); 
                table(); 
                $.unblockUI(); 
            }).fail(function() { 
                alert("Error! Problem in loading saving employee to list");
            });              
            return false; 
        }
    }); 
    
    function clearLeaveAllowanceForm()
    { 
    	$('#employeeNumberLeaveAllowance').val("");
    	$('#employeeNumberLeaveAllowance_combobox').val(""); 
        return 0;
    }
    // loads table on page load 
    // table();
    
    function table(){
        $("#tableContainer").zfTable('/leaveallowance/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#selectEmployeeLeaveAllowanceForm').serialize(); 
                return '&' + data;
            },
         }); 
    }
    
}); 