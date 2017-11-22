<?php
require_once("includes/included_files.php");

// We will show the default page if the fb_session isn't set. We will assume they used email registration
if(!isset($_SESSION['fb_access_token'])) {
?>

<div class="userDetails">
	<div class="container borderBottom">
		<h2>EMAIL</h2>
		<input type="text" class="email" name="email" placeholder="Email Address..." value="<?php echo $userLoggedIn->getEmail(); ?>">
		<span class="message"></span>
		<button class="button" onclick="updateEmail('email')">SAVE</button>
	</div>

	<div class="container">
		<h2>PASSWORD</h2>
		<input type="password" class="oldPassword" name="oldPassword" placeholder="Current password...">
		<input type="password" class="newPassword1" name="newPassword1" placeholder="New password...">
		<input type="password" class="newPassword2" name="newPassword2" placeholder="New password again...">
		<span class="message"></span>
		<button class="button" onclick="updatePassword('oldPassword', 'newPassword1', 'newPassword2')">SAVE</button>
	</div>
</div>

<?php
} else {
// FB details
?>
<div class="userDetails">
	<div class="container borderBottom">
		<h2>USER DETAILS</h2>
		<input type="text" class="email" name="email" placeholder="Email Address..." value="<?php echo $userLoggedIn->getEmail(); ?>" readonly="readonly">
		<span class="message"></span>
		<!-- <button class="button" onclick="updateEmail('email')">SAVE</button> -->
	</div>

	<div class="container">
		<h2>USERNAME</h2>
		<input type="text" name="username" value="<?php echo $userLoggedIn->getUsername(); ?>" readonly="readonly">
		<span class="message"></span>
		<!-- <button class="button" onclick="updatePassword('oldPassword', 'newPassword1', 'newPassword2')">SAVE</button> -->
	</div>
</div>
<?php
}
?>
