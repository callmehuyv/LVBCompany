$(document).ready(function() {
    $('#selectLine').change(function(){
        var id = $('#selectLine').val();
        if (id != 'null') {
        	window.location.replace($('#currentUrl').val()+ '?line=' + id);
        } else {
        	window.location.replace($('#currentUrl').val());
    	}
    });
    $('#selectCompany').change(function(){
        var id = $('#selectCompany').val();
        if (id != 'null') {
            window.location.replace($('#currentUrl').val()+ '?company=' + id);
        } else {
            window.location.replace($('#currentUrl').val());
        }
    });
    $('#selectVehicletype').change(function(){
        var id = $('#selectVehicletype').val();
        if (id != 'null') {
            window.location.replace($('#currentUrl').val()+ '?vehicletype=' + id);
        } else {
            window.location.replace($('#currentUrl').val());
        }
    });

	$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
	    event.preventDefault();
	    $(this).ekkoLightbox();
	});
});