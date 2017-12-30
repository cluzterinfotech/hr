<?php
namespace Allowance\Model;


class EmployeeBenefits {
	
	private $grossAmount;
	
	public function getGrossAmount() {
		$this->grossAmount = 0;
		$this->grossAmount = $this->getBasic();
		$this->grossAmount = $this->getAllowanceNotInBasic();
		return $this->grossAmount;
	}
	
	public function getBasic() {
		$basic = $this->getInitial();
		$basic += $this->getAllowancesInBasic();
		return $basic;
	}
	
	public function getAllowancesInBasic() {
		$basicAllowanceAmount = 0;
		$allowanceInBasic = array('cola'); 
		foreach ($allowanceInBasic as $allowanceBasic) {
			$allowance = $this->getService($allowanceBasic);
			$basicAllowanceAmount += $allowance->getAmount();
		}
		return $basicAllowanceAmount;
	}
	
	public function getAllowanceNotInBasic() {
	    $allowanceNotInBasic = array('hardship','overtime'); 
		foreach ($allowanceNotInBasic as $allowanceNotBasic) {
			$allowance = $this->getService($allowanceNotBasic);
			$nonBasicAllowanceAmount += $allowance->getAmount();
		}
		return $nonBasicAllowanceAmount;
	}
	
	public function getAllAllowance() {
		return $this->getAllowancesInBasic() + $this->getAllowanceNotInBasic();
	} 
	
	public function getService($service) {
		
	}
	
	public function getInitial() {
		
	}
	
	public function getCola() {
		
	}
	
}   