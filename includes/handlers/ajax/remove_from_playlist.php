<?php
require_once("../../config.php");

if(isset($_POST["playlist_id"]) && isset($_POST["song_id"])) {
	$playlist_id = $_POST["playlist_id"];
	$song_id = $_POST["song_id"];

	$sql =  "DELETE FROM playlistsongs WHERE playlist_id = '{$playlist_id}' AND song_id = '{$song_id}' ";
	$query = mysqli_query($con, $sql);

} else {
	echo "The playlist or the song ID is invalid";
}
?>
