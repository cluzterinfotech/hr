$(document).ready(function()
{   
      
	//$('#promoSalaryGrade').combobox();
	
	
    $("#addPromotion").on('click',function(e) {
        //alert("promotion submitted");
        var employeeNumber = $('#employeeNumberPromo').val();
        e.preventDefault();
        var request = $.ajax({
            url: "/promotion/getpromotionnamelist",
            type: "POST",
            data: {
            	empNumber : employeeNumber
            }
        }).done(function(data) {                                
        	var obj = jQuery.parseJSON(data);              
            $('#promotionList').html(obj.promotionList); 
            
        }).fail(function() {
            alert("Error! Problem in loading promotion details for this employee");
        });              
        return true;
    }); 
    
    $('#employeeNumberPromo').combobox({
        select: function(event,ui) {
        	var employeeNumber = $(this).val();
            var request = $.ajax({
                url: "/promotion/getpromotiondetails",
                type: "POST",
                data: {
                	empNumber : employeeNumber
                }
            }).done(function(data) {                                
            	var obj = jQuery.parseJSON(data);              
                $('#oldInitial').val(obj.oldInitial); 
                
            }).fail(function() {
                alert("Error! Problem in loading promotion details for this employee");
            });              
            return true;
            
        }
    });
      
    //togglePromoOption
    $('#togglePromoOption').combobox({
        select: function(event,ui) {
        	var employeeNumber = $(this).val();
            var request = $.ajax({
                url: "/promotion/getpromotiondetails",
                type: "POST",
                data: {
                	empNumber : employeeNumber
                }
            }).done(function(data) {                                
            	var obj = jQuery.parseJSON(data);              
                $('#oldInitial').val(obj.oldInitial); 
                
            }).fail(function() {
                alert("Error! Problem in loading promotion details for this employee");
            });              
            return true;
            
        }
    });
    
}); 