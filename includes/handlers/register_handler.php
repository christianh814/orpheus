<?php
function sanitizeFormPassword($input) {
	return !empty($input) ? strip_tags($input) : false;
}
function sanitizeFormUsername($input) {
	return !empty($input) ? strtolower(str_replace(" ", "", strip_tags($input))) : false;
}
function sanitizeFormString($input) {
	return !empty($input) ? ucfirst(strtolower(str_replace(" ", "", strip_tags($input)))) : false;
}
//
if(isset($_POST['registerButton'])) {
	//register user
	$username = sanitizeFormUsername($_POST['username']);
	$firstname = sanitizeFormString($_POST['firstName']);
	$lastname = sanitizeFormString($_POST['lastName']);
	$email1 =  sanitizeFormUsername($_POST['email']);
	$email2 =  sanitizeFormUsername($_POST['email2']);
	$pw1 =  sanitizeFormPassword($_POST['password']);
	$pw2 =  sanitizeFormPassword($_POST['password2']);
	$pic = "assets/images/profile_pics/head_emerald.png";
	//
	$was_successful = $account->register($username, $firstname, $lastname, $email1, $email2, $pw1, $pw2, $pic);

	if($was_successful) {
		$_SESSION['user_logged_in'] = $username;
		$_SESSION['user_logged_in_firstname'] = $firstname;
		$_SESSION['user_logged_in_lastname'] = $lastname;
		$_SESSION['user_logged_in_fullname'] = $firstname . " " . $lastname;
		header("Location: index.php");
	}
}
?>
