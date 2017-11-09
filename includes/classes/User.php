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

	public function getFirstAndLastName() {
		$sql = "SELECT CONCAT(firstname, ' ', lastname) AS 'name' FROM users WHERE username = '{$this->username}' ";
		$query = mysqli_query($this->con, $sql);

		$row = mysqli_fetch_array($query);
		return $row['name'];
	}
// END CLASS
}
?>
