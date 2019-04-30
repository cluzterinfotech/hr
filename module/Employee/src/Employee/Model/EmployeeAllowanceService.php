<?php 

namespace Employee\Model;

use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Employee\Mapper\EmployeeAllowanceMapper;
use Application\Persistence\TransactionDatabase;

class EmployeeAllowanceService implements EventManagerAwareInterface {
	
	private $eventManager;
	private $employeeAllowanceMapper;
	private $transaction;
	private $service; 
    
	public function __construct(EmployeeAllowanceMapper $mapper,
			TransactionDatabase $transactionDatabase,$sm) { 
		
		$this->employeeAllowanceMapper = $mapper; 
		$this->transaction = $transactionDatabase;
		$this->service = $sm; 
	}
	
	public function addAllowance($data) { 
		try { 
			// begin transaction 
			$this->transaction->beginTransaction(); 
			$service = $this->service->get('EmployeeAllowanceMapper'); 
			$array = $service->entityToArray($data); 
			//\Zend\Debug\Debug::dump($array); 
			//exit; 
			//var_dump($array['allowanceNameText']);
			//exit;
			// unset($array['effectiveDate']);
			// $service->setEntityTable($array['allowanceNameText']);
			$service->insertAllowance($array); 
			
			/*$this->getEventManager()->trigger(
					'updateInitial',null,array('initialDetails' => $array)
			);*/
			// commit 
	        $this->transaction->commit();   
	        
		} catch(\Exception $e) { 
			// rollback 
            $this->transaction->rollBack(); 
            throw new \Exception("Sorry! unable to update employee initial");   
	    } 
	} 
	
	public function updateAllowance($data) {
		try {
			// begin transaction
			$this->transaction->beginTransaction();
			$service = $this->employeeAllowanceMapper;
			$array = $service->entityToArray($data); 
			//\Zend\Debug\Debug::dump($array); 
			//exit; 
				
			//unset($array['effectiveDate']); 
			// $service->setEntityTable($array['allowanceNameText']); 
			$service->updateAllowance($array);  
			/*$this->getEventManager()->trigger(
			 'updateInitial',null,array('initialDetails' => $array)
			);*/
			// commit
			$this->transaction->commit(); 
			 
		} catch(\Exception $e) {
			// rollback
			$this->transaction->rollBack();
			throw new \Exception("Sorry! unable to update employee initial");
		}
	}
	
	public function fetchEmployeeAllowance($id,$tableName) {
		return $this->employeeAllowanceMapper->fetchEmployeeAllowance($id,$tableName);
	}
	
	public function employeeAllowanceList($table) {
		return $this->employeeAllowanceMapper->employeeAllowanceList($table);
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