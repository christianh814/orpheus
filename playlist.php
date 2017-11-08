<?php
require_once("includes/included_files.php");
?>
<!-- Site Content START -->

<?php
	if(isset($_GET['id'])) {
		$playlist_id = mysqli_real_escape_string($con, $_GET['id']);
	} else {
		header("Location: index.php");
	}

	$playlist = new Playlist($con, $playlist_id);
	$owner = new User($con, $playlist->getOwner());
?>
<div class="entityInfo">

	<div class="leftSection">
		<div class="playlistImage">
			<img src="assets/images/icons/playlist.png"></img>
		</div>
	</div> <!--leftSection -->

	<div class="rightSection">
		<h2><?php echo $playlist->getName(); ?></h2>
		<p>By <?php echo $playlist->getOwner(); ?></p>
		<p><?php echo $playlist->getNumberOfSongs(); ?> songs</p>
		<button class="button" onclick="deletePlaylist('<?php echo $playlist_id ?>')">Delete Playlist</button>
	</div> <!--rightSection -->

</div><!-- entityInfo -->


<div class="tracklistContainer">
	<ul class="tracklist">
		<?php
			$song_id_array = $playlist->getSongIds();
			$i = 1;
			foreach ($song_id_array as $song_id) {
				$playlist_song = new Song($con, $song_id);
				$song_artist = $playlist_song->getArtist();

				echo "<li class='tracklistRow'>
						<div class='trackCount'>
							<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack( \"" . $playlist_song->getId() . "\", tempPlayList, true)'></img>
							<span class='trackNumber'>{$i}</span>
						</div>
						
						<div class='trackInfo'>
							<span class='trackName'>{$playlist_song->getTitle()}</span>
							<span class='artistName'>{$song_artist->getName()}</span>
						</div>

						<div class='trackOptions'>
							<img class='optionsButton' src='assets/images/icons/more.png'></img>
						</div>

						<div class='trackDuration'>
							<span class='duration'>{$playlist_song->getDuration()}</span>
						</div>
					</li>";
				$i++;
			}
		?>
		<script>
			var tempSongIds = '<?php echo json_encode($song_id_array); ?>';
			tempPlayList = JSON.parse(tempSongIds);
		</script>
	</ul><!-- tracklist -->
</div><!-- tracklistContainer -->

<!-- Site Content END -->
