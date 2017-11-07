<?php
class Playlist {
	// Private vars for this class
	private $con;
	private $id;
	private $name;
	private $owner;

	//Construct
	public function __construct($con, $data) {
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
// END CLASS
}
?>
