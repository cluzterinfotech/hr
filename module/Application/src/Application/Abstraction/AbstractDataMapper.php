<?php
namespace Application\Abstraction;

use Application\Contract\EntityCollectionInterface, 
    Payment\Model\EntityInterface, 
    Application\Contract\DataMapperInterface, 
    Zend\Db\Adapter\Adapter as zendAdapter, 
    Zend\Db\Sql\Sql, 
    Application\Mapper\IdentityMap,
    Zend\Stdlib\Hydrator\ClassMethods;
use Application\Collection\EntityCollection;
use Payment\Model\DateRange;

abstract class AbstractDataMapper implements DataMapperInterface {
	
	protected $adapter;
	protected $collection;
	protected $entityTable;
	protected $identityMap;
	protected $sql;
	protected $hydrator;
	protected $service;
	// @todo move all utility methods to appropriate classes 
	public function __construct(zendAdapter $adapter, 
			EntityCollectionInterface $collection,$sm,$entityTable = null) {
		$this->adapter = $adapter;
		$this->collection = new EntityCollection(); 
		$this->service = $sm;
		if ($entityTable !== null) {
			$this->setEntityTable ( $entityTable );
		}
		if ($this->identityMap === null) {
			$this->identityMap = new IdentityMap();
		}
	}
	
	public function setEntityTable($entityTable) {
		if (!is_string($entityTable) || empty($entityTable)) {
			throw new \InvalidArgumentException("The entity table is invalid.");
		}
		$this->entityTable = $entityTable;
		return $this;
	}
	
	public function save($entity) {
		return 0;
		//return ! isset($entity->getId()) ? $this->insert($this->entityTable,$entity->toArray()) : $this->update ( $this->entityTable, $entity->toArray (), "id = $entity->id" );
	}
	
	public function getSql() {
		if ($this->sql === null) {
			$this->sql = new Sql($this->adapter);
		}
		return $this->sql;
	}
	
	public function select() { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from($this->entityTable)->columns(array(
				'*' 
		));
		//echo $select->getSqlString();
		//exit; 
		return $select;
	}
	
	public function fetch($where) {
		$sql = $this->getSql();
		$select = $this->select();
		if($where) {
			foreach($where as $col => $value) {
				$select->where(array(
						$col => $value 
				)); 
			} 
		} 
		return $sql->prepareStatementForSqlObject( $select );
		//echo $sqlQuery;
		//exit; 
	}
	
	public function fetchById($id) {
		if ($this->identityMap->hasId($id)) {
			return $this->identityMap->getObject($id);
		}
		$statement = $this->fetch(array(
				'id' => $id 
		) );
		if (!$results = $statement->execute()->current()) {
			return null;
		}
		$entity = $this->loadEntity($results);
		$this->identityMap->set($id,$entity);
		return $entity; 
	} 
	
	public function fetchAll(array $conditions = array()) {
		$statement = $this->fetch( $conditions );  
		//echo $statement->getSql();
		//exit; 
		if (! $results = $statement->execute ()) {
			return null;
		} 
		return $this->loadEntityCollection($results);
	}
	
	public function insert($entity) {
		//\Zend\Debug\Debug::dump($entity); 
		if(is_object($entity)) {
			if (true === $this->identityMap->hasObject($entity)) {
				throw new \Exception('Sorry! already have Id,unable to insert');
			}
		}
		$sql = new Sql($this->adapter);  // $this->getSql();
		$insert = $sql->Insert($this->entityTable);
		$array = $this->entityToArray($entity);
		unset($array['id']);
		/*echo "<pre>"; 
		var_dump($array); 
		echo "</pre>"; 
		exit;*/  
		$insert->values($array);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$sqlString = $insert->getSqlString();
		//echo $sqlString."<br />"; 
		//exit;  
		$res = $this->adapter->query($sqlString)->execute();
		$id = $res->getGeneratedValue();
		$this->identityMap->set((int)$id, $entity);
		return $id;
	}
	/*
	 * calculateValue takes result argument amount fromdate todate 
	 * return the value of average 
	 */ 
	
