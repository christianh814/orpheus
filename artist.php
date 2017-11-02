<?php
require_once("includes/included_files.php");
//
if(isset($_GET['id'])) {
	$artist_id = mysqli_real_escape_string($con, $_GET['id']);
} else {
	// For now, just redirect them if it's not found
	// TODO: "cannot find this artist" message
	header("Location: index.php");
}
//
$artist = new Artist($con, $artist_id);
?>

<div class="entityInfo borderBottom">
	<div class="centerSection">
		<div class="artistInfo">
			<h1 class="artistName">
				<?php echo $artist->getName();?>
			</h1>
			<div class="headerButtons">
				<button class="button green" onclick="playFirstSong()">Play</button>
			</div>
		</div>
	</div>
</div>
<!-- artist songs below -->
<div class="tracklistContainer borderBottom">
	<h2>Popluar Songs</h2>
	<ul class="tracklist">
		<?php
			$song_id_array = $artist->getSongIds();
			$i = 1;
			foreach ($song_id_array as $song_id) {
				$album_song = new Song($con, $song_id);
				$album_artist = $album_song->getArtist();

				echo "<li class='tracklistRow'>
						<div class='trackCount'>
							<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack( \"" . $album_song->getId() . "\", tempPlayList, true)'></img>
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
		<script>
			var tempSongIds = '<?php echo json_encode($song_id_array); ?>';
			tempPlayList = JSON.parse(tempSongIds);
		</script>
	</ul><!-- tracklist -->
</div><!-- tracklistContainer -->

<!-- artist albums below -->
<div class="gridViewContainer">
	<h2>Albums</h2>
	<?php
		$album_sql = "SELECT * FROM albums WHERE artist = '{$artist_id}' ";
		$album_query = mysqli_query($con, $album_sql);
		
		while ($row = mysqli_fetch_array($album_query)) {
			echo "
				<div class='gridViewItem'>
					<span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
						<img src='" . $row['artwork_path'] . "'></img>
						<div class='gridViewInfo'>" . 
							$row['title'] . "
						</div>
					</span>
				</div>
				";
		}
	?>
</div> <!-- gridViewContainer -->
