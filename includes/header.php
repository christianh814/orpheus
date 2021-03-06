<?php
require_once("includes/config.php");
require_once("includes/vendor/autoload.php");
require_once("includes/classes/Artist.php");
require_once("includes/classes/Album.php");
require_once("includes/classes/Song.php");
//
if (isset($_SESSION['user_logged_in'])) {
	$user_logged_in = $_SESSION['user_logged_in'];
	echo "<script> userLoggedIn = \"{$user_logged_in}\"; </script>";
} else {
	header("Location: register.php");
}
?>
<html>
<head>
	<title>Welcome to Orpheus!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/jquery.growl.css"> 
	<link rel="icon" href="favicon.ico">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="assets/js/script.js"> </script>
	<script src="assets/js/jquery.growl.js"> </script>
</head>
<body>
<div id="mainContainer">

	<div id="topContainer">

		<?php require_once("includes/navbar_container.php"); ?>

		<div id="mainViewContainer">
			<div id="mainContent">
