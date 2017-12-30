$(document).ready(function()
{   
	$(document.body).on('click','.removePromotion a',function(e) { 
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
		              alert("Error! Problem in removing promotion details for this employee");
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
    
    $('#employeeNumberPromo,#togglePromoOption').combobox({
        select: function(event,ui) {
        	var employeeNumber= $('#employeeNumberPromo').val();
        	var toggleOption = $('#togglePromoOption').val();
        	//console.log(employeeNumber);
        	//console.log(toggleOption);
        	changePromotion(employeeNumber,toggleOption); 
        }
    });
    
    $('#incrementPercentage').on('change',function(e) { 
        var oldInitial =  $('#oldInitial').val();
        var newPercentage = $('#incrementPercentage').val();
        //newPercentage = 1 + ( Math.round(100 * newPercentage) / 100);
        var newValue = (oldInitial*1) * (newPercentage*1);
        var percentage  = Math.round(100 * newPercentage) / 100;
        var newInitial = Math.round(100 * newValue) / 100;
        //newValue = Math.round(100 * newValue) / 100;
        $('#promotedInitial').val(newInitial);  
        $('#incrementPercentage').val(percentage);   
    });  
    
    $('#promotedInitial').on('change',function(e) { 
        var oldInitial =  $('#oldInitial').val();
        var newInitial = $('#promotedInitial').val();
        //newPercentage = 1 + ( Math.round(100 * newPercentage) / 100);
        var newPercentage = (newInitial*1) / (oldInitial*1);
        var percentage  = Math.round(100 * newPercentage) / 100;
        
        //newValue = Math.round(100 * newValue) / 100;
        // $('#promotedInitial').val(newValue); 
        $('#incrementPercentage').val(percentage);  
        
    });
    
    function changePromotion(employeeNumber,toggleOption) {
    	$.blockUI({ message: '<h4>Please Wait...loading promotion Data</h4>' });
    	var request = $.ajax({
            url: "/promotion/getpromotiondetails",
            type: "POST",
            data: {
            	empNumber : employeeNumber,
            	toggleOpt : toggleOption
            }
        }).done(function(data) {                                
        	var obj = jQuery.parseJSON(data);              
            $('#oldInitial').val(obj.oldInitial); 
            //$("#yourid option[value="+obj.oldSalaryGrade+"]").text()
            $('#oldSalaryGrade').val($("#promoSalaryGrade").find("option[value="+obj.oldSalaryGrade+"]").text());
            //$('#oldSalaryGrade_combobox').val($("#oldSalaryGrade").find("option:selected").text());
            $('#tenPercentage').val(obj.tenPercentage); 
            $('#maxQuartileOne').val(obj.maxQuartileOne); 
            $('#difference').val(obj.difference);  
            $("#promoSalaryGrade").val($.trim(obj.promoSalaryGrade));
            $("#promoSalaryGrade_combobox").val($("#promoSalaryGrade").find("option:selected").text());
            $('#promotedInitial').val(obj.promotedInitial); 
            $('#incrementPercentage').val(obj.incrementPercentage);      
            $.unblockUI(); 
        }).fail(function() {
            alert("Error! Problem in loading promotion details for this employee");
        });              
        return true;
    }
    
    function clearPromotionForm()
    { 
    	$('#employeeNumberPromo').val("");
    	$('#employeeNumberPromo_combobox').val("");
        $('#promoSalaryGrade').val("");
        $('#promoSalaryGrade_combobox').val("");
        $('#promotedInitial').val(""); 
        $('#incrementPercentage').val(""); 
        //$('#difference').val(""); 
        $('#oldInitial').val(""); 
        $('#oldSalaryGrade').val("");
        $('#tenPercentage').val(""); 
        $('#maxQuartileOne').val(""); 
        $('#difference').val("");
        return 0;
    }
      
    //togglePromoOption
    /*$('#togglePromoOption').combobox({
        select: function(event,ui) {
        	var toggleOption = $(this).val();
        	var employeeNumber= $('#employeeNumberPromo').val();
        	changePromotion(employeeNumber,toggleOption); 
        	  
        }
    });*/  
    
    /*var employeeNumber = $().val();
    var request = $.ajax({
        url: "/promotion/getpromotiondetails",
        type: "POST",
        data: {
        	empNumber : employeeNumber
        }
    }).done(function(data) {                                
    	var obj = jQuery.parseJSON(data);              
        $('#oldInitial').val(obj.oldInitial); 
        $('#oldSalaryGrade').val(obj.oldSalaryGrade); 
    }).fail(function() {
        alert("Error! Problem in loading promotion details for this employee");
    });              
    return true;*/
     
    table();
    
    $("#promotionForm").submit(function(e) {
        e.preventDefault(); 
        //table(); 
    }).validate({
    	rules: {
        	promoSalaryGrade_combobox: { required: true },
        	employeeNumberPromo_combobox: { required: true },
        	togglePromoOption_combobox: { required: true }
        }, 
        messages: {
        	promoSalaryGrade_combobox: "please select promoted salary grade",
        	employeeNumberPromo_combobox: "please select employee",
        	togglePromoOption_combobox: "please select promotion option"
        }, 
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {};
            var formArray = $("#promotionForm").serializeArray(); 
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
                url: "/promotion/savepromotion", 
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {                                 
            	//var obj = jQuery.parseJSON(data);               
                //$('#promotionList').html(obj.promotionList);  
                clearPromotionForm(); 
                table();
                $.unblockUI(); 
            }).fail(function() { 
                alert("Error! Problem in loading promotion details for this employee");
            });              
            return false; 
        }
    });
    
    function table(){
        $("#promotionTableContainer").zfTable('/promotion/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#promotionForm').serialize();
                return '&' + data;
            },
         }); 
    }
        
}); 