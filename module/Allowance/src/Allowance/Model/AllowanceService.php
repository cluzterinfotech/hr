<?php

namespace Allowance\Model;

use Allowance\Model\AllowanceMapper;

class AllowanceService {
	
	private $allowanceMapper;
	
	public function __construct(AllowanceMapper $allowanceMapper) {
		$this->allowanceMapper = $allowanceMapper;
	}
	
	public function getAllowanceList() {
		return $this->allowanceMapper->getAllowanceList();
	}
    	
}