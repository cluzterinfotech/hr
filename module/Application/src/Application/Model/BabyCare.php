<?php

namespace Application\Model;

use Payment\Model\EntityInterface;

class BabyCare implements EntityInterface {
	
	private $id;
	private $employeeNumber;
	private $startingDate;
	private $endingDate;
	private $startingTime;
	private $endingTime; 
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	public function getEmployeeNumber() {
		return $this->employeeNumber;
	}
	public function setEmployeeNumber($employeeNumber) {
		$this->employeeNumber = $employeeNumber;
		return $this;
	}
	public function getStartingDate() {
		return $this->startingDate;
	}
	public function setStartingDate($startingDate) {
		$this->startingDate = $startingDate;
		return $this;
	}
	public function getEndingDate() {
		return $this->endingDate;
	}
	public function setEndingDate($endingDate) {
		$this->endingDate = $endingDate;
		return $this;
	}
    public function getStartingTime()
    {
        return $this->startingTime;
    }

    public function getEndingTime()
    {
        return $this->endingTime;
    }

    public function setStartingTime($startingTime)
    {
        $this->startingTime = $startingTime;
    }

    public function setEndingTime($endingTime)
    {
        $this->endingTime = $endingTime;
    } 	
}