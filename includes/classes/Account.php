<?php
class Account {
	// Private vars for this class
	private $error_array;
	//Construct
	public function __construct() {
		$this->error_array = array();
	}

	//
	public function register($un, $fn, $ln, $em1, $em2, $p1, $p2) {
		$this->validateUsername($un);
		$this->validateFirstname($fn);
		$this->validateLastname($ln);
		$this->validateEmails($em1, $em2);
		$this->validatePasswords($p1, $p2);
		//
		if(empty($this->error_array)) {
			// Insert into DB
			return true;
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
	private function validateUsername($un) {
		// Username Must be between 25 and 5 characters
		if(strlen($un) > 25 || strlen($un) < 5) {
			array_push($this->error_array, "Username must be between 5 and 25 characters");
			return;
		}
		// Check if user in in DB 
		//
	}
	private function validateFirstname($fn) {
		//Firstname must be between 2 and 25 characters
		if(strlen($fn) > 25 || strlen($fn) < 2) {
			array_push($this->error_array, "Firstname must be between 2 and 25 characters");
			return;
		}
	}
	private function validateLastname($ln) {
		//Lastname must be between 2 and 25 characters
		if(strlen($ln) > 25 || strlen($ln) < 2) {
			array_push($this->error_array, "Lastname must be between 2 and 25 characters");
			return;
		}
	}
	private function validateEmails($em1, $em2) {
		//Check if emails match
		if($em1 != $em2) {
			array_push($this->error_array, "Emails do not match!");
			return;
		}
		// Make sure email is in the right format
		if(!filter_var($em1, FILTER_VALIDATE_EMAIL)) {
			array_push($this->error_array, "Email not in the right format");
			return;
		}
		//CHECK EMAIL IN DB
		//
	}
	private function validatePasswords($pw1, $pw2) {
		//Make sure passwords match
		if($pw1 != $pw2) {
			array_push($this->error_array, "Passwords do not match!");
			return;
		}
		// Check password characters submited
		if(preg_match('/[^A-Za-z0-9]/', $pw1)) {
		//if(preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $pw1)) {
			array_push($this->error_array, "Password does not meet requirements");
			return;
		}
		// Check the length
		if(strlen($pw1) > 50 || strlen($pw1) < 5) {
			array_push($this->error_array, "Password must be between 5 and 50 characters");
			return;
		}
	}
// END CLASS
}
?>
