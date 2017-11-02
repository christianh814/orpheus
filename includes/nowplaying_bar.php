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
		var newPlayList = <?php echo $json_array; ?>;
		audioElement = new Audio();
		setTrack(newPlayList[0], newPlayList, false);

		// Set volume bar to 1
		updateVolumeProgressBar(audioElement.audio);

		// Prevent mouse highliting anything in the control bar
		$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
			e.preventDefault();
		});

		// Make the progressbar clickable/dragable
		$(".playbackBar .progressBar").mousedown(function() {
			mouseDown = true;
		});

		$(".playbackBar .progressBar").mousemove(function(e) {
			if(mouseDown) {
				// set time of song depending on pos of mouse
				timeFromOffset(e, this);
			}
		});

		$(".playbackBar .progressBar").mouseup(function(e) {
			timeFromOffset(e, this);
		});

		// Make the volumebar clickable/dragable
		$(".volumeBar .progressBar").mousedown(function() {
			mouseDown = true;
		});

		$(".volumeBar .progressBar").mousemove(function(e) {
			if(mouseDown) {
				var percentage = e.offsetX / $(this).width();
				if (percentage >= 0 && percentage <= 1) {
					audioElement.audio.volume = percentage;
				}
			}
		});

		$(".volumeBar .progressBar").mouseup(function(e) {
			var percentage = e.offsetX / $(this).width();
			if (percentage >= 0 && percentage <= 1) {
				audioElement.audio.volume = percentage;
			}
		});

		$(document).mouseup(function() {
			mouseDown = false;
		});
	});

	function timeFromOffset(mouse, progressBar) {
		var percentage = (mouse.offsetX / $(progressBar).width()) * 100;
		var seconds = audioElement.audio.duration * (percentage / 100);
		audioElement.setTime(seconds);

	}

	function prevSong() {
		if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
			audioElement.setTime(0);
		} else {
			currentIndex = currentIndex - 1;
			setTrack(currentPlayList[currentIndex], currentPlayList, true);
		}
	}

	function nextSong() {
		if(repeat) {
			audioElement.setTime(0);
			playSong();
			return;
		}

		if(currentIndex == currentPlayList.length - 1) {
			currentIndex = 0;
		} else {
			currentIndex++;
		}
		var trackToPlay = shuffle ? shufflePlayList[currentIndex] : currentPlayList[currentIndex];
		setTrack(trackToPlay, currentPlayList, true);
	}

	function setRepeat() {
		repeat = !repeat;

		var imageName = repeat ? "repeat-active.png" : "repeat.png";
		$(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
	}

	function setMute() {
		audioElement.audio.muted = !audioElement.audio.muted;

		var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
		$(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
	}

	function setShuffle() {
		// This just sets the boolean to the gegenteil of what it is
		shuffle = !shuffle;

		// this changes the image
		var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
		$(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

		// This actually does the shuffle
		if (shuffle) {
			shuffleArray(shufflePlayList);
			currentIndex = shufflePlayList.indexOf(audioElement.currentlyPlaying.id);
		} else {
			//shuffle has been turned off. go back to regular playlist
			currentIndex = currentPlayList.indexOf(audioElement.currentlyPlaying.id);
		}

	}

	function shuffleArray(a) {
		var j, x, i;
		for (i = a.length - 1; i > 0; i--) {
			j = Math.floor(Math.random() * (i + 1));
			x = a[i];
			a[i] = a[j];
			a[j] = x;
		}
	}

	// This function sets the playlist
	function setTrack(trackId, newPlayList, play) {
		if (newPlayList != currentPlayList) {
			currentPlayList = newPlayList;
			shufflePlayList = currentPlayList.slice();
			shuffleArray(shufflePlayList);
		}

		// Set index so you know where to skip to
		if (shuffle) {
			currentIndex = shufflePlayList.indexOf(trackId);
		} else {
			currentIndex = currentPlayList.indexOf(trackId);
		}
		pauseSong();

		// This AJAX call sends to the handler basically sends "get_song_json.php?songId=" whatever the "trackId" is and gets it back as "data"
		$.post("includes/handlers/ajax/get_song_json.php", { songId: trackId }, function(data) {
			// parses the returned JSON array so you can use it as "varname.element"
			var track = JSON.parse(data);


			$(".trackName span").text(track.title);

			$.post("includes/handlers/ajax/get_artist_json.php", { artistId: track.artist }, function(data) {
				var artist = JSON.parse(data);
				$(".artistName span").text(artist.name);
				$(".artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
			});

			$.post("includes/handlers/ajax/get_album_json.php", { albumId: track.album }, function(data) {
				var album = JSON.parse(data);
				$(".albumLink img").attr("src", album.artwork_path);
				$(".albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
				$(".trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");
			});

			audioElement.setTrack(track);

			// Play track if it's set to true
			if(play) {
				playSong();
			}
		});
	}

	function playSong() {
		// Update song count if current time is 0.00
		if(audioElement.audio.currentTime == 0) {
			$.post("includes/handlers/ajax/update_plays.php", { songId: audioElement.currentlyPlaying.id });
		}

		//
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
					<img role="link" tabindex="0" src="" class="albumArtwork"></img>
				</span>

				<div class="trackInfo">
					<span class="trackName">
						<span role="link" tabindex="0">
						</span>
					</span>

					<span class="artistName">
						<span role="link" tabindex="0">
						</span>
					</span>

				</div><!-- track info -->
			</div>
		</div> <!-- now playing left -->

		<div id="nowPlayingCenter">
			<div class="content playerControls">
				<div class="buttons">
					<button class="controlButton shuffle" title="Shuffle Button" alt="shuffle" onclick="setShuffle()">
						<img src="assets/images/icons/shuffle.png"></img>
					</button>

					<button class="controlButton previous" title="Previous Button" alt="previous" onclick="prevSong()">
						<img src="assets/images/icons/previous.png"></img>
					</button>

					<button class="controlButton play" title="Play Button" alt="play" onclick="playSong()">
						<img src="assets/images/icons/play.png"></img>
					</button>

					<button class="controlButton pause" title="Pause Button" alt="pause" style="display:none;" onclick="pauseSong()">
						<img src="assets/images/icons/pause.png"></img>
					</button>

					<button class="controlButton next" title="Next Button" alt="next" onclick="nextSong();">
						<img src="assets/images/icons/next.png"></img>
					</button>

					<button class="controlButton repeat" title="Repeat Button" alt="repeat" onclick="setRepeat()">
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
				<button class="controlButton volume" title="Volume Button" alt="volume" onclick="setMute()">
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
