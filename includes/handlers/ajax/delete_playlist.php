<?php
require_once("../../config.php");

if(isset($_POST["playlist_id"])) {
	$playlist_id = $_POST["playlist_id"];

	$pl_sql =  "DELETE FROM playlists WHERE id = '{$playlist_id}' ";
	$pl_query = mysqli_query($con, $pl_sql);
	//
	$song_sql =  "DELETE FROM playlistsongs WHERE playlist_id = '{$playlist_id}' ";
	$song_query = mysqli_query($con, $song_sql);

} else {
	echo "The playlist ID is invalid";
}
?>
