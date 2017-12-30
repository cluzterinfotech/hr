$(document).ready(function()
{   
	// $("#navigation").style(""); 
    $(".delete").on("click", function(e) {
        alert("lol"+e); 
    });  
     
    $(function() {
    	
        $("#from").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            constrainInput: true,
            dateFormat: "yy-mm-dd",
            onClose: function(selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#to").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            changeYear: true,
            constrainInput: true,
            dateFormat: "yy-mm-dd",
            onClose: function(selectedDate) {
                $("#from").datepicker("option", "maxDate", selectedDate);
            }
        });
    });
    $("#leaveForm").on("change", ".employeeId", function() {
        alert("lol");

    });
    //$('#mydate').datepicker();
    function calcOutStanding(entitled, takenDayes)
    {

    }
    /*
     * 
     * ajax loader for leave form 
     */
    function updateLeaveForm()
    {
        // alert("wor");
        var form = $("#leaveForm");
        var id = form.find(".employeeId").val();
        var DateOfJoin = form.find("#JoinDate");
        var position = form.find("#positionId_combobox");
        var position2 = form.find('#positionId');
        var department = form.find("#departmentId_combobox");
        var location = form.find("#locationId_combobox");
        // var delegatedEmployee = form.find("#delegatedPositionId");
        var takenDayes = form.find("#alreadyTaken");
        var entitled = form.find("#leaveEntitled");
        var outstandingBalance = form.find("#outstandingBalance");
        //var fromDate = form.find("#from");
        //var toDate = form.find("#to");
        var currentLeave = form.find("#currentLeaveDays");
        var remaining = form.find("#remainingBalance");

        $.ajax({
            type: "POST",
            url: "/leave/getEmployeeInfo",
            data: {id: id},
            datatype: 'json',
            success: function(data)
            {
                obj = $.parseJSON(data);
                //alert(position.find('option:selected').text());
                //alert();
                DateOfJoin.val(obj.joinDate);
                var a = position2.val(obj.positionId);
                position.val(a.find("option:selected").text());
                department.val(obj.departmentId);
                location.val(obj.locationId);
                //       delegatedEmployee.val(obj.delegatedPositionId);
                takenDayes.val(obj.alreadyTaken);
                entitled.val(obj.leaveEntitled);
                outstandingBalance.val(obj.leaveEntitled - obj.alreadyTaken);
                currentLeave.val(5);
                remaining.val(outstandingBalance.val() - currentLeave.val());
            }
        });
    }
    /*
     * employee name auto complete 
     */
    $(function() { 
        $('#employee_id').combobox({
            select: function(event, ui) {
                updateLeaveForm();
            }
        });
    });



function validateLeaveForm() { 
    (function() {
        // use custom tooltip; disable animations for now to work around lack of refresh method on tooltip
        $("#student").tooltip({
            show: true,
            hide: true
        });
        // validate the comment form when it is submitted
        $("#leaveForm").validate(
                {
                    rules: {
                        employee_id_combobox: {
                            required: true,
                            minlength: 2
                        },
                        locationId_combobox: "required",
                        positionId_combobox: "required",
                        departmentId_combobox: "required",
                        delegatedPositionId_combobox: "required"
                    },
                    messages: {
                        locationId_combobox: "locationId employee should be filled",
                        leave_from: "The start date of the leave should be filled",
                        approval: "select one of the options",
                        employee_id_combobox: "employee name is required",
                        positionId_combobox: "position should be filled",
                        departmentId_combobox: "department should be filled",
                        delegatedPositionId_combobox: "delegated employee should be filled"
                    }
                });
        $("#submitLeave").button();
    })();
}

});