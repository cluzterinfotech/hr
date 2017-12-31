<?php

namespace Payment\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter;
use Payment\Model\GlassAllowance;
use Zend\Db\Sql\Predicate\Predicate; 
use Zend\Db\Sql\Predicate\Expression;
use Zend\Db\Sql\Ddl\Column\Varchar;

class GlassAllowanceMapper extends AbstractDataMapper {
	
	protected $entityTable = "GlassAllowance";
    	
	protected function loadEntity(array $row) {
		 $entity = new GlassAllowance(); 
		 return $this->arrayToEntity($row,$entity); 
	}
	
	public function selectglassallowance() {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->entityTable))
		       ->columns(array('*'))
		       ->join(array('m' => 'FamilyMembers'),'e.familyMemberId = m.id',
				      array('memberName'))
			   ->join(array('mt' => 'FamilyMemberType'),'mt.id = m.memberTypeId',
				      array('memberTypeName'))
		;
		//echo $select->getSqlString();
		//exit;
		return $select;
	}
	
	public function lkpFamilyMembersList() {
		$predicate = new Predicate(); 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('m' => 'FamilyMembers'))
		       ->columns(array('id','memberName'))
		       /*->columns(array('id',
				'memberName' =>
				new Expression("empType + ' ' + positionName + ' ' + shortDescription")))*/ 
				//->join(array('m' => 'FamilyMembers'),'e.familyMemberId = m.id',
						//array('memberName'))
				->join(array('mt' => 'FamilyMemberType'),'mt.id = m.memberTypeId',
					array('memberTypeName'))
				//->where($predicate->lessThan('organisatmtionLevel',$id))
				//->where(array('organisationLevel' => $id));
		;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		//echo $sqlString;
		//exit;
		$results = $this->adapter->query($sqlString)->execute();
		return $this->customArrayList($results,'id','memberName');
	}
	
	protected function customArrayList($results,$key,$val) {
		$array = array ();
		$array[''] = '';
		foreach($results as $result) { 
			$array[$result[$key]] = $result[$val]." - Relation - ".$result['memberTypeName'];
		} 
		return $array;
	}
	
	
}