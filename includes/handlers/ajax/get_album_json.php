<?php
require_once("../../config.php");

if(isset($_POST["albumId"])) {
	$album_id = $_POST["albumId"];

	$sql = "SELECT * FROM albums WHERE id = '{$album_id}' ";
	$query = mysqli_query($con, $sql);

	$result = mysqli_fetch_array($query);

	echo json_encode($result);
}
?>
