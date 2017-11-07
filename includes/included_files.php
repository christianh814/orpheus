<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	require_once("includes/config.php");
	require_once("includes/classes/User.php");
	require_once("includes/classes/Artist.php");
	require_once("includes/classes/Album.php");
	require_once("includes/classes/Song.php");
	//
	if(isset($_GET['userLoggedIn'])) {
		$userLoggedIn = new User($con, $_GET['userLoggedIn']);
	} else {
		echo "Username malformed";
	}
} else {
	require_once("includes/header.php");
	require_once("includes/footer.php");

	$url = $_SERVER['REQUEST_URI'];
	echo "<script>openPage('{$url}')</script>";
	exit();
}
?>