	protected function calculateValue($results, DateRange $dateRange) {
		// @todo calculate value based on result obtained , its incomplete now
		$dateMethod = $this->service->get('dateMethods');
		$amount = 0; 
		// @todo revise 
		//$daysInMonth = 30; 
		$fromDate = $dateRange->getFromDate(); 
		$toDate = $dateRange->getToDate(); 
		//var_dump($fromDate);
		//var_dump($toDate);
		$daysInMonth = $dateMethod->numberOfDaysBetween($fromDate,$toDate);
		//var_dump($daysInMonth);
		//exit;
		$from = date("Y-m-d",strtotime($fromDate)); 
		$to = date("Y-m-d",strtotime($toDate)); 
		$temp = 0; 
		if($results) {  
			foreach($results as $r) {
				$effDate = $r['effectiveDate'];
				$thisDays = $dateMethod->numberOfDaysBetween($fromDate,$effDate)-1; 
				//echo "<br/>this days".$thisDays;
				$effectiveDate = date("Y-m-d",strtotime($effDate)); 
				$tempAmount = $r['amount']; 
				if($effectiveDate == $temp) { 
					$fromDate = $effDate; 
					//$amount += ($tempAmount/$daysInMonth)*$thisDays; 
				} else { 
					$fromDate = $effDate; 
					$amount += ($tempAmount/$daysInMonth) * $thisDays; 
				} 
				$temp = $effectiveDate;  
			} 
			if($to != $effectiveDate) { 
				$thisDays = $dateMethod->numberOfDaysBetween($effDate,$toDate);  
				//echo "<br/>this days".$thisDays; 
				$amount += ($tempAmount/$daysInMonth) * $thisDays; 
			} 
			// echo "<br/>temp amount".$tempAmount;
			// echo "<br/>this amount".$amount; 
			// exit; 
			return number_format($amount, 2, '.', ''); 
		} else {
			return 0;  
		} 
		return 0; 
	} 
	
	protected function calculateSpecialValue($results, DateRange $dateRange) {
	    // @todo calculate value based on result obtained , its incomplete now
	    $dateMethod = $this->service->get('dateMethods');
	    $amount = 0;
	    // @todo revise
	    //$daysInMonth = 30;
	    $fromDate = $dateRange->getFromDate();
	    $toDate = $dateRange->getToDate();
	    //var_dump($fromDate);
	    //var_dump($toDate);
	    $daysInMonth = $dateMethod->numberOfDaysBetween($fromDate,$toDate);
	    //var_dump($daysInMonth);
	    //exit;
	    $from = date("Y-m-d",strtotime($fromDate));
	    $to = date("Y-m-d",strtotime($toDate));
	    $temp = 0;
	    $myFlag = 0;
	    if($results) {
	        foreach($results as $r) {
	            $effDate = $r['effectiveDate'];
	            $isAdded = $r['isAdded']; 
	            $thisDays = $dateMethod->numberOfDaysBetween($fromDate,$effDate)-1;
	            //echo "<br/>this days".$thisDays;
	            $effectiveDate = date("Y-m-d",strtotime($effDate));
	            $tempAmount = $r['amount'];
	            if($effectiveDate == $temp) {
	                $fromDate = $effDate;
	                //$amount += ($tempAmount/$daysInMonth)*$thisDays;
	            } else {
	                $fromDate = $effDate;
	                $amount += ($tempAmount/$daysInMonth) * $thisDays;
	            }
	            $temp = $effectiveDate;
	            $myFlag = $isAdded; 
	        }
	        if($to != $effectiveDate) {
	            $thisDays = $dateMethod->numberOfDaysBetween($effDate,$toDate);
	            //echo "<br/>this days".$thisDays;
	            $amount += ($tempAmount/$daysInMonth) * $thisDays;
	        }
	        if($myFlag == 0) {
	            return array(0,0); 
	        }
	        // echo "<br/>temp amount".$tempAmount;
	        // echo "<br/>this amount".$amount;
	        // exit;
	        return array(1,number_format($amount, 2, '.', ''));
	    } else {
	        return array(0,0);
	    }
	    return array(0,0);
	}
	
