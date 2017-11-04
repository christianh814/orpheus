<?php
require_once("includes/included_files.php");
//
if(isset($_GET['term'])) {
	$term = urldecode(mysqli_real_escape_string($con, $_GET['term']));
} else {
	$term = "";
}
?>
<div class="searchContainer">
	<h4>Search for an artist, album, or a song</h4>
	<input type="text" class="searchInput" value="<?php echo $term;?>" placeholder="Start typing..." onfocus="var val=this.value; this.value=''; this.value= val;"></input>
</div>
<script>
	$(".searchInput").focus();
	$(function() {
		$(".searchInput").keyup(function() {
			clearTimeout(timer);

			timer = setTimeout(function() {
				var val = $(".searchInput").val();
				openPage("search.php?term=" + val);
			}, 2000);
		});
	});
</script>
<!-- If no search was provided -->
<?php if ($term == "") exit(); ?>

<!-- artist songs below -->
<div class="tracklistContainer borderBottom">
	<h2>Songs</h2>
	<ul class="tracklist">
		<?php
			$songs_sql = "SELECT id FROM songs WHERE title LIKE '{$term}%' LIMIT 10 ";
			$songs_query = mysqli_query($con, $songs_sql);

			if(mysqli_num_rows($songs_query) == 0) {
				echo "
					<span class='noResults'>
						No songs found matching "
						. $term .
					"</span>";
			}


			$song_id_array = array();
			$i = 1;
			while ($row = mysqli_fetch_array($songs_query)) {
				array_push($song_id_array, $row['id']);
				//
				$album_song = new Song($con, $row['id']);
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
<!-- artist -->
<div class="artistContainer borderBottom">
	<h2>Artist</h2>
	<?php
		$artists_sql = "SELECT id FROM artists WHERE name LIKE '{$term}%' LIMIT 10 ";
		$artists_query = mysqli_query($con, $artists_sql);
		if(mysqli_num_rows($artists_query) == 0) {
			echo "
				<span class='noResults'>
					No artists found matching "
					. $term .
				"</span>";
		}

		while($row = mysqli_fetch_array($artists_query)) {
			$artist_found = new Artist($con, $row['id']);

			echo "
				<div class='searchResultRow'>
					<div class='artistName'>
						<span role='link' tabindex='0' onclick='openPage(\"artist.php?id={$artist_found->getId()}\")'>
							{$artist_found->getName()}
						</span>
					</div>
				</div>
			";
		}
	?>
</div> <!-- artistContainer -->

<!-- albums -->
<div class="gridViewContainer">
	<h2>Albums</h2>
	<?php
		$album_sql = "SELECT * FROM albums WHERE title LIKE '{$term}%' LIMIT 10 ";
		$album_query = mysqli_query($con, $album_sql);

		if(mysqli_num_rows($album_query) == 0) {
			echo "
				<span class='noResults'>
					No albums found matching "
					. $term .
				"</span>";
		}
		
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
