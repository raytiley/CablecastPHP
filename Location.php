<?php
namespace CablecastPHP;

class Location {
	private $name;
	private $id;

	function __construct($id, $name)
	{
		$this->name = $name;
		$this->id = $id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getID()
	{
		return $this->id;
	}
}
?>