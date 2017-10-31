<?php
require_once("../../config.php");

if(isset($_POST["songId"])) {
	$song_id = $_POST["songId"];

	$sql = "UPDATE songs SET plays = plays + 1 WHERE id = '{$song_id}' ";
	$query = mysqli_query($con, $sql);

}
?>
