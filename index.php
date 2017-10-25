<?php
require_once("includes/config.php");
//
if (isset($_SESSION['user_logged_in'])) {
	$user_logged_in = $_SESSION['user_logged_in'];
} else {
	header("Location: register.php");
}
?>
<html>
<head>
	<title>Welcome to Orpheus!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
	<div id="nowPlayingBarContainer">
		<div id="nowPlayingBar">
			
			<div id="nowPlayingLeft">
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

						<button class="controlButton play" title="Play Button" alt="play">
							<img src="assets/images/icons/play.png"></img>
						</button>

						<button class="controlButton pause" title="Pause Button" alt="pause" style="display:none;">
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
			</div> <!-- now playing right -->

		</div> <!-- now playing bar-->

	</div> <!-- now playing bar container -->
</body>
</html>
