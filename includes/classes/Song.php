<?php
class Song {
	// Private vars for this class
	private $con;
	private $id;
	private $mysqli_data;
	private $title;
	private $artist;
	private $album;
	private $genre;
	private $duration;
	private $path;

	//Construct
	public function __construct($con, $id) {
		$this->con = $con;
		$this->id = $id;
		$sql = "SELECT * FROM songs where id = '{$this->id}' ";
		$query = mysqli_query($this->con, $sql);
		$this->mysqli_data = mysqli_fetch_array($query);
		//
		$this->title = $this->mysqli_data['title'];
		$this->artist = $this->mysqli_data['artist'];
		$this->album = $this->mysqli_data['album'];
		$this->genre = $this->mysqli_data['genre'];
		$this->duration = $this->mysqli_data['duration'];
		$this->path = $this->mysqli_data['path'];
	}

	//
	public function getTitle() {
		return $this->title;
	}

	public function getArtist() {
		return new Artist($this->con, $this->artist);
	}

	public function getAlbum() {
		return new Album($this->con, $this->album);
	}

	public function getPath() {
		return $this->path;
	}

	public function getGenre() {
		return $this->Genre;
	}

	public function getMysqliData() {
		return $this->myslqi_data;
	}

	public function getDuration() {
		return $this->duration;
	}

// END CLASS
}
?>
