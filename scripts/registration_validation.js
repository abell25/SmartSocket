$(document).ready(function(){
	$('#username-id').on('change', function(event) {
		validateUsername(event);
	});
	
	var validateUsername = function(event) {
		clearErrorText();
		var username = $('#username-id').val();
		var foundError = false;
		
		if(username.length > 0) {
			if(username.length > 50) {
				var text = "The username must be less than 50 characters.";
				setErrorText(text);
				foundError = true;
			} 
			if(!username.match(/^[a-zA-Z0-9]+/)) {
				var text = "All username characters must be alphanumeric.";
				setErrorText(text);
				foundError = true;
			} 
			if(!foundError) { 
				$("#submit_button").attr('disabled', false);
			}
		}
	} 
	
	var clearErrorText = function() {
		var error = $("#error_text");
		error.text("");
		error.hide();
	}
	
	var setErrorText = function(text) {
		var error = $("#error_text");
		error.text(error.text() + " " + text);
		error.show();
		$("#submit_button").attr('disabled', true);
	}
});