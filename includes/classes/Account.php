<?php
class Account {
	// Private vars for this class
	private $error_array;
	private $con;
	//Construct
	public function __construct($con) {
		$this->con = $con;
		$this->error_array = array();
	}

	//
	public function loginUser($un, $pw) {
		$sql = "SELECT password FROM users WHERE username = '{$un}' ";
		$login_query = mysqli_query($this->con, $sql);

		if($login_query) {
			$row = mysqli_fetch_array($login_query);
			if(password_verify($pw, $row['password'])) {
				return true;
			} else {
				array_push($this->error_array, Constants::$login_error);
				return;
			}
		} else {
			array_push($this->error_array, Constants::$login_error);
			return;
		}
	}

	public function register($un, $fn, $ln, $em1, $em2, $p1, $p2) {
		$this->validateUsername($un);
		$this->validateFirstname($fn);
		$this->validateLastname($ln);
		$this->validateEmails($em1, $em2);
		$this->validatePasswords($p1, $p2);
		//
		if(empty($this->error_array)) {
			// Insert into DB
			return $this->insertUserDetails($un, $fn, $ln, $em1, $p1);
		} else {
			return false;
		}
	}

	public function getError($error) {
		if(!in_array($error, $this->error_array)) {
			$error = "";
		}
		return "<span class='errorMessage'>{$error}</span>";
	}

	//
	//
	private function insertUserDetails($un, $fn, $ln, $em, $pw) {
		$enc_password = password_hash($pw, PASSWORD_BCRYPT, array('cost' => 12));
		$date = date("Y-m-d H:i:s");
		$profile_pic = "assets/images/profile_pics/head_emerald.png";
		
		$sql = "INSERT INTO users (username, firstname, lastname, email, password, signupdate, profilepic) ";
		$sql .= "VALUES ('{$un}', '{$fn}', '{$ln}', '{$em}', '{$enc_password}', '{$date}', '{$profile_pic}') ";
		$result = mysqli_query($this->con, $sql);

		return $result;
	}

	private function validateUsername($un) {
		// Username Must be between 25 and 5 characters
		if(strlen($un) > 25 || strlen($un) < 5) {
			array_push($this->error_array, Constants::$username_length);
			return;
		}
		// Check if user in in DB 
		$sql = "SELECT username FROM users WHERE username = '{$un}' ";
		$check_username_query = mysqli_query($this->con, $sql);

		if (mysqli_num_rows($check_username_query) != 0) {
			array_push($this->error_array, Constants::$username_taken);
			return;
		}
		//
	}

	private function validateFirstname($fn) {
		//Firstname must be between 2 and 25 characters
		if(strlen($fn) > 25 || strlen($fn) < 2) {
			array_push($this->error_array, Constants::$firstname_length);
			return;
		}
	}

	private function validateLastname($ln) {
		//Lastname must be between 2 and 25 characters
		if(strlen($ln) > 25 || strlen($ln) < 2) {
			array_push($this->error_array, Constants::$lastname_length);
			return;
		}
	}
	
	private function validateEmails($em1, $em2) {
		//Check if emails match
		if($em1 != $em2) {
			array_push($this->error_array, Constants::$email_does_not_match);
			return;
		}
		// Make sure email is in the right format
		if(!filter_var($em1, FILTER_VALIDATE_EMAIL)) {
			array_push($this->error_array, Constants::$email_is_not_valid);
			return;
		}
		//CHECK EMAIL IN DB
		$sql = "SELECT email FROM users WHERE email = '{$em1}' ";
		$check_email_query = mysqli_query($this->con, $sql);

		if (mysqli_num_rows($check_email_query) != 0) {
			array_push($this->error_array, Constants::$email_taken);
			return;
		}
		//
	}
	
	private function validatePasswords($pw1, $pw2) {
		//Make sure passwords match
		if($pw1 != $pw2) {
			array_push($this->error_array, Constants::$passwords_do_not_match);
			return;
		}
		// Check password characters submited
		if(preg_match('/[^A-Za-z0-9]/', $pw1)) {
		//if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $pw1)) {
			array_push($this->error_array, Constants::$passwords_do_not_meet_req);
			return;
		}
		// Check the length
		if(strlen($pw1) > 50 || strlen($pw1) < 5) {
			array_push($this->error_array, Constants::$password_length);
			return;
		}
	}
// END CLASS
}
?>
