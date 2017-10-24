<?php
require_once("includes/config.php");
//
if (isset($_SESSION['user_logged_in'])) {
	$user_logged_in = $_SESSION['user_logged_in'];
} else {
	header("Location: register.php");
}
?>
<html>
<head>
	<title>Welcome to Orpheus!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
	<div id="nowPlayingBarContainer">
		<div id="nowPlayingBar">
			
			<div id="nowPlayingLeft">
			</div>

			<div id="nowPlayingCenter">
			</div>

			<div id="nowPlayingRight">
			</div>

		</div> <!-- now playing bar-->

	</div> <!-- now playing bar container -->
</body>
</html>
