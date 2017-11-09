<?php
require_once("../../config.php");

if(isset($_POST["song_id"]) && isset($_POST["playlist_id"])) {
	$song_id = $_POST["song_id"];
	$playlist_id = $_POST["playlist_id"];
	//
	//$sql_orderid = "SELECT MAX(playlist_order) + 1 as playlist_order FROM playlistsongs WHERE playlist_id = '{$playlist_id}' ";
	$sql_orderid = "SELECT IFNULL(MAX(playlist_order) + 1, 1) as playlist_order FROM playlistsongs WHERE playlist_id = '{$playlist_id}' ";
	$query_orderid = mysqli_query($con, $sql_orderid);
	$row = mysqli_fetch_array($query_orderid);
	$order = $row['playlist_order'];

	/* We don't need this part anymore since the SQL took care of the null issue
	if ($order == null) {
		$order = 1;
	}
	*/

	$sql =  "INSERT INTO playlistsongs (song_id, playlist_id, playlist_order) ";
	$sql .= "VALUES ('{$song_id}', '{$playlist_id}', '{$order}') ";
	$query = mysqli_query($con, $sql);

} else {
	echo "The playlist id or song id is invalid";
}
?>
