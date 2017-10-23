<?php
if(isset($_POST['loginButton'])) {
	$username = mysqli_real_escape_string($con, $_POST['loginUsername']);
	$password = mysqli_real_escape_string($con, $_POST['loginPassword']);

	//Login

	if($account->loginUser($username, $password)) {
		$_SESSION['user_logged_in'] = $username;
		header("Location: index.php");
	}
}
?>
