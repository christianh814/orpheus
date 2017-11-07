<?php
require_once("../../config.php");

if(isset($_POST["name"]) && isset($_POST["username"])) {
	$name = $_POST["name"];
	$username = $_POST["username"];
	$date = date("Y-m-d");

	$sql =  "INSERT INTO playlists (name, owner, date_created) ";
	$sql .= "VALUES ('{$name}', '{$username}', '{$date}') ";
	$query = mysqli_query($con, $sql);

} else {
	echo "The playlist name is invalid";
}
?>
