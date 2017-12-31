$(document).ready(function()
{   
    	
	$("#dialog").dialog({ 
	    autoOpen: false,
	    modal: true
	});
	
	$("#oldInitial").attr('readOnly',true);
	
	$(document.body).on('click','.removeEmployeeInitialRow a',function(e) { 
		e.preventDefault(); 
		targetUrl = $(this).attr('href'); 
		$("#dialog").dialog({
		      buttons : {
		        "Remove" : function() { 
		            var request = $.ajax({
		                url: targetUrl,
		                type: "POST",
		            }).done(function(data) {    
                        table(); 	                
		          }).fail(function() {
		              alert("Error! Problem in removing New Initial for this employee");
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
    
    /*$('#adjustedAmount').on('keyup',function() { 
    	var newAmount = $(this).val(); 
    });*/ 
    
    $('#updateInitialForm').submit(function(e) { 
        e.preventDefault();  
    }).validate({ 
    	rules: { 
        	employeeNumberInitial_combobox: { required: true },
        	oldInitial: { required: true }, 
        	newInitial: { required: true }
        }, 
        messages: { 
        	employeeNumberInitial_combobox: "please select employee",
        	oldInitial: "please select employee",
        	newInitial: "please enter new initial amount"
        }, 
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {};
            var formArray = $("#updateInitialForm").serializeArray(); 
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
                url: "/employeeinitial/saveemployeeinitial", 
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {                                  
            	clearEmployeeInitialForm();  
                table(); 
                $.unblockUI(); 
            }).fail(function() { 
                alert("Error! Problem in saving initial for this employee");
            });              
            return false; 
        }
    }); 
    
    function clearEmployeeInitialForm()
    { 
    	$('#employeeNumberInitial').val("");
    	$('#employeeNumberInitial_combobox').val(""); 
    	$('#oldInitial').val(""); 
    	$('#newInitial').val(""); 
        return 0;
    } 
    
    $('#employeeNumberInitial').combobox({ 
        select: function(event,ui) {
        	var employeeNumber = $(this).val();  
        	changeEmployeeInitial(employeeNumber); 
        } 
    }); 
    
    function changeEmployeeInitial(employeeNumber) {
    	// $('#oldInitial').val(0); 
    	$.blockUI({ message: '<h4>Please Wait...loading Old Initial</h4>' });
    	var request = $.ajax({
            url: "/employeeinitial/getoldinitial", 
            type: "POST", 
            data: { 
            	empNumber : employeeNumber 
            }
        }).done(function(data) {                                
        	var obj = jQuery.parseJSON(data);              
        	 $('#oldInitial').val(obj.oldInitial);     
            $.unblockUI(); 
        }).fail(function() {
            alert("Error! Problem in loading old Initial for this employee"); 
        });              
        return true;
    }
    
     
    
    // loads table on page load  
    // table(); 
    
    function table() { 
        $("#employeeInitialContainer").zfTable('/employeeinitial/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#updateInitialForm').serialize();  
                return '&' + data;
            }, 
         }); 
    } 
    
}); 