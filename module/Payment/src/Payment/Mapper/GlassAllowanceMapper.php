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
	
	public function isHaveGlassAllowanceEdt($id,$memberId,$appliedDate) {
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    
	    $statement = $adapter->query("select
                    convert(varchar(10),Max(fromDate),120) as fromDate
                                      from ".$qi('GlassAllowance')." where
					familyMemberId  = '".$memberId."' and id != '".$id."'
					order by fromDate desc
		");
	    $results = $statement->execute()->current();
	    if($results) {
	        $applicationDate = $results['fromDate'];
	        $date = date($applicationDate);
	        $dateParts = explode('-', $date);
	        $Year = $dateParts[0]; // GetYear($Date); // yields 2003
	        $Month = $dateParts[1];
	        $Day = $dateParts[2];
	        $secoundYear = $Year + 2;
	        $newDate = $secoundYear . "-" . $Month . "-" . $Day;
	        if($appliedDate >= $newDate) { //Employee Eligible for New Glasses
	            return false;
	        } else {
	            return true; //Employee Not Eligible for New Glasses
	        }
	    }
	    return false; 
	}
	
	public function isHaveGlassAllowance($memberId,$appliedDate) {
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    
	    $statement = $adapter->query("select 
      convert(varchar(10),Max(fromDate),120) as fromDate
                                      from ".$qi('GlassAllowance')." where
					familyMemberId  = '".$memberId."' 
					order by fromDate desc
		");  
	    $results = $statement->execute()->current();
	    if($results) {
	        $applicationDate = $results['fromDate'];
	        $date = date($applicationDate);
	        $dateParts = explode('-', $date);
	        $Year = $dateParts[0]; // GetYear($Date); // yields 2003
	        $Month = $dateParts[1];
	        $Day = $dateParts[2];
	        $secoundYear = $Year + 2;
	        $newDate = $secoundYear . "-" . $Month . "-" . $Day;        
	        if($appliedDate >= $newDate) { //Employee Eligible for New Glasses
	            return false;
	        } else {  
	            return true; //Employee Not Eligible for New Glasses
	        }
	    } 
	    return false;     
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