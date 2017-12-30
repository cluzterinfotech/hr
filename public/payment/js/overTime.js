$(document).ready(function()
{   
	$("#empIdOvertime").combobox("option", "disabled", true); 
	$("#submitOtToSup").button(); 
	$("#approveOt").button();
	$("#endorseOt").button(); 
	
	$( "#month,#year").datepicker({ 
        dateFormat: 'yy-mm-dd',
    	changeMonth: true,
    	changeYear: true,
    }); 
	
	$(document.body).on('click','#endorseOt',function(e) { 
		// console.log("endorse HR"); 
		e.preventDefault(); 
		$("#dialogEndorseHr").dialog({
		    buttons : {
			    "Endorse" : function() {       
			        var request = $.ajax({
			            url: "/overtimenew/endorsehrall",
			            type: "POST",
			        }).done(function(data) {    
	                    // console.log("success"); 
			        	endorseHrTable(); 
			        }).fail(function() {
			            alert("Error! Problem in Endorsing Overtime");
			        });    
			        $(this).dialog("close");
			        return true;  	          
			        }, 
			      "Cancel" : function() {
			        	$(this).dialog("close");   
			        }
			      }
			}); 
		$("#dialogEndorseHr").dialog("open"); 
	});
	
	$(document.body).on('change','#otFromDate,#otToDate',function(e) {  
		e.preventDefault(); 
		//alert("test date");
		var f = $.trim($("#otFromDate").val()); 
		var t = $.trim($("#otToDate").val());
		var emp = $.trim($("#empIdOvertime").val()); 
		if(f && t) { 
			// table(); 
			targetUrl = $(this).attr('href');    
			var request = $.ajax({
	            url: '/overtimenew/savedinfo', 
	            type: "POST",
	            data: {  
	                from:f,
	                to:t,
	                employee:emp 
	            } 
	        }).done(function(data) { 
	            var obj = jQuery.parseJSON(data);
	            $("#employeeNoNOHours").val(obj.employeeNoNOHours); 
	            $("#employeeNoHOHours").val(obj.employeeNoHOHours); 
	            $("#numberOfMeals").val(obj.numberOfMeals);   
	            table(); 
	        }).fail(function() {
	            alert("Sorry! an error occured"); 
	        });
		}  
	});
	
	function table() {
        $("#overtimeContainer").zfTable('/overtimenew/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#OverTimeForm').serialize(); 
                return '&' + data;
            } 
        });  
    } 
	
	/*$(document).on('click','.row-save',function(e) { 
	    alert("working ok");  	
	});*/
	// rejectOvertime 
	// approveHrOvertime
	// rejectHrOvertime
	
	/*$(document.body).on('click','.approveOvertime a',function(e) { 
		e.preventDefault(); 
		//alert("individual approval"); 
		targetUrl = $(this).attr('href');    
		$("#dialog").dialog({
		    buttons : {
			    "Approve" : function() {       
			        var request = $.ajax({
			            url: targetUrl,
			            type: "POST",
			        }).done(function(data) {    
	                    // console.log("success"); 
			          	apptable(); 
			        }).fail(function() {
			            alert("Error! Problem in approving recored for this employee");
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
	});*/
	
	// $(".rejectOvertime").on('click',function(e) { 
	$(document.body).on('click','.rejectOvertime a',function(e) { 
		e.preventDefault(); 
		//alert("individual reject"); 
		targetUrl = $(this).attr('href'); 
		$("#dialogRej").dialog({
		    buttons : {
			    "Reject" : function() {       
			        var request = $.ajax({
			            url: targetUrl,
			            type: "POST",
			        }).done(function(data) {    
	                    // console.log("success"); 
			          	apptable(); 
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
			$("#dialogRej").dialog("open"); 
	});  
	
	/*$("#approveOt").on('click',function(e) { 
		e.preventDefault(); 
		targetUrl = $(this).attr('href');    
		$("#dialogAll").dialog({
		    buttons : {
			    "Approve" : function() {       
			        var request = $.ajax({
			            url: "/overtimenew/submittosup",
			            type: "POST",
			        }).done(function(data) {    
	                    // console.log("success"); 
			          	apptable(); 
			        }).fail(function() {
			            alert("Error! Problem in approving recored for this employee");
			        });    
			            $(this).dialog("close");
			            return true;  	          
			        }, 
			        "Cancel" : function() {
			        	$(this).dialog("close");   
			        }
			      }
			}); 
			$("#dialogAll").dialog("open"); 
	});*/      
	
	$(document.body).on('click','.removeOvertimeBatch a',function(e) { 
		e.preventDefault();                                          
		targetUrl = $(this).attr('href');                           
		$("#dialog").dialog({
		      buttons : {
		        "Remove" : function() {       
		            var request = $.ajax({
		                url: targetUrl,
		                type: "POST",
		                
		            }).done(function(res) {    
                        // console.log("success");
                        tableb();
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
	
	$('#submitOtToSup').on('click',function(e) { 
		e.preventDefault();
	    // console.log("submitted the supervisor"); 
		var f = $("#otFromDate").val();
    	var t =  $("#otToDate").val();
    	var emp = $("#empIdOvertime").val();  
    	re=/^0[0-9]|1[0-9]|2[0-3]:[0-5][0-9]$/; 
    	var nrHr = $("#employeeNoNOHours").val();
    	var hoHr = $("#employeeNoHOHours").val();
    	var meal = $("#numberOfMeals").val(); 
    	if(!re.test(nrHr) || !re.test(hoHr)) {
    		alert("Please enter valid time"); 
    		return false; 
    	}
    	var comp = '00:00'; 
    	if(nrHr == '' || nrHr == '' || meal == '') {
    		alert("Please enter value"); 
    		return false;
    	} 
    	if(nrHr == comp && nrHr == comp && meal == 0) {
    		alert("All entries are zero"); 
    		return false;
    	}     	
		$("#subToSupDialog").dialog({
		      buttons : {
		        "Yes" : function() {       
		            var request = $.ajax({
		                url: "/overtimenew/submittosup", 
		                type: "POST",
		                data: { 
	                    	from : f,
	                    	to : t,
	                    	employee:emp 
	                    }, 
		            }).done(function(data) {  
		            	
                      // console.log(data); 
                      // table();
		              window.location.replace("/overtimenew/add"); 
		          }).fail(function() {
		              alert("Error! Problem in submitting to supervisor"); 
		          });     
		              $(this).dialog("close"); 
		              return true;   	          
		        },  
		        "No" : function() { 
		        	$(this).dialog("close");    
		        } 
		      }
		});  
		$("#subToSupDialog").dialog("open");
		
		
	}); 
	
    //*********************************************************************************************************
   $(document.body).on('click','.removeOvertime a',function(e) { 
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
    
    /*$('#OverTimeForm').validate({ 
    	rules: { 
             overtimeDate:{ required:true},
    		 employeeNoNOHours: { required: true },
             employeeNoHOHours: { required: true },
             month_combobox: { required: true },
             year_combobox: { required: true },
             //companyId: { required: true },
        }, 
        messages: { 
             overtimeDate: "please select employee",
             employeeNoHOHours:"please No of holiday hours",
             employeeNoNOHours: "please select No of Normal hours",
             month_combobox: "please select Month",
             year_combobox: "please select Year" 
        },     
    });*/     
   
   $('#OverTimeForm').validate({ 
   	rules: { 
           overtimeDate:{ required:true},
  		    employeeNoNOHours: { required: true },
           employeeNoHOHours: { required: true },
           month_combobox: { required: true },
           year_combobox: { required: true },
      }, 
      messages: { 
           overtimeDate: "please select employee",
           employeeNoHOHours:"please No of holiday hours",
           employeeNoNOHours: "please select No of Normal hours",
           month_combobox: "please select Month",
           year_combobox: "please select Year" 
      } 
   }); 
   
   /* $('#OverTimeForm').submit(function(e) {  
    	e.preventDefault(); 
    }).validate({ 
    	rules: { 
            overtimeDate:{ required:true},
   		    employeeNoNOHours: { required: true },
            employeeNoHOHours: { required: true },
            month_combobox: { required: true },
            year_combobox: { required: true },
       }, 
       messages: { 
            overtimeDate: "please select employee",
            employeeNoHOHours:"please No of holiday hours",
            employeeNoNOHours: "please select No of Normal hours",
            month_combobox: "please select Month",
            year_combobox: "please select Year" 
       }, 
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data </h4>' });
            var formValues = {};
            var formArray = $("#OverTimeForm").serializeArray(); 
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
                url: "/overtimenew/saveempot", //view name
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {      
            	// console.log("adding values"); 
                   table(); 
                $.unblockUI(); 
            }).fail(function() { 
                alert("Error! Problem in adding overtime  "); 
            });              
            return false; 
        } 
    });*/ 
 
    /*$('#OverTimeBatchForm').submit(function(e) { 
        //console.log('fghj');
    	e.preventDefault(); 
    }).validate({ 
    	rules: { 
//    		empId_combobox: { required: true },
//                isClosed: { required: true },
//                 empId: { required: true },
        }, 
        messages: { 
//        	empId_combobox: "please select employee",
//        	empId: "please select employee 1111111111",
//                empId: "please select empId",
    //*            companyId:"please companyId",
//                isClosed: "please select isClosed",
        }, 
        submitHandler: function(form) { 
            $.blockUI({ message: '<h4>Please Wait...while Saving Data</h4>' });
            var formValues = {};
            var formArray = $("#OverTimeBatchForm").serializeArray(); 
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
                url: "/overtime/saveovertimebatch", //view name
                type: "POST", 
                data: { 
                	//empNumber : employeeNumber, 
                	formVal : formValues 
                } 
            }).done(function(data) {      
                  var d = (data * 1);
                        if(d > 0) {
                            alert('Batch Opened Successfuly'); 
                        } else if(d ==null){
                            alert('Problem!!! There is Batch remain not posted, please check'); 
                             $("#confirmDlg").dialog('close');
                        } 
                                  
            	// console.log("adding values"); 
            	clearOverTimeForm(); 
                tableb(); 
                $.unblockUI(); 
            }).fail(function() {
                
                alert("Error! Problem in saving overtime Please make sure there is no un-posted Batch"); 
               $.unblockUI(); 
       });              
            return false; 
        } 
    }); */ 
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
    
    
    
    function clearOverTimeForm()
    { 
    	$('#empId').val("");
    	$('#empId_combobox').val(""); 
    	$('#overtimeDate').val("");
    	$('#employeeNoHOHours').val("");
        $('#employeeNoNOHours').val("");
    	$('#companyId').val("");
        //$('#isClosed').val("");
    	$('#empId').val("");
        return 0;
    }
    
    // table();
    
    function table() {
        $("#overtimeContainer").zfTable('/overtimenew/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#OverTimeForm').serialize(); 
                return '&' + data;
            } 
        });  
    } 
    
    function apptable() {
        $("#overtimeContainer").zfTable('/overtimenew/approvelist', {
            sendAdditionalParams: function() {
                var data = $('#OverTimeForm').serialize(); 
                return '&' + data;
            } 
        });  
    } 
    
    function endorseHrTable() {
        $("#overtimeContainer").zfTable('/overtimenew/endorselist', {
            sendAdditionalParams: function() {
                //var data = $('#OverTimeForm').serialize(); 
                //return '&' + data;
            } 
        });  
    } 
   //****************************************************************************
    
    function tableb() {
        $("#overtimeContainer").zfTable('/overtime/ajaxbatch', {
            sendAdditionalParams: function() {
                var data = $('#OverTimeBatchForm').serialize(); 
                return '&' + data;
            }
         }); 
    }
   //****************************************************************************
}); 
