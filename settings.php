<?php
require_once("includes/included_files.php");
?>
<div class="entityInfo">
	<div class="centerSection">
		<div class="userInfo">
			<h1><?php echo $userLoggedIn->getFirstAndLastName() ?></h1>
		</div>
	</div>

	<div class="buttonItems">
		<button class="button" onclick="openPage('update_details.php')">USER DETAILS</button>
		<button class="button" onclick="logout()">LOGOUT</button>
	</div>
</div>
