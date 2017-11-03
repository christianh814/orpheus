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
	public function getId() {
		return $this->id;
	}
	public function getName() {
		$artist_sql = "SELECT name FROM artists WHERE id = '{$this->id}' ";
		$artist_query = mysqli_query($this->con, $artist_sql);
		$artist = mysqli_fetch_array($artist_query);
		return $artist['name'];
	}

	public function getSongIds() {
		$sql = "SELECT id FROM songs WHERE artist = '{$this->id}' ORDER BY plays ASC LIMIT 5";
		$query = mysqli_query($this->con, $sql);
		$array = array();
		while ($row = mysqli_fetch_array($query)) {
			array_push($array, $row['id']);
		}
		return $array;
	}
// END CLASS
}
?>
