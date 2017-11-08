<?php
require_once("includes/included_files.php");
?>
<div class="playlistsContainer">
	<div class="gridViewContainer">
		<h2>Playlists</h2>

		<div class="buttonItems">
			<button class="button green" onclick="createPlaylist()">New Playlist</button>
		</div>

		<?php
			$username = $userLoggedIn->getUsername();
			$playlists_sql = "SELECT * FROM playlists WHERE owner = '{$username}' ";
			$playlists_query = mysqli_query($con, $playlists_sql);
	
			if(mysqli_num_rows($playlists_query) == 0) {
				echo "<span class='noResults'>No playlists found</span>";
			}
			
			while ($row = mysqli_fetch_array($playlists_query)) {
				$playlist = new Playlist($con, $row);
				echo "
					<div class='gridViewItem' role='link' tabindex='0' onclick='openPage(\"playlist.php?id=" . $playlist->getId() . "\")'>
						<div class='playlistImage'>
							<img src='assets/images/icons/playlist.png'></img>
						</div>
						<div class='gridViewInfo'>" . 
							$playlist->getName() . "
						</div>
					</div>
					";
			}
		?>

	</div>
</div>
