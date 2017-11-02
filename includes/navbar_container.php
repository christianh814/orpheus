<div id="navBarContainer">
	<nav class="navBar">
		<span role="link" tabindex="0" style="text-decoration: none;" onclick="openPage('index.php')" class="logo">
			<img src="assets/images/icons/orpheus-logo.png"></img>
			&nbsp;&nbsp;&nbsp;<i class="navItemLink">orpheus</i>
		</span>

		<div class="group">
			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('search.php')" class="navItemLink">Search
					<img src="assets/images/icons/search.png" class="icon" alt="Search"></img>
				</span>
			</div>
		</div>

		<div class="group">
			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink">Browse</span>
			</div>
			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('yourmusic.php')"  class="navItemLink">Your Music</span>
			</div>
			<div class="navItem">
				<span role="link" tabindex="0" onclick="openPage('profile.php')" class="navItemLink"><?php echo $user_logged_in ?></span>
			</div>
		</div>

	</nav>
</div> <!-- navBar container -->
