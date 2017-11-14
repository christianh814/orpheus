<?php
require_once("../../config.php");

if(isset($_POST["email"]) && isset($_POST["username"]) && $_POST["email"] != "") {
	$email = $_POST["email"];
	$username = $_POST["username"];

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "The email was invalid";
		exit;
	}

	$emailchk_sql = "SELECT email FROM users WHERE email = '{$email}' AND username != '{$username}' ";
	$emailchk_query = mysqli_query($con, $emailchk_sql);

	if (mysqli_num_rows($emailchk_query) > 0) {
		echo "Email is in use";
		exit;
	}

	$sql = "UPDATE users SET email = '{$email}' WHERE username = '{$username}' ";
	$query = mysqli_query($con, $sql);
	echo "Updated email!";

} else {
	echo "The email or username was malformed";
	exit;
}
?>
