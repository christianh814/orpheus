<?php
require_once("includes/config.php");
require_once("includes/classes/Artist.php");
require_once("includes/classes/Album.php");
require_once("includes/classes/Song.php");
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
	<link rel="icon" href="favicon.ico">
</head>
<body>
<div id="mainContainer">

	<div id="topContainer">

		<?php require_once("includes/navbar_container.php"); ?>

		<div id="mainViewContainer">
			<div id="mainContent">
