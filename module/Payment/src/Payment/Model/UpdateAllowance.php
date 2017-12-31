<?php 
namespace Payment\Model; 

use Payment\Model\AbstractAllowance; 
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;

class UpdateAllowance extends Payment implements ListenerAggregateInterface,
UpdateAllAllowanceInterface { 
    
	protected $listeners = array();
	
	protected $saveAudit;
    	
	public function attach(EventManagerInterface $events) {
		$sharedEvents = $events->getSharedManager();
		// triggering same class
		$this->listeners[] =
		$sharedEvents->attach(
				'Employee\Model\PromotionService',
				'updateInitial',
				array($this,'updateAllowance')); 
		$this->listeners[] =
		$sharedEvents->attach(
				'Employee\Model\InitialService',
				'updateInitial',
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
			$initialDetails = $value['initialDetails']; 
		    $allowance = $this->service->get('Initial'); 
		    $effectiveDate = $initialDetails['effectiveDate']; 
		    $allowanceName = $allowance->getTableName(); 
		    $employeeNumber = $initialDetails['employeeId'];
		    $initialAmount = $initialDetails['amount']; 
		    
		    $arr = array(
		    	'effectiveDate' => $effectiveDate,
		    	'amount'        => $initialAmount,
		    	'employeeId'    => $employeeNumber 
		    ); 
		    //\Zend\Debug\Debug::dump($arr); 
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