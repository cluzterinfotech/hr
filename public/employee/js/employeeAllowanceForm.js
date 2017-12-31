$(function() {
    
	$('#allowanceName').combobox({
        select: function(event,ui) {
        	var allowanceName = $(this).val();
        	// console.log(allowanceName);
        	allowanceListTable();            
            return true;
            
        }
    }); 
	
	// allowanceListTable();
    
	function allowanceListTable() {
        $("#allowanceListContainer").zfTable('/employeefixedallowance/ajaxlist', {
            sendAdditionalParams: function() {
                var data = $('#AllowanceListForm').serialize(); 
                // console.log(data); 
                return '&' + data; 
            },
         }); 
    }
    
}); 