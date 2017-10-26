<?php
class Artist {
	// Private vars for this class
	private $con;
	private $id;

	//Construct
	public function __construct($con, $id) {
		$this->con = $con;
		$this->id = $id;
	}

	//
	public function getName() {
		$artist_sql = "SELECT name FROM artists WHERE id = '{$this->id}' ";
		$artist_query = mysqli_query($this->con, $artist_sql);
		$artist = mysqli_fetch_array($artist_query);
		return $artist['name'];
	}

// END CLASS
}
?>
