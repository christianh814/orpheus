<?php require_once("includes/header.php") ?>
<!-- Site Content START -->

<?php
	if(isset($_GET['id'])) {
		$album_id = mysqli_real_escape_string($con, $_GET['id']);
	} else {
		header("Location: index.php");
	}

	$album = new Album($con, $album_id);
	$artist = $album->getArtist();
	echo $album->getTitle();
	echo "<br>";
	echo $artist->getName();

?>

<!-- Site Content END -->
<?php require_once("includes/footer.php"); ?>
