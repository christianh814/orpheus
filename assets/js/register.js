$(document).ready(function() {
	// When the register form is clicked; hide the login form
	$("#hideLogin").click(function() {
		$("#loginForm").hide();
		$("#registerForm").show();
	});

	// When the login form is clicked; hide the register form
	$("#hideRegister").click(function() {
		$("#loginForm").show();
		$("#registerForm").hide();
	});
});
