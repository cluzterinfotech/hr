$(function() { 
	// Default Setup
	$('select').combobox();
	$("#employeeNumber").combobox("disable");
    $("#leaveFrom,#leaveTo").datepicker({
        dateFormat: 'yy-mm-dd',
    	changeMonth: true,
    	changeYear: true,
    });
	
    // Executes while level were selected
	$("#organisationLevel").combobox({select : function(event, ui) { 
		     
        $.ajax({
              type:"POST",
              url:"/position/getReportingPositions",
              data: { organisationLevel:$(this).val() },
              success: function(data)
              {
            	  var selectReportingPosition = $("#reportingPosition"); 
                  var reportingPosOptions = selectReportingPosition.prop('options');
                  $('option',selectReportingPosition).remove();
                  $("#reportingPosition_combobox").val('');
                  
                  $.each(data.result, function(val, text) {
                      reportingPosOptions[reportingPosOptions.length] = new Option(text, val);
                  }); 
              }
        });
        
    }}); 
	
}); 