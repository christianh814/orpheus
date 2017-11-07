<?php
class User {
	// Private vars for this class
	private $con;
	private $username;

	//Construct
	public function __construct($con, $username) {
		$this->con = $con;
		$this->username = $username;
	}

	//
	public function getUsername() {
		return $this->username;
	}
// END CLASS
}
?>
