<?php
require_once("../../config.php");

if(isset($_POST["songId"])) {
	$song_id = $_POST["songId"];

	$sql = "SELECT * FROM songs WHERE id = '{$song_id}' ";
	$query = mysqli_query($con, $sql);

	$result = mysqli_fetch_array($query);

	echo json_encode($result);
}
?>
