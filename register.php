<?php
require_once("includes/classes/Account.php");
//**//
$account = new Account();
//**//
require_once("includes/handlers/register_handler.php");
require_once("includes/handlers/login_handler.php");
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
				<?php echo $account->getError("Username must be between 5 and 25 characters"); ?>
				<label for="username">Username</label>
				<input id="username" name="username" type="text" placeholder="Username" required>
			</p>
			<p>
				<?php echo $account->getError("Firstname must be between 2 and 25 characters"); ?>
				<label for="firstName">First Name</label>
				<input id="firstName" name="firstName" type="text" placeholder="First Name" required>
			</p>
			<p>
				<?php echo $account->getError("Lastname must be between 2 and 25 characters"); ?>
				<label for="lastName">Last Name</label>
				<input id="lastName" name="lastName" type="text" placeholder="Last Name" required>
			</p>
			<p>
				<?php echo $account->getError("Email not in the right format"); ?>
				<label for="email">E-Mail</label>
				<input id="email" name="email" type="email" placeholder="E-Mail" required>
			</p>
			<p>
				<?php echo $account->getError("Emails do not match!"); ?>
				<label for="email2">Confirm E-Mail</label>
				<input id="email2" name="email2" type="email" placeholder="Confirm E-Mail" required>
			</p>
			<p>
				<?php echo $account->getError("Password does not meet requirements"); ?>
				<?php echo $account->getError("Password must be between 5 and 50 characters"); ?>
				<label for="password">Password</label>
				<input id="password" name="password" type="password" placeholder="Password" required>
			</p>
			<p>
				<?php echo $account->getError("Passwords do not match!"); ?>
				<label for="password2">Confirm Password</label>
				<input id="password2" name="password2" type="password" placeholder="Password" required>
			</p>
			<button type="submit" name="registerButton">SIGN UP</button>
		</form>
	</div>
</body>
</html>