	private function getHydrator() {
		if($this->hydrator === null) {
		    $this->hydrator = new ClassMethods(false);
		}
		return $this->hydrator;
	}
	
	public function entityToArray($entity) {
		if (is_array($entity )) {
			return $entity;
		} elseif ($entity instanceof EntityInterface ) {
			return $this->getHydrator()->extract($entity);
		}
		throw new \Exception('Entity passed to db mapper should be an array or object.');
		//return $this->getHydrator()->extract($entity);
	}
	
	protected function arrayToEntity(array $array,$entity) {
		return $this->getHydrator()->hydrate($array,$entity);
	}
	
	public function update($entity) { 
		if(is_object($entity)) {
			if (false === $this->identityMap->hasObject($entity)) {
				throw new \Exception('Sorry! Id not available,unable to update');
			}
		}
		
		$sql = $this->getSql();
		$update = $sql->Update($this->entityTable);
		$array = $this->entityToArray($entity); 
		$id = $array['id'];
		unset($array['id']);
		$update->set($array);
		$update->where(array(
			'id' => $id
		)); 
		//$sqlString = $update->getSqlString();  
		$sqlString = $sql->getSqlStringForSqlObject($update); 
		//echo $sqlString;
		//exit;
		return $this->adapter->query($sqlString)->execute()->count(); 
	} 
	
	public function delete($entity) {
		/*if(is_object($entity)) {
			if (false === $this->identityMap->hasObject($entity)) {
				throw new \Exception('Sorry! Id not available,unable to delete');
			}
		}*/
		$sql = $this->getSql();
		$delete = $sql->delete($this->entityTable);
		
		$array = $this->entityToArray($entity);
		$id = $array['id'];
		unset($array['id']); 
		$delete->where(array(
				'id' => $id
		)); 
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		//echo $sqlString;
		//exit; 
		return $this->adapter->query($sqlString)->execute()->count(); 
	}
	
	protected function loadEntityCollection($results) {
		$this->collection->clear();
		//$i = 1;
		foreach($results as $row) {
			$id = trim($row['id']);
			//\Zend\Debug\Debug::dump($row);
			//exit; 
			/*if (true === $this->identityMap->hasId($id)) {
				$this->collection[] = $this->identityMap->getObject($id);
			} else { 
			    $entity = $this->loadEntity($row);
			    $this->identityMap->set($id,$entity);
			    $this->collection[] = $entity;
			} */ 
			$entity = $this->loadEntity($row);
			$this->collection[] = $entity;
			/* $entity = $this->loadEntity($row);
			if (true === $this->identityMap->hasObject($entity)) { 
			    
			} else {
				$this->identityMap->set($id,$entity);
			}
			$this->collection[] = $entity; */ 
		}
		//\Zend\Debug\Debug::dump($this->collection);
		//exit; 
		return $this->collection;
	}
	/* converts pdo resultset to array */
	protected function convertToArray($results) {
		$records = array(); 
		foreach ($results as $result) { 
			$records[] = $result; 
		} 
		return $records; 
	} 
	
	protected function getFromTo($calMon,$calYear) {
		$from = $calYear . "-" . $calMon . "-01";
		$totDays = cal_days_in_month(CAL_GREGORIAN, $calMon, $calYear);
		$to = $calYear . "-" . $calMon . "-" . $totDays;
		return array('fromDate' => $from,'toDate' => $to );
	}
	
	
	/*protected function getTo() {
		
	}*/
	/* converts pdo resultset to array */
	/* protected function convertToArray($results) {
		$records = array();
		foreach ($results as $result) {
			$records[] = $result;
		}
		return $records;
	} */
	
	/* converts pdo resultset to array list */ 
	protected function toArrayList($results,$key,$val) { 
		$array = array ();
		$array[''] = '';
		foreach($results as $result) {
			$array[$result[$key]] = $result[$val];
		} 
		return $array;
	}
	
	protected function toArrayListWithoutBlank($results,$key,$val) {
		$array = array ();
		//$array[''] = '';
		foreach($results as $result) {
			$array[$result[$key]] = $result[$val];
		}
		return $array;
	}
    	
	abstract protected function loadEntity(array $row); 
	
}