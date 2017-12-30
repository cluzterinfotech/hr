<?php
namespace Payment\Model; 

use Payment\Model\AbstractAllowance; 
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;

class UpdateCarRent extends Payment implements ListenerAggregateInterface { 
    
	protected $listeners = array();
	
	protected $saveAudit;
    	
	public function attach(EventManagerInterface $events) {
		$sharedEvents = $events->getSharedManager();
		// triggering same class
		$this->listeners[] =
		$sharedEvents->attach(
				'Employee\Model\AllowanceByCalculationService',
				'updateLocation',
				array($this,'updateCarRent')); 
		/*$this->listeners[] =
		$sharedEvents->attach(
				'Employee\Model\AllowanceByCalculationService',
				'updateLocation',
				array($this,'update')); */
	}
	
	public function detach(EventManagerInterface $events) {
		foreach ($this->listeners as $index => $listener) {
			if($events->detach($listener)) {
				unset($this->listeners[$index]);
			}
		}
	}
    
	public function updateCarRent($data) {
		/* if(isHaveCarRent) {
			
		} */
		/* $value = $data->getParams();
		$employeeLocation = $value['employeeLocation'];
		
	    $service = $this->service->get('EmployeeLocationMapper');
	    $array = $service->entityToArray($employeeLocation);
	    
	    $hardship = $this->service->get('Hardship');
	    $hardshipAmount = $hardship->calculateAmount();
	    
	    $employeeAllowance = $this->service->get('Hardship');
	    $arr = array(
	    	'effectiveDate' => $array['effectiveDate'],
	    	'amount'        => $hardshipAmount,
	    	'employeeId'    => $array['employeeNumber']
	    		 
	    );
	    $employeeAllowance->insert($arr); */
	}

}   