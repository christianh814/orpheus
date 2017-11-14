<?php
//require_once("includes/header.php");
require_once("includes/included_files.php");
?>
<!-- Site Content START -->

<h1 class="pageHeadingBig">You Might Also Like</h1>

<div class="gridViewContainer">
	<?php
		$album_sql = "SELECT * FROM albums ORDER BY RAND() LIMIT 10 ";
		$album_query = mysqli_query($con, $album_sql);
		
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
<script>
  $.growl({ title: "Music", message: "Music provided by <a href='https://www.bensound.com/royalty-free-music' target='_blank'>Bensound</a>" });
</script>

<!-- Site Content END -->
<?php
//require_once("includes/footer.php");
?>
