<?php
class Playlist {
	// Private vars for this class
	private $con;
	private $id;
	private $name;
	private $owner;

	//Construct
	public function __construct($con, $data) {
		if (!is_array($data)) {
			//Data is an ID not an array
			$data_sql = "SELECT * FROM playlists where id = '{$data}' ";
			$data_query = mysqli_query($con, $data_sql);

			$data = mysqli_fetch_array($data_query);
		}
		//
		$this->con = $con;
		$this->id = $data['id'];
		$this->name = $data['name'];
		$this->owner = $data['owner'];
	}

	//
	public function getName() {
		return $this->name;
	}

	public function getOwner() {
		return $this->owner;
	}

	public function getId() {
		return $this->id;
	}

	public function getNumberOfSongs() {
		$sql = "SELECT song_id FROM playlistsongs WHERE playlist_id = '{$this->id}' ";
		$query = mysqli_query($this->con, $sql);

		return mysqli_num_rows($query);
	}

	public function getSongIds() {
		$sql = "SELECT song_id FROM playlistsongs WHERE playlist_id = '{$this->id}' ORDER BY playlist_order ASC ";
		$query = mysqli_query($this->con, $sql);
		$array = array();
		while ($row = mysqli_fetch_array($query)) {
			array_push($array, $row['song_id']);
		}
		return $array;
	}

// END CLASS
}
