$(document).ready(function(){
	$('#username-id').on('change', function(event) {
		validateUsername(event);
	});
	
	var validateUsername = function(event) {
		var username = $('#username-id').val();
		if(username.length > 50) {
			var error = $("#error_text");
			error.val(error.val() + "<br /> The username must less than 50 characters.");
			error.show();
			$("#submit_button").attr('disabled', true);
		} else {
			$("#submit_button").attr('disabled', false);
		}
	} 
};
});