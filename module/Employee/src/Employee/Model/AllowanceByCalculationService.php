<?php
namespace Employee\Model;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Employee\Model\Location;
use Employee\Model\EmployeeLocation;
use Payment\Model\Payment;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;

class AllowanceByCalculationService extends Payment implements EventManagerAwareInterface {
	
	protected $eventManager;
	
	public function updateLocation($data) { 
		try { 
			// begin transaction 
			$this->transaction->beginTransaction(); 
			$service = $this->service->get('EmployeeLocationMapper'); 
			$array = $service->entityToArray($data);
			unset($array['effectiveDate']);
			$service->update($array); 
			$this->getEventManager()->trigger(
					'updateLocation',null,array('employeeLocation' => $data)
			);
			// commit 
	        $this->transaction->commit();   
	        
		} catch(\Exception $e) { 
			// rollback 
            $this->transaction->rollBack(); 
            throw new \Exception("Sorry! unable to update employee location");   
	    } 
	} 
	
	public function getEventManager() {
	    if($this->eventManager === null) {
	        $this->eventManager = new EventManager(__CLASS__);
	    }
	    return $this->eventManager;
	 }
	 
	 public function setEventManager(EventManagerInterface $eventManager) {
	     $this->eventManager = $eventManager;
	     return $this;
	 } 
	 
}