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
?>
<div class="entityInfo">

	<div class="leftSection">
		<img src="<?php echo $album->getArtworkPath(); ?>"></img>
	</div> <!--leftSection -->

	<div class="rightSection">
		<h2><?php echo $album->getTitle(); ?></h2>
		<p>By <?php echo $artist->getName(); ?></p>
		<p><?php echo $album->getNumberOfSongs(); ?> songs</p>
	</div> <!--rightSection -->

</div><!-- entityInfo -->


<div class="tracklistContainer">
	<ul class="tracklist">
		<?php
			$song_id_array = $album->getSongIds();
			$i = 1;
			foreach ($song_id_array as $song_id) {
				$album_song = new Song($con, $song_id);
				$album_artist = $album_song->getArtist();

				echo "<li class='tracklistRow'>
						<div class='trackCount'>
							<img class='play' src='assets/images/icons/play-white.png'></img>
							<span class='trackNumber'>{$i}</span>
						</div>
						
						<div class='trackInfo'>
							<span class='trackName'>{$album_song->getTitle()}</span>
							<span class='artistName'>{$album_artist->getName()}</span>
						</div>

						<div class='trackOptions'>
							<img class='optionsButton' src='assets/images/icons/more.png'></img>
						</div>

						<div class='trackDuration'>
							<span class='duration'>{$album_song->getDuration()}</span>
						</div>
					</li>";
				$i++;
			}
		?>
	</ul><!-- tracklist -->
</div><!-- tracklistContainer -->

<!-- Site Content END -->
<?php require_once("includes/footer.php"); ?>
