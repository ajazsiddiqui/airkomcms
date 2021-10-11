(function($) {
    "use strict"

    // Daterange picker
    $('.input-daterange-datepicker').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
		locale:{format: 'DD/MM/YYYY'},
		"autoApply": true,
    });
    // $('.input-daterange-timepicker').daterangepicker({
        // timePicker: true,
        // format: 'MM/DD/YYYY h:mm A',
        // timePickerIncrement: 30,
        // timePicker12Hour: true,
        // timePickerSeconds: false,
        // buttonClasses: ['btn', 'btn-sm'],
        // applyClass: 'btn-danger',
        // cancelClass: 'btn-inverse'
    // });
    $('.input-datepicker').daterangepicker({
        locale:{format: 'DD/MM/YYYY'},
		singleDatePicker: true,
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
		"autoApply": true,
        dateLimit: {
            days: 6
        }
    });
	


})(jQuery);