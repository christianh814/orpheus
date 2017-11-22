<?php
require_once("includes/config.php");
require_once("includes/vendor/autoload.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");
//**//
$account = new Account($con);
//**//
require_once("includes/handlers/register_handler.php");
require_once("includes/handlers/login_handler.php");
//
function getInputValue($name) {
	if(isset($_POST[$name])) {
		echo $_POST[$name];
	}
}
?>
<html>
<head>
	<title>Welcome to Orpheus!</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>
<!-- When the page loads; automactially hide the register form -->
	<?php
		if(isset($_POST['registerButton'])) {
			echo '<script>
				$(document).ready(function() {
					$("#loginForm").hide();
					$("#registerForm").show();
				});
			</script>';
		} else {
			echo '<script>
				$(document).ready(function() {
					$("#loginForm").show();
					$("#registerForm").hide();
				});
			</script>';
		}
	?>
<div id="background">
	<div id="loginContainer">
		<div id="inputContainer">
			<!-- Login Form -->
			<form id="loginForm" action="register.php" method="POST">
				<h2>Login to your account</h2>
				<p>
					<?php echo $account->getError(Constants::$login_error); ?>
					<label for="loginUsername">Username</label>
					<input id="loginUsername" name="loginUsername" type="text" placeholder="e.g. johnDoe" value="<?php getInputValue("loginUsername"); ?>" required>
				</p>
				<p>
					<label for="loginPassword">Password</label>
					<input id="loginPassword" name="loginPassword" type="password" placeholder="Your Password" required>
				</p>
				<button type="submit" name="loginButton">LOGIN</button>



				<div class="hasAccountText">
					<span id="hideLogin">Don't have an account yet? Signup here!</span>
				</div>

				<?php
				/*
				<span id="hideLogin">
					<a href="<?php echo htmlspecialchars($loginUrl); ?>" style="text-decoration: none">
						<button class="loginBtn loginBtn--facebook"> Login with Facebook </button>
					</a>
				</span>
				*/
				?>

			</form>
	
			<!-- Register Form -->
			<form id="registerForm" action="register.php" method="POST">
				<h2>Create your account</h2>
				<p>
					<?php echo $account->getError(Constants::$username_length); ?>
					<?php echo $account->getError(Constants::$username_taken); ?>
					<label for="username">Username</label>
					<input id="username" name="username" type="text" placeholder="e.g. johnDoe" value="<?php getInputValue("username"); ?>" required>
				</p>
				<p>
					<?php echo $account->getError(Constants::$firstname_length); ?>
					<label for="firstName">First Name</label>
					<input id="firstName" name="firstName" type="text" placeholder="e.g. John" value="<?php getInputValue("firstName"); ?>" required>
				</p>
				<p>
					<?php echo $account->getError(Constants::$lastname_length); ?>
					<label for="lastName">Last Name</label>
					<input id="lastName" name="lastName" type="text" placeholder="e.g. Doe" value="<?php getInputValue("lastName"); ?>" required>
				</p>
				<p>
					<?php echo $account->getError(Constants::$email_is_not_valid); ?>
					<?php echo $account->getError(Constants::$email_taken); ?>
					<label for="email">E-Mail</label>
					<input id="email" name="email" type="email" placeholder="e.g. johnDoe@example.com" value="<?php getInputValue("email"); ?>" required>
				</p>
				<p>
					<?php echo $account->getError(Constants::$email_does_not_match); ?>
					<label for="email2">Confirm E-Mail</label>
					<input id="email2" name="email2" type="email" placeholder="e.g. johnDoe@example.com" value="<?php getInputValue("email2"); ?>" required>
				</p>
				<p>
					<?php echo $account->getError(Constants::$passwords_do_not_meet_req); ?>
					<?php echo $account->getError(Constants::$password_length); ?>
					<label for="password">Password</label>
					<input id="password" name="password" type="password" placeholder="Your Password" required>
				</p>
				<p>
					<?php echo $account->getError(Constants::$passwords_do_not_match); ?>
					<label for="password2">Confirm Password</label>
					<input id="password2" name="password2" type="password" placeholder="Your Password again" required>
				</p>
				<button type="submit" name="registerButton">SIGN UP</button>

				<div class="hasAccountText">
					<span id="hideRegister">Already have an account? Login here!</span>
				</div>

			</form>


			<?php
			//
			$fb = new Facebook\Facebook([
				'app_id' => getenv("FB_APP_ID"),
				'app_secret' => getenv("FB_APP_SECRET"),
				'default_graph_version' => 'v2.2'
			]);
			$helper = $fb->getRedirectLoginHelper();
			$permissions = ['email']; // Optional permissions
			$loginUrl = $helper->getLoginUrl('https://' . $_SERVER['SERVER_NAME'] . '/fb-callback.php', $permissions);
			echo "<a href=" .  htmlspecialchars($loginUrl) . " style='text-decoration: none'>
				<button class='loginBtn loginBtn--facebook'> Proceed with Facebook </button>
			</a>";
			?>
		</div><!-- inputContainer -->

		<div id="loginText">
			<h1>Get great music, right now</h1>
			<h2>Listen to loads of songs for free.</h2>
				<ul>
					<li>Discover music you'll fall in love with</li>
					<li>Create your own playlists</li>
					<li>Follow artists to keep up to date</li>
				</ul>
		</div><!-- loginText -->

	</div><!-- login contianer> -->
</div> <!-- background id -->
</body>
</html>
