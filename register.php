<?php
require_once("includes/config.php");
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
</head>
<body>
	<div id="inputContainer">
		<!-- Login Form -->
		<form id="loginForm" action="register.php" method="POST">
			<h2>Login to your account</h2>
			<p>
				<?php echo $account->getError(Constants::$login_error); ?>
				<label for="loginUsername">Username</label>
				<input id="loginUsername" name="loginUsername" type="text" placeholder="Username" required>
			</p>
			<p>
				<label for="loginPassword">Password</label>
				<input id="loginPassword" name="loginPassword" type="password" placeholder="Password" required>
			</p>
			<button type="submit" name="loginButton">LOGIN</button>
		</form>

		<!-- Register Form -->
		<form id="registerForm" action="register.php" method="POST">
			<h2>Create your account</h2>
			<p>
				<?php echo $account->getError(Constants::$username_length); ?>
				<?php echo $account->getError(Constants::$username_taken); ?>
				<label for="username">Username</label>
				<input id="username" name="username" type="text" placeholder="Username" value="<?php getInputValue("username"); ?>" required>
			</p>
			<p>
				<?php echo $account->getError(Constants::$firstname_length); ?>
				<label for="firstName">First Name</label>
				<input id="firstName" name="firstName" type="text" placeholder="First Name" value="<?php getInputValue("firstName"); ?>" required>
			</p>
			<p>
				<?php echo $account->getError(Constants::$lastname_length); ?>
				<label for="lastName">Last Name</label>
				<input id="lastName" name="lastName" type="text" placeholder="Last Name" value="<?php getInputValue("lastName"); ?>" required>
			</p>
			<p>
				<?php echo $account->getError(Constants::$email_is_not_valid); ?>
				<?php echo $account->getError(Constants::$email_taken); ?>
				<label for="email">E-Mail</label>
				<input id="email" name="email" type="email" placeholder="E-Mail" value="<?php getInputValue("email"); ?>" required>
			</p>
			<p>
				<?php echo $account->getError(Constants::$email_does_not_match); ?>
				<label for="email2">Confirm E-Mail</label>
				<input id="email2" name="email2" type="email" placeholder="Confirm E-Mail" value="<?php getInputValue("email2"); ?>" required>
			</p>
			<p>
				<?php echo $account->getError(Constants::$passwords_do_not_meet_req); ?>
				<?php echo $account->getError(Constants::$password_length); ?>
				<label for="password">Password</label>
				<input id="password" name="password" type="password" placeholder="Password" required>
			</p>
			<p>
				<?php echo $account->getError(Constants::$passwords_do_not_match); ?>
				<label for="password2">Confirm Password</label>
				<input id="password2" name="password2" type="password" placeholder="Password" required>
			</p>
			<button type="submit" name="registerButton">SIGN UP</button>
		</form>
	</div>
</body>
</html>
