<?php
	// Generate a playlist at random
	$song_sql = "SELECT id FROM songs ORDER BY RAND() LIMIT 10 ";
	$song_query = mysqli_query($con, $song_sql);

	$result_array = array();

	while ($row = mysqli_fetch_array($song_query)) {
		array_push($result_array, $row['id']);
	}

	$json_array = json_encode($result_array);
?>
<script>

	// When the page loads; grab the random playlist
	$(document).ready(function() {
		currentPlayList = <?php echo $json_array; ?>;
		audioElement = new Audio();
		setTrack(currentPlayList[0], currentPlayList, false);
	});

	// This function sets the playlist
	function setTrack(trackId, newPlayList, play) {
		// This AJAX call sends to the handler basically sends "get_song_json.php?songId=" whatever the "trackId" is and gets it back as "data"
		$.post("includes/handlers/ajax/get_song_json.php", { songId: trackId }, function(data) {
			// parses the returned JSON array so you can use it as "varname.element"
			var track = JSON.parse(data);

			$(".trackName span").text(track.title);

			$.post("includes/handlers/ajax/get_artist_json.php", { artistId: track.artist }, function(data) {
				var artist = JSON.parse(data);
				$(".artistName span").text(artist.name);
			});

			$.post("includes/handlers/ajax/get_album_json.php", { albumId: track.album }, function(data) {
				var album = JSON.parse(data);
				$(".albumLink img").attr("src", album.artwork_path);
			});

			audioElement.setTrack(track.path);
			// This autoplays it regaurdless of the "true/false" set...this may be just for testing
			audioElement.play();
		});

		if(play) {
			audioElement.play();
		}
	}

	function playSong() {
		$(".controlButton.play").hide();
		$(".controlButton.pause").show();
		audioElement.play();
	}

	function pauseSong() {
		$(".controlButton.play").show();
		$(".controlButton.pause").hide();
		audioElement.pause();
	}

</script>

<div id="nowPlayingBarContainer">
	<div id="nowPlayingBar">
		
		<div id="nowPlayingLeft">
			<div class="content">
				<span class="albumLink">
					<img src="" class="albumArtwork"></img>
				</span>

				<div class="trackInfo">
					<span class="trackName"><span></span></span>

					<span class="artistName"><span></span></span>
				</div><!-- track info -->
			</div>
		</div> <!-- now playing left -->

		<div id="nowPlayingCenter">
			<div class="content playerControls">
				<div class="buttons">
					<button class="controlButton shuffle" title="Shuffle Button" alt="shuffle">
						<img src="assets/images/icons/shuffle.png"></img>
					</button>

					<button class="controlButton previous" title="Previous Button" alt="previous">
						<img src="assets/images/icons/previous.png"></img>
					</button>

					<button class="controlButton play" title="Play Button" alt="play" onclick="playSong()">
						<img src="assets/images/icons/play.png"></img>
					</button>

					<button class="controlButton pause" title="Pause Button" alt="pause" style="display:none;" onclick="pauseSong()">
						<img src="assets/images/icons/pause.png"></img>
					</button>

					<button class="controlButton next" title="Next Button" alt="next">
						<img src="assets/images/icons/next.png"></img>
					</button>

					<button class="controlButton repeat" title="Repeat Button" alt="repeat">
						<img src="assets/images/icons/repeat.png"></img>
					</button>

				</div><!-- buttons -->
				
				<div class="playbackBar">
					<span class="progressTime current">0.00</span>

					<div class="progressBar">
						<div class="progressBarBg">
							<div class="progress"></div>
						</div> <!-- PB bg -->
					</div><!-- progress bar-->

					<span class="progressTime remaining">0.00</span>
				</div><!-- playback bar -->

			</div>
		</div> <!-- now playing center -->

		<div id="nowPlayingRight">
			<div class="volumeBar">
				<button class="controlButton volume" title="Volume Button" alt="volume">
					<img src="assets/images/icons/volume.png"></img>
				</button>

				<div class="progressBar">
					<div class="progressBarBg">
						<div class="progress"></div>
					</div> <!-- PB bg -->
				</div><!-- progress bar-->

			</div>
		</div> <!-- now playing right -->

	</div> <!-- now playing bar-->

</div> <!-- now playing bar container -->
