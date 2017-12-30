<?php
namespace Payment\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter;
use Employee\Model\FamilyMember;
use Zend\Db\Sql\Predicate;
use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Ddl\Column\Varchar;

class FamilyMemberMapper extends AbstractDataMapper {
	
	protected $entityTable = "FamilyMembers";
    	
	protected function loadEntity(array $row) {
		 $entity = new FamilyMember(); 
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function selectFamilyMember() {
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('m' => $this->entityTable))
		       ->columns(array('id','memberName')) 
		     ->join(array('mt' => 'FamilyMemberType'),'mt.id = m.memberTypeId',
		             array('memberTypeName'))
		     ->join(array('e' => 'EmpEmployeeInfoMain'), 'm.employeeId = e.employeeNumber', 
		             array('employeeName'))
		; 
		//echo $select->getSqlString(); 
		//exit; 
		return $select; 
	}
	
	/*public function positionGroupList() { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
			   ->columns(array('id','locationName'))
	    ; 
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    $results = $this->adapter->query($sqlString)->execute();
		return $this->toArrayList($results,'id','locationName');
		//return $select;
	} */
	
}