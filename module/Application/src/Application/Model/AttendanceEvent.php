<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class AttendanceEvent implements EntityInterface {
	
	private $id;
	private $eventName;
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getEventName() {
		return $this->eventName;
	}
	public function setEventName($eventName) {
		$this->eventName = $eventName;
		return $this;
	}
		
}