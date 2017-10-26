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
<div id="mainContainer">

	<div id="topContainer">

		<div id="navBarContainer">
			<nav class="navBar">
				<a href="index.php" class="logo" style="text-decoration: none;">
					<img src="assets/images/icons/orpheus-logo.png"></img>
					&nbsp;&nbsp;&nbsp;<i class="navItemLink">orpheus</i>
				</a>

				<div class="group">
					<div class="navItem">
						<a href="search.php" class="navItemLink">Search
							<img src="assets/images/icons/search.png" class="icon" alt="Search"></img>
						</a>
					</div>
				</div>

				<div class="group">
					<div class="navItem">
						<a href="browse.php" class="navItemLink">Browse</a>
					</div>
					<div class="navItem">
						<a href="yourmusic.php" class="navItemLink">Your Music</a>
					</div>
					<div class="navItem">
						<a href="profile.php" class="navItemLink"><?php echo $user_logged_in ?></a>
					</div>
				</div>

			</nav>
		</div> <!-- navBar container -->

	</div> <!-- topContainer contains both left hand nav and right "main" page -->

	<div id="nowPlayingBarContainer">
		<div id="nowPlayingBar">
			
			<div id="nowPlayingLeft">
				<div class="content">
					<span class="albumLink">
						<img src="http://placehold.it/57x57" class="albumArtwork"></img>
					</span>

					<div class="trackInfo">
						<span class="trackName">
							Happy Birthday
						</span>

						<span class="artistName">
							Christian Hernandez
						</span>
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
</div> <!--  mainContainer -->
</body>
</html>
