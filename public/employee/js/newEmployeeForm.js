$(document).ready(function()
{   
	$('#effectiveDate,#appliedDate,#empJoinDate').datepicker({
        dateFormat: 'yy-mm-dd',
	    changeMonth: true,
	    changeYear: true,
    }); 
	
	$('#empDateOfBirth').datepicker({
        dateFormat: 'yy-mm-dd',
	    changeMonth: true,
	    changeYear: true, 
	    firstDay:1, 
	    yearRange : "-70:-17",
    });
	
	$('#empJoinDate').datepicker({
        dateFormat: 'yy-mm-dd',
	    changeMonth: true,
	    changeYear: true, 
	    firstDay:1, 
	    yearRange : "1:1",
    });
	
	$("#dialog").dialog({
	    autoOpen: false,
	    modal: true
	}); 
	
	$(document.body).on('click','.removeEmployeeBufferRow a',function(e) { 
		//alert("");
		e.preventDefault(); 
		targetUrl = $(this).attr('href'); 
		// console.log(targetUrl); 
		$("#dialog").dialog({
		      buttons : {
		        "Remove" : function() { 
		            var request = $.ajax({
		                url: targetUrl,
		                type: "POST",
		            }).done(function(data) {    
		            	tableNewEmployee();   	                
		          }).fail(function() {
		              alert("Error! Problem in removing New employee inforamtion");
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
    
    $("#newEmployeeForm").validate({
    	rules: { 
    		gender_combobox: { required: true },
    		maritalStatus_combobox: { required: true },
    		religion_combobox: { required: true },
    		nationality_combobox: { required: true },
    		state_combobox: { required: true },
    		empType_combobox: { required: true },
    		empSalaryGrade_combobox: { required: true },
    		empJobGrade_combobox: { required: true },
    		empBank_combobox: { required: true },
    		empPosition_combobox: { required: true },
    		isPreviousContractor_combobox: { required: true },
    		empLocation_combobox: { required: true },
    		skillGroup_combobox: { required: true },
    		empEmail : { required: true, email: true },
    		accountNumber : { required: true},
    		referenceNumber: { required: true},
    		empDateOfBirth: { dobRange: ['#empDateOfBirth'] } ,
    		empJoinDate: { dojRange: ['#empJoinDate'] } 
        }, messages: {  
        	gender_combobox: "please select gender",
        	maritalStatus_combobox: "please select marital status",
        	religion_combobox: "please select religion",
        	nationality_combobox: "please select nationality",
        	state_combobox: "please select state",
        	empType_combobox: "please select employee type",
        	empSalaryGrade_combobox: "please select employee salary grade",
        	empJobGrade_combobox: "please select employee job grade",
        	empBank_combobox: "please select employee bank",
        	empPosition_combobox: "please select employee position",
        	isPreviousContractor_combobox: "please select Contractor Status",
        	empLocation_combobox: "please select employee location",
        	skillGroup_combobox: "please select skill group",
        	empEmail :  "please enter a valid email",  
        	accountNumber :  "please enter a valid account number",  
        	referenceNumber:  "please enter a valid refernce number",
        	empJoinDate:"please enter a valid Join Date",
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
    
    function table() { 
        $("#employeeConfirmationContainer").zfTable('/employeeconfirmation/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#employeeConfirmationForm').serialize(); 
                return '&' + data;
            },
         }); 
    } 
    
    function tableNewEmployee() { 
        $("#tableContainer").zfTable('/newemployee/ajaxlistnew', {
            sendAdditionalParams: function() {
                var data = $('#newemployee').serialize(); 
                return '&' + data;
            },
         }); 
    } 
    
}); 