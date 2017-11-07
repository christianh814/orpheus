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
				echo "
					<div class='gridViewItem'>
						<div class='playlistImage'>
							<img src='assets/images/icons/playlist.png'></img>
						</div>
						<div class='gridViewInfo'>" . 
							$row['name'] . "
						</div>
					</div>
					";
			}
		?>

	</div>
</div>
