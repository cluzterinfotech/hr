<?php 
namespace Payment\Model; 

use Payment\Model\AbstractAllowance; 
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;

class UpdateHardship extends Payment implements ListenerAggregateInterface,
UpdateAllAllowanceInterface { 
    
	protected $listeners = array();
	
	protected $saveAudit;
    	
	public function attach(EventManagerInterface $events) {
		$sharedEvents = $events->getSharedManager();
		// triggering same class
		$this->listeners[] =
		$sharedEvents->attach(
				'Employee\Model\AllowanceByCalculationService',
				'updateLocation',
				array($this,'updateAllowance')); 
	}
	
	public function detach(EventManagerInterface $events) {
		foreach ($this->listeners as $index => $listener) {
			if($events->detach($listener)) {
				unset($this->listeners[$index]);
			}
		}
	}
    
	/*
	 * @params employeeNumber and effectiveDate 
	 */
	
	public function updateAllowance($data) {
		try {
			$value = $data->getParams(); 
			$employeeLocation = $value['employeeLocation']; 
		    $service = $this->service->get('EmployeeLocationMapper'); 
		    $array = $service->entityToArray($employeeLocation); 
		    $allowance = $this->service->get('Hardship'); 
		    // @todo calculate amount method 
		    $effectiveDate = $array['effectiveDate']; 
		    $allowanceName = $allowance->getTableName(); 
		    $employeeNumber = $array['employeeNumber']; 
		    
		    $employee = $this->getEmployeeById($employeeNumber);
		    // $dateRange = 
		    
		    $hardshipAmount = $allowance->calculateAmount($employee,$dateRange); 
		    $arr = array(
		    	'effectiveDate' => $effectiveDate,
		    	'amount'        => $hardshipAmount,
		    	'employeeId'    => $employeeNumber 
		    );    
		    $allowance->insert($arr);  
		    $this->updateAllAllowance($employeeNumber,$effectiveDate,$allowanceName); 
		} catch (\Exception $e) {
			throw $e; 
		}
	} 
	
    public function updateAllAllowance($employeeNumber,$effectiveDate,$allowanceName) { 
		$this->reviseAllAllowance($employeeNumber,$effectiveDate,$allowanceName);
	} 
}   