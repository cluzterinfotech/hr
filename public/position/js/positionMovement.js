$(document).ready(function() 
{   	 
	$( "#effectiveDate").datepicker({
        dateFormat: 'yy-mm-dd',
    	changeMonth: true,
    	changeYear: true,
    }); 
	
	$("#employeeNumberPosition").combobox({select : function(event, ui) { 
		var request = $.ajax({
            url: '/positionmovement/getcurrentposition', 
            type: "POST",
            data: {  
                empNumber:ui.item.value
            } 
        }).done(function(data) { 
            var obj = jQuery.parseJSON(data);
            //console.log(obj); 
            //console.log(obj.position); 
            //$("#employeeExistingPosition").val(obj.position); 
            $("#employeeExistingPosition").val($.trim(obj.position));
            $("#employeeExistingPosition_combobox").val($("#employeeExistingPosition").find("option:selected").text());
            //prepareThisLeaveDays();
        }).fail(function() {
            alert("Sorry! an error occured"); 
        }); 
    }});  
	
	$(document.body).on('click','.removeNewPosition a',function(e) { 
		e.preventDefault();
		targetUrl = $(this).attr('href'); 
		$("#dialog").dialog({
		      buttons : {
		        "Remove" : function() { 
		            var request = $.ajax({
		                url: targetUrl,
		                type: "POST",
		            }).done(function(data) {    
                        //console.log("success"); 
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
    
    $('#positionMovementForm').submit(function(e) { 
    	e.preventDefault(); 
    }).validate({ 
    	rules: { 
    		employeeNumberPosition_combobox: { required: true },
    		employeeNewPosition_combobox: { required: true },
        }, 
        messages: { 
        	employeeNumberPosition_combobox: "please select employee",
        	employeeNewPosition_combobox: "please select employee new position"
        }, 
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {};
            var formArray = $("#positionMovementForm").serializeArray(); 
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
                url: "/positionmovement/savepositionmovement", 
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {      
            	if(data == 0) {
            	    alert("Sorry! Employee already in this position"); 	
            	} 
            	clearPositionMovementForm();  
                table();  
                $.unblockUI();  
            }).fail(function() { 
                alert("Error! Problem in saving new position for this employee"); 
                clearPositionMovementForm(); 
                $.unblockUI();  
            });              
            return false; 
        } 
    }); 
    
    function clearPositionMovementForm()
    { 
    	$('#employeeNumberPosition').val("");
    	$('#employeeNumberPosition_combobox').val(""); 
    	$('#employeeNewPosition').val("");
    	$('#employeeNewPosition_combobox').val("");
    	$('#employeeExistingPosition').val("");
    	$('#employeeExistingPosition_combobox').val("");
        return 0;
    }
    
    // table();
    
    function table() {
        $("#newEmployeePositionContainer").zfTable('/positionmovement/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#positionMovementForm').serialize(); 
                return '&' + data;
            },
         }); 
    }
    
}); 