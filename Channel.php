<?php
namespace CablecastPHP;

class Channel
{
	private $ID;
	private $name;
	private $locationID;

	function __construct($id, $name, $locationID)
	{
		$this->ID = $id;
		$this->name = $name;
		$this->locationID = $locationID;
	}

	public function getID()
	{
		return $this->ID;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getLocationID()
	{
		return $this->locationID;
	}
}
?>