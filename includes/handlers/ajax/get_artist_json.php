<?php
require_once("../../config.php");

if(isset($_POST["artistId"])) {
	$artist_id = $_POST["artistId"];

	$sql = "SELECT * FROM artists WHERE id = '{$artist_id}' ";
	$query = mysqli_query($con, $sql);

	$result = mysqli_fetch_array($query);

	echo json_encode($result);
}
?>
