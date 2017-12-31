<?php

namespace Allowance\Model;

use Payment\Model\EntityInterface;

class IncrementCriteria implements EntityInterface {
	
	private $id;
	private $Year; 
	private $joinDate;
	private $confirmationDate;
	private $incrementFrom;
	private $incrementTo;
	private $sickLeaveDays;
	private $maximumScale;
	private $colaPercentage;
	private $incrementAveragePercentage;
	
	public function getId() {
		return $this->id;
	} 
	public function setId($id) {
		$this->id = $id;
		return $this;
	} 
	public function setYear($Year) { 
		$this->Year = $Year; 
		return $this;
	}
	public function getYear() { 
		return $this->Year; 
	} 
	public function setJoinDate($joinDate) { 
		$this->joinDate = $joinDate; 
		return $this;
	}
	public function getJoinDate() { 
		return $this->joinDate; 
	}
	public function setConfirmationDate($confirmationDate) { 
		$this->confirmationDate = $confirmationDate; 
		return $this;
	}
	public function getConfirmationDate() { 
		return $this->confirmationDate; 
	}
	public function setIncrementFrom($incrementFrom) { 
		$this->incrementFrom = $incrementFrom; 
		return $this;
	}
	public function getIncrementFrom() { 
		return $this->incrementFrom; 
	}
	public function setIncrementTo($incrementTo) { 
		$this->incrementTo = $incrementTo; 
		return $this;
	}
	public function getIncrementTo() { 
		return $this->incrementTo; 
	}
	public function setSickLeaveDays($sickLeaveDays) { 
		$this->sickLeaveDays = $sickLeaveDays; 
		return $this;
	}
	public function getSickLeaveDays() { 
		return $this->sickLeaveDays; 
	}
	public function setMaximumScale($maximumScale) { 
		$this->maximumScale = $maximumScale; 
		return $this;
	}
	public function getMaximumScale() { 
		return $this->maximumScale; 
	}
	public function setColaPercentage($colaPercentage) { 
		$this->colaPercentage = $colaPercentage; 
		return $this;
	}
	public function getColaPercentage() { 
		return $this->colaPercentage; 
	}
	public function setIncrementAveragePercentage($incrementAveragePercentage) { 
		$this->incrementAveragePercentage = $incrementAveragePercentage; 
		return $this;
	}
	public function getIncrementAveragePercentage() { 
		return $this->incrementAveragePercentage; 
	} 
}   