<?php

namespace Employee\Mapper; 

use Payment\Model\Payment;  
use Payment\Model\ReferenceParameter;  
use Payment\Model\Company;

class LocationService extends Payment { 
	
	protected $locationMapper;
	protected $employeeLocationMapper; 
		
    public function __construct(ReferenceParameter $reference,
    		LocationMapper $locationMapper,EmployeeLocationMapper $employeeLocationMapper) { 
    	parent::__construct($reference);   
        $this->locationMapper = $locationMapper; 
        $this->employeeLocationMapper = $employeeLocationMapper;         	
    } 
    
    public function changeLocationAllowance() { 
        
    } 
        
    public function changeEmployeeLocation() { 
                            
    } 
    
    /*public function applyLocationAllowance($locationId,
    		$employeeNumber,Company $company,$effectiveDate) { 
    	//echo $locationId."<br/>";  
        //echo $employeeNumber."<br/>"; 
        //echo $company->getId()."<br/>"; 
        //echo $effectiveDate."<br/>"; 
    	//echo "Apply employee location allowance <br/>";   
    	$allowance = $this->companyAllowance->getallowanceListByLocation();   
    	foreach($allowance as $allowanceId) {    
    	    $this->addAllowanceToEmployee($employeeNumber,$allowanceId,$company,$effectiveDate);   
    	}   	
    } */
    
    public function addLocationAllowance() {
            	
    } 
    
    public function removeLocationAllowance() { 
        	
    }
    
    public function updateEmployeeLocation($data) { 
    	try {
    		$this->transaction->beginTransaction();
    		$company = $this->service->get('company'); 
    		// new EmployeeLocationMapper($adapter,$collection,$sm);  
    		$employeeNumber = $data->getEmployeeNumber(); 
    		$locationId = $data->getEmpLocation(); 
    		$effectiveDate = $data->getEffectiveDate(); 
    		$toArray = $this->employeeLocationMapper->entityToArray($data);
    		unset($toArray['effectiveDate']);
    		$this->employeeLocationMapper->update($toArray); 
    		$this->addEmployeeLocationAllowance($locationId,
    		                        $employeeNumber,$company,$effectiveDate); 
    		$this->transaction->commit(); 
    	} catch(\Exception $e) { 
    		//$this->transaction->rollBack(); 
    		throw $e; 
    	} 
    	return 'Employee Location Updated successfully';
    } 
    
    public function addEmployeeLocationAllowance($locationId,
    		$employeeNumber,$company,$effectiveDate) { 
    	// @todo add employee position allowance 
        try { 
			//$this->transaction->beginTransaction(); 
		    $allowanceList = $this->locationMapper
		                          ->getLocationAllowanceList($locationId,$company);  
	        	    
			foreach($allowanceList as $allowance) { 
				$allowanceId = $allowance['allowanceId'];  
			    $this->addAllowanceToEmployee($employeeNumber,
			    		$allowanceId,$company,$effectiveDate); 
			} 
			//$this->transaction->commit();  
			// return $res; 
		} catch(\Exception $e) { 
			//$this->transaction->rollBack();  
			throw $e;  
		}
    }
    
    //LocationService
    //ChangeCompanyLocationAllowance
    //ApproveCompanyLocationAllowance
    //ChangeEmployeeLocationAllowance
    //ApproveEmployeeLocationAllowance
    
}