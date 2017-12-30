$(document).ready(function()
{   	
	$(document.body).on('click','.removeOvertimeBatch a',function(e) { 
		e.preventDefault();
		targetUrl = $(this).attr('href'); 
		$("#dialog").dialog({
		      buttons : {
		        "Remove" : function() {  
                         
		            var request = $.ajax({
		                url: targetUrl,
		                type: "POST",
		            }).done(function(data) {    
                        console.log("success"); 
                        tableb();
		          }).fail(function() {
		              alert("Error! Problem in removing this batch.... You have to make sure there is no entry on this batch");
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
    //*********************************************************************************************************
   $(document.body).on('click','.removeOvertimeMeal a',function(e) { 
		e.preventDefault();
		targetUrl = $(this).attr('href'); 
		$("#dialog").dialog({
		      buttons : {
		        "Remove" : function() { 
		            var request = $.ajax({
		                url: targetUrl,
		                type: "POST",
		            }).done(function(data) {    
                        console.log("success"); 
                        table();
		          }).fail(function() {
		              alert("Error! Problem in removing recored for this employee");
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
    //*********************************************************************************************************
    $('#OverTimeMealForm').submit(function(e) { 
        //console.log('fghj');
    	e.preventDefault(); 
    }).validate({ 
    	rules: { 
    		empId_combobox: { required: true },
                employeeNoMeals:{ required:true},
    		
        }, 
        messages: {  
                employeeNoMeals: "please Insert No of Meals for this employee",
                empId_combobox:"Please Select Employee",
        }, 
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {};
            var formArray = $("#OverTimeMealForm").serializeArray(); 
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
                url: "/otmeal/saveovertime", //view name
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {      
            	// console.log("adding values"); 
            	clearOverTimeMealForm(); 
                table(); 
                $.unblockUI(); 
            }).fail(function() {
                
                alert("Error! Problem in adding meal for this employee.. You may need to open new Batch"); 
            });              
            return false; 
        } 
    }); 
 
//******************************************************************************************     
    $('#SubmitButonMealForm').submit(function(e) { 
        //console.log('fghj');
    	e.preventDefault(); 
    }).validate({ 
    	rules: { 
//    		empId_combobox: { required: true },
               
        }, 
        messages: { 
//        	empId_combobox: "please select employee",
//        	
        }, 
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data!!!!!</h4>' });
            var formValues = {};
            var formArray = $("#SubmitButonMealForm").serializeArray(); 
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
                url: "/otmeal/applyovertime", //view name
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	//formVal : formValues 
                } 
            }).done(function(data) {      
            	// console.log("adding values"); 
                    tableb(); 
                $.unblockUI(); 
            }).fail(function() {
                
                alert("Error! Problem in applying  overtime  "); 
            });              
            return false; 
        } 
    }); 
 //****************************************************************************************************** 
    
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    $('#OverTimeBatchMealForm').submit(function(e) { // set form the name
        //console.log('fghj');
    	e.preventDefault(); 
    }).validate({ 
    	rules: { 
   		month: { required: true },
                preparedBy:{ required:true},
    		approvedBy: { required: true },
                companyId: { required: true },
           
        }, 
        messages: { 
            preparedBy: "please select employee",
            approvedBy: "please select employee 1111111111",
            companyId: "please companyId",
            month: "please select month",
        }, 
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {};
            var formArray = $("#OverTimeBatchMealForm").serializeArray(); // set form the name
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
                url: "/otmeal/saveovertimebatch", //view name
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
               	formVal : formValues 
                } 
            }).done(function(data) {      
//                  var d = (data * 1);
//                        if(d > 0) {
//                            alert('Batch Opened Successfuly'); 
//                        } else if(d ==null){
//                            alert('Problem!!! There is Batch remain not posted, please check'); 
//                             $("#confirmDlg").dialog('close');
//                        } 
                                  
            	// console.log("adding values"); 
            	clearOverTimeMealBatchForm(); 
                tableb(); 
                $.unblockUI(); 
            }).fail(function() {
                
               // alert("Error! Problem in saving overtime Please make sure there is no un-posted Batch"); 
               $.unblockUI(); 
       });              
            return false; 
        } 
    }); 
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    
    
    
    function clearOverTimeMealForm()
    { 
    	$('#empId').val("");
    	$('#empId_combobox').val("");
    	$('#employeeNoMeals').val("");
    	$('#amount').val("");
        
        return 0;
    }
   function clearOverTimeMealBatchForm()
    { 
//    	$('#empId').val("");
//    	$('#empId_combobox').val("");
//    	$('#employeeNoMeals').val("");
        
        return 0;
    } 
    // table();
    
    function table() {
        $("#overtimemealContainer").zfTable('/otmeal/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#OverTimeMealForm').serialize(); //--------------
                return '&' + data;
            }
         }); 
    }
   //****************************************************************************
     
    function tableb() {
        $("#overtimemealContainer").zfTable('/otmeal/ajaxbatch', {
            sendAdditionalParams: function() {
                var data = $('#OverTimeBatchMealForm').serialize(); //-------------
                return '&' + data;
            }
         }); 
    }
   //****************************************************************************
}); 
