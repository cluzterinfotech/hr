<?php
    
//  Allowance required attributes
    
//  Percentage 
//  Basic 
//  Salary grade amount 
//  job grade allowance
     
//  generally every allowance required employee object,fromDate,toDate
    
class Allowance {
	
	protected $employee;
	protected $fromDate;
	protected $toDate;

    /**
     * @return mixed
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * @param mixed $employee
     */
    public function setEmployee($employee)
    {
        $this->employee = $employee;
    }
	
	// protected function get
}

class Hardship {
	
} 