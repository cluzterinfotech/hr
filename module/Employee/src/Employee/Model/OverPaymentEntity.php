<?php
namespace Employee\Model;

use Payment\Model\EntityInterface;

class OverPaymentEntity implements EntityInterface {
	
	private $id;
	private $employeeNumber;
	private $amount;
	private $numberOfMonthsDed;
	
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
	public function getAmount() {
		return $this->amount;
	}
	public function setAmount($amount) {
		$this->amount = $amount;
		return $this;
	}
    public function getNumberOfMonthsDed()
    {
        return $this->numberOfMonthsDed;
    }

    public function setNumberOfMonthsDed($numberOfMonthsDed)
    {
        $this->numberOfMonthsDed = $numberOfMonthsDed;
        return $this;
    } 	
}   