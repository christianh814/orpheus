<?php
class Album {
	// Private vars for this class
	private $con;
	private $id;
	private $title;
	private $artist_id;
	private $genre;
	private $artwork_path;

	//Construct
	public function __construct($con, $id) {
		$this->con = $con;
		$this->id = $id;
		$sql = "SELECT * FROM albums where id = '{$this->id}' ";
		$query = mysqli_query($this->con, $sql);
		$album = mysqli_fetch_array($query);
		//
		$this->title = $album['title'];
		$this->artist_id = $album['artist'];
		$this->genre = $album['genre'];
		$this->artwork_path = $album['artwork_path'];
	}

	//
	public function getTitle() {
		return $this->title;
	}

	public function getArtworkPath() {
		return $this->artwork_path;
	}

	public function getArtist() {
		return new Artist($this->con, $this->artist_id);
	}

	public function getGenre() {
		return $this->genre;
	}

// END CLASS
}
?>
