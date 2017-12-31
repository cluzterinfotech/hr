$(document).ready(function()
{   
	$('#advanceHousingFromDate').datepicker({
        dateFormat: 'yy-mm-dd',
	    changeMonth: true,
	    changeYear: true,
    }); 
	
	$(document.body).on('click','.removeSiAllowance a',function(e) { 
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
		              alert("Error! Problem in deleting this Social Insurance Allowance");
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
    
    $('#employeeNumberHousing').combobox({
        select: function(event,ui) {
        	var employeeNumber = $(this).val();
        	var noOfMonths = $('#numberOfMonthsHousing').val(); 
        	changeAdvanceHousing(employeeNumber,noOfMonths);
        } 
    }); 
    
    function table(){
    	$("#tableContainer").zfTable('/siallowance/ajaxlist');
        /*$("#tableContainer").zfTable('/siallowance/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#advanceHousingForm').serialize(); 
                return '&' + data;
            },
         });*/  
    }
    
    $("#dialog").dialog({
	    autoOpen: false,
	    modal: true
	});
    
}); 