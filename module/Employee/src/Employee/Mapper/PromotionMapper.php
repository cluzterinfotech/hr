<?php

namespace Employee\Mapper;

use Application\Abstraction\AbstractDataMapper; 
use Employee\Model\Promotion;
use Payment\Model\Company;

class PromotionMapper extends AbstractDataMapper {
	
	protected $entityTable = "PromotionBuffer";
    
	protected function loadEntity(array $row) { 
	    $entity = new Promotion();
	    return $this->arrayToEntity($row,$entity); 
	}
    
	public function getPromotionList(Company $company) { 
		/*$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name); 
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$where = " (1=1) ";
		//$where .= " and c.employeeId = '".$employee->getEmployeeNumber()."' ";
		//$where .= " and c.effectiveDate >= '".$dateRange->getFromDate()."' ";
		//$where .= " and c.effectiveDate <= '".$dateRange->getToDate()."' ";
		//$order = " order by c.effectiveDate,c.id ASC";
		$statement = $adapter->query("SELECT *
                                       FROM " . $qi('PromotionBuffer') . " AS c
				where  $where  "); 
		//echo $statement->getSql(); 
		//exit; 
		$results = $statement->execute(); */
		
		$select = $this->selectPromotion($company); 
		$sql = $this->getSql(); 
		$statement = $sql->prepareStatementForSqlObject( $select ); 
		$results = $statement->execute();
		
		return $this->convertToArray($results);
	}
	
	public function selectPromotion(Company $company) {
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('p' => $this->entityTable))
		       ->columns(array('*'))
		       ->join(array('e' => 'EmpEmployeeInfoMain'),
				            'p.employeeNumber = e.employeeNumber',
			          array('employeeName'))
	            ->join(array('s' => 'lkpSalaryGrade'),'s.id = p.promotedSalaryGrade',
					   array('salaryGrade'))
						/*->join(array('se' => 'section'),'se.id = p.section',
								array('sectionName'),'left')
								->join(array('d' => 'Department'),'d.id = se.department',
										array('departmentName'),'left')
			       ->join(array('s' => 'lkpSalaryGrade'),'s.id = e.empSalaryGrade',
			       		array('salaryGrade'))*/
			   ->where(array('Closed' => 0)) 
			   ->where(array('p.companyId' => $company->getId()))
			   ->order('employeeName asc')
	    ;
			       // echo $sql->getSqlStringForSqlObject($select);
			       // exit;
	    return $select;
	} 
	
	public function removeEmployeePromotion($id) {
		$sql = $this->getSql();
		$delete = $sql->delete('PromotionBuffer');
		$delete->where(array(
				'id' => $id
		));
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	}
	
	public function promotionReport($company,$values) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$where = " (1=1) ";
		//$where .= " and c.employeeId = '".$employee->getEmployeeNumber()."' ";
		//$where .= " and c.promotionDate >= '".$values['fromDate']."' ";
		//$where .= " and c.promotionDate <= '".$values['toDate']."' ";  
		//$order = " order by c.effectiveDate,c.id ASC";
		$statement = $adapter->query("
				select 
				employeeName,batchId,p.companyId,p.employeeNumber,promotionDate,currentSalaryGrade,
				CONVERT(varchar(12),promotionDate,106) as promotionDt,
                promotedSalaryGrade,Ten_Per_Next_Sg_Mid,Per_Of_Increment,Max_Quartile,
                Difference,Toggle,Promotion_Effective_From,Current_Initial_Salary,
                promotedInitialSalary,Closed
				from PromotionBuffer p 
				inner join EmpEmployeeInfoMain e on e.employeeNumber = p.employeeNumber  
				where  $where  order by promotionDate desc");
		//echo $statement->getSql();
		//exit;
		return $statement->execute();
	}
	
	public function mismatchReport($company,$values) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$where = " isActive = '1'  ";
		if($values['departmentMismatch']) {
		    $where .= " and d.id = '".$values['departmentMismatch']."' ";
		}
	    if($values['mismatchJobGrade']) {
		    $where .= " and j.id = '".$values['mismatchJobGrade']."' ";
		}
	    if($values['empIdMismatch']) {
		    $where .= " and e.employeeNumber = '".$values['empIdMismatch']."' ";  
		}
		//$order = " order by c.effectiveDate,c.id ASC";
		$statement = $adapter->query("
				SELECT employeeName,departmentName,jobGrade,salaryGrade 
				FROM EmpEmployeeInfoMain AS e
				LEFT JOIN Position AS p ON P.id = e.empPosition
				LEFT JOIN section AS se ON se.id = p.section 
				LEFT JOIN Department AS d ON d.id = se.department 
				LEFT JOIN lkpSalaryGrade AS s ON s.id = e.empSalaryGrade 
				LEFT JOIN lkpJobGrade AS j ON j.id = e.empJobGrade 
				INNER JOIN Company AS c ON c.id = e.companyId 
				LEFT JOIN lkpBank AS b ON b.id = e.empBank 
				where  $where  and (jobGrade > salaryGrade) order by employeeName ASC");
		//echo $statement->getSql();
		//exit;
		return $statement->execute();
	}
	
}