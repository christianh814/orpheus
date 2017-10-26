<?php require_once("includes/header.php") ?>
<!-- Site Content START -->

<h1 class="pageHeadingBig">You Might Also Like</h1>

<div class="gridViewContainer">
	<?php
		$album_sql = "SELECT * FROM albums ORDER BY RAND() LIMIT 10 ";
		$album_query = mysqli_query($con, $album_sql);
		
		while ($row = mysqli_fetch_array($album_query)) {
			echo "
				<div class='gridViewItem'>
					<a href='album.php?id=" . $row['id'] . "'>
						<img src='" . $row['artwork_path'] . "'></img>
						<div class='gridViewInfo'>" . 
							$row['title'] . "
						</div>
					</a>
				</div>
				";
		}
	?>
</div> <!-- gridViewContainer -->

<!-- Site Content END -->
<?php require_once("includes/footer.php"); ?>
