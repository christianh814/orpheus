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
