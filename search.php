<?php
require_once("includes/included_files.php");
//
if(isset($_GET['term'])) {
	$term = urldecode(mysqli_real_escape_string($con, $_GET['term']));
} else {
	$term = "";
}
?>
<div class="searchContainer">
	<h4>Search for an artist, album, or a song</h4>
	<input type="text" class="searchInput" value="<?php echo $term;?>" placeholder="Start typing..." onfocus="this.value = this.value"></input>
</div>
<script>
	$(".searchInput").focus();
	$(function() {
		var timer;
		$(".searchInput").keyup(function() {
			clearTimeout(timer);

			timer = setTimeout(function() {
				var val = $(".searchInput").val();
				openPage("search.php?term=" + val);
			}, 2000);
		});
	});
</script>
