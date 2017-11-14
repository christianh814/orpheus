<?php
require_once("../../config.php");
//
if(!isset($_POST["oldpassword"]) || !isset($_POST["newpassword1"]) || !isset($_POST["newpassword2"]) || !isset($_POST["username"])) {
	echo "Not all passwords were set";
	exit;
}
if($_POST["oldpassword"] == "" || $_POST["newpassword1"] == "" || $_POST["newpassword2"] == "" || $_POST["username"] == "") {
	echo "Passwords cannot be blank";
	exit;
}
//
$username = $_POST["username"];
// Create a row of user information
$user_sql = "SELECT * FROM users WHERE username = '${username}' ";
$user_query = mysqli_query($con, $user_sql);
$row = mysqli_fetch_array($user_query);
//
$oldpassword = $_POST["oldpassword"];
$newpassword1 = $_POST["newpassword1"];
$newpassword2 = $_POST["newpassword2"];
// Verifying old password
if (!password_verify($oldpassword, $row['password'])) {
	echo "Old password not verified!";
	exit;
}
// Verifying the two new passwords
if($newpassword1 !== $newpassword2) {
	echo "Passwords do not match!";
	exit;
}
// Verifying if the passowrd is in the right format
if(preg_match('/[^A-Za-z0-9]/', $newpassword1)) {
	echo "Your passwords must be letters and numbers";
	exit;
}
if(strlen($newpassword1) > 30 || strlen($newpassword1) < 5) {
	echo "Your password must be between 5 and 30 characters!";
	exit;
}

// If we're here...everything is okay
$password = password_hash($newpassword1, PASSWORD_BCRYPT, array('cost' => 12));
$sql = "UPDATE users SET password  = '{$password}' WHERE username = '{$username}' ";
$query = mysqli_query($con, $sql);
echo "Update successful!";
?>
