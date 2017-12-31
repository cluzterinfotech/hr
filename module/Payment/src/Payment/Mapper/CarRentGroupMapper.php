<?php
namespace Payment\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter;
use Employee\Model\CarRentPositionGroup;
use Zend\Db\Sql\Predicate;
use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Ddl\Column\Varchar;

class CarRentGroupMapper extends AbstractDataMapper {
	
	protected $entityTable = "lkpCarRentGroup";
    	
	protected function loadEntity(array $row) {
		 $entity = new CarRentPositionGroup(); 
		 return $this->arrayToEntity($row,$entity); 
	}
	
	public function selectPositionGroup() {
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('id')) 
		       ->join(array('p' => 'Position'),'p.id = e.positionId',
		              array('positionName'))
		       ->join(array('g' => 'lkpCarRentGroup'), 'e.lkpCarRentGroupId = g.id', 
		              array('groupName','Amount','Notes' ) )
		; 
		//echo $select->getSqlString(); 
		//exit; 
		return $select; 
	}
	
	public function lkpPositionGroupList() { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
			   ->columns(array('id','groupName','amount','Notes'))
	    ;  
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    $results = $this->adapter->query($sqlString)->execute();
		return $this->toCustArrayList($results);
		//return $select;
	} 
	
	public function toCustArrayList($results) {
		$array = array ();
		$array[''] = '';
		foreach($results as $result) {
			$array[$result['id']] = 
			$result['groupName']." - " .$result['amount']." - ".$result['Notes'];
		}
		return $array; 
	}
	
}