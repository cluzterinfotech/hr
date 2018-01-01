<?php

namespace Allowance\Model;

use Allowance\Model\AllowanceMapper;

class CompanyService {
	
	private $allowanceMapper;
	
	public function __construct(AllowanceMapper $allowanceMapper) {
		$this->companyMapper = $allowanceMapper;
	}
	
	public function getAllowanceList() {
		return $this->companyMapper->getAllowanceList();
	}
    	
}