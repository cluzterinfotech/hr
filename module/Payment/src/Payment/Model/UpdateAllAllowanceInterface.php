<?php

namespace Payment\Model;

interface UpdateAllAllowanceInterface 
{ 
	public function updateAllAllowance($employeeNumber,$effectiveDate,$allowanceName); 
	
}