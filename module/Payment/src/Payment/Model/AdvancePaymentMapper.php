<?php
namespace Payment\Model;

use Application\Abstraction\AbstractDataMapper;   
use Employee\Model\Location; 
use Zend\Db\Sql\Predicate\Predicate;

class AdvancePaymentMapper extends AbstractDataMapper {
	
	protected $entityTable = "AdvanceHousingInfo"; 
	
	protected $paymentBuffer = "AdvancePaymentBuffer";
	
	protected $personalLoanBuffer = "PersonalLoanBuffer";  
	
	protected $advanceSalaryBuffer = "AdvanceSalaryBuffer"; 
	
	protected $repaymentTable = "RepaymentAdvance";
    	
	protected function loadEntity(array $row) {  
		 $entity = new Location();  
		 return $this->arrayToEntity($row,$entity); 
	}  
	
    // Advance housing 
    public function selectAdvanceHousing() {
    	$sql = $this->getSql(); 
    	$select = $sql->select(); 
    	$select->from(array('e' => $this->entityTable))
    	       ->columns(array('id','employeeId','paidDate','advanceFromDate',
                               'advanceToDate','totalMonths','advanceAmount',
                               'taxAmount','netAmount','groupId','isClosed'
    	       		)) 
    	       ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeId',
    	              array('employeeName')) 
    	       ->where(array('isClosed' => 0)) 
    	; 
    	//echo $select->getSqlString(); 
    	//exit; 
    	return $select; 
    } 
    
    public function selectRepayment() {
        $sql = $this->getSql();
        $select = $sql->select();
        $select->from(array('e' => $this->repaymentTable))
                ->columns(array('id','employeeId','advanceType','monthsPending',
                    'monthsPaying','amountPending','amountPaying','notes','isClosed'
                ))
                ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeId',
                    array('employeeName'))
                ->where(array('isClosed' => 0))
        ;
        //echo $select->getSqlString();
        //exit;
        return $select;
    }
    
    public function selectAdvanceSalary() {
    	$sql = $this->getSql();
    	$select = $sql->select();
    	$select->from(array('e' => $this->advanceSalaryBuffer))
	    	   ->columns(array('*'))
    	->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeNumberAdvSalary',
    		   array('employeeName'))
    	//->where(array('isClosed' => 0))
    	;
    	//echo $select->getSqlString();
    	//exit;
    	return $select;
    }
    
    public function selectPersonalLoan() {
    	$sql = $this->getSql();
    	$select = $sql->select();
    	$select->from(array('p' => 'PersonalLoanBuffer'))
		       ->columns(array('*'))
		    	->join(array('ep' => 'EmpEmployeeInfoMain'),
		    			'ep.employeeNumber = p.employeeNumberPersonalLoan',
    			             array('employeeName'))
    			//->where(array('isClosed' => 0))
    	; 
    	//echo $select->getSqlString();
    	//exit;
    	return $select; 
    }   
    
    public function selectSpecialLoan() {
        $sql = $this->getSql();
        $select = $sql->select();
        $select->from(array('p' => 'SpecialLoanBuffer'))
               ->columns(array('*'))
               ->join(array('ep' => 'EmpEmployeeInfoMain'),
                          'ep.employeeNumber = p.employeeNumberSpecialLoan',
            array('employeeName'))
            //->where(array('isClosed' => 0))
        ;
        //echo $select->getSqlString();
        //exit;
        return $select;
    }
    
    public function selectSpecialLoanDue() {
        $sql = $this->getSql();
        $select = $sql->select();
        $select->from(array('m' => 'SpecialLoanMst'))
               ->columns(array('loanAmount'))
               ->join(array('d' => 'SpecialLoan'),'m.id = d.mstId',
                   array('dueAmount','paidStatus'))
               ->join(array('ep' => 'EmpEmployeeInfoMain'),
                            'ep.employeeNumber = m.employeeId',
                      array('employeeName'))
            //->where(array('isClosed' => 0))
        ;
        //echo $select->getSqlString(); 
        //exit;
        return $select; 
    }
    	
    public function getAdvanceHousingList() {
    	$sql = $this->getSql();
    	$select = $sql->select();
    	$select->from(array('e' => $this->entityTable))
    	       ->columns(array('id','employeeId','paidDate','advanceFromDate',
    			               'advanceToDate','totalMonths','advanceAmount',
    			               'taxAmount','netAmount','groupId','isClosed'
    	       ))
    	      // ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeId',
    			      //array('employeeName'))
    		   ->where(array('isClosed' => 0))
    	; 
    	//echo $select->getSqlString(); 
        //exit; 
    	$sqlString = $sql->getSqlStringForSqlObject($select); 
    	return $this->adapter->query($sqlString)->execute();  
    } 
    
    public function getAdvanceSalaryList() {
    	$sql = $this->getSql();
    	$select = $sql->select();
    	$select->from(array('e' => $this->advanceSalaryBuffer))
    	       ->columns(array('*'))
    	// ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeId',
    	//array('employeeName'))
    	// ->where(array('isClosed' => 0))
    	;
    	//echo $select->getSqlString();
    	//exit;
    	$sqlString = $sql->getSqlStringForSqlObject($select);
    	return $this->adapter->query($sqlString)->execute();
    }
    
    public function getPersonalLoanList() {
    	$sql = $this->getSql();
    	$select = $sql->select();
    	$select->from(array('e' => $this->personalLoanBuffer))
	    	   ->columns(array('*'))
    	// ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeId',
    	//array('employeeName'))
    	      //->where(array('isClosed' => 0))
    	;
    	//echo $select->getSqlString();
    	//exit;
    	$sqlString = $sql->getSqlStringForSqlObject($select);
    	return $this->adapter->query($sqlString)->execute();
    }
    
    public function getSpecialLoanList() {
        $sql = $this->getSql();
        $select = $sql->select();
        $select->from(array('e' => 'SpecialLoanBuffer'))
               ->columns(array('*'))
        // ->join(array('ep' => 'EmpEmployeeInfoMain'),'ep.employeeNumber = e.employeeId',
        //array('employeeName'))
        //->where(array('isClosed' => 0))
        ;
        //echo $select->getSqlString();
        //exit;
        $sqlString = $sql->getSqlStringForSqlObject($select);
        return $this->adapter->query($sqlString)->execute();
    }
    
    public function getThisMonthEmpAdvPaymentDue($advancePayment,$employeeId,
    		DateRange $dateRange) {  
    	$adapter = $this->adapter;  
    	$qi = function($name) use ($adapter) {
    		return $adapter->platform->quoteIdentifier($name); 
    	}; 
    	$fp = function($name) use ($adapter) { 
    		return $adapter->driver->formatParameterName($name); 
    	};   
    	$mst = $advancePayment."Mst"; 
    	$statement = $adapter->query("select top 1 d.id,d.dueAmount AS dueAmount
    			from ".$qi($mst)." as m 
    			INNER JOIN ".$qi($advancePayment)." AS d ON m.id = d.mstId 
    			where 
				deuStartingDate  <= '".$dateRange->getFromDate()."' and
    			employeeId  = '".$employeeId."' and
			    paidStatus = 0
		");    
    	//echo $statement->getSql()."<br/>";   
    	//exit;  
    	$results = $statement->execute()->current(); 
    	if($results) { 
    		return $results; 
    	} 
    	return 0; 
    } 
    
    public function getSpecialLoanDueAmount($employeeId) {
            //return array('id' => '12','dueAmount' => '45000'); 
            $adapter = $this->adapter;
            $qi = function($name) use ($adapter) {
                return $adapter->platform->quoteIdentifier($name);
            };
            $fp = function($name) use ($adapter) {
                return $adapter->driver->formatParameterName($name);
            };
            $mst = $advancePayment."Mst";
            $statement = $adapter->query("select top 1 d.id,d.dueAmount AS dueAmount
    			from ".$qi('SpecialLoanMst')." as m
    			INNER JOIN ".$qi('SpecialLoan')." AS d ON m.id = d.mstId
    			where 
    			employeeId  = '".$employeeId."' and
			    paidStatus = 0
		    "); 
            //echo $statement->getSql()."<br/>";
            //exit;
            $results = $statement->execute()->current();
            if($results) {
                return $results;
            }
            return 0;
    } 
    
    public function closeRepaymentRec($id) {
        $adapter = $this->adapter;
        $qi = function($name) use ($adapter) {
            return $adapter->platform->quoteIdentifier($name);
        };
        $fp = function($name) use ($adapter) {
            return $adapter->driver->formatParameterName($name);
        };
        $mst = $advancePayment."Mst";
        $statement = $adapter->query("
                 update RepaymentAdvance set isClosed = 1
                 where id = ".$id."  
		    ");
        //echo $statement->getSql()."<br/>";
        //exit;
        $statement->execute();
    }
    
    public function closeAdvPaymentDue($advancePayment,$employeeId,$months) {
        $adapter = $this->adapter;
        $qi = function($name) use ($adapter) {
            return $adapter->platform->quoteIdentifier($name);
        };
        $fp = function($name) use ($adapter) {
            return $adapter->driver->formatParameterName($name);
        };
        $mst = $advancePayment."Mst"; 
        $statement = $adapter->query("
                 update ".$advancePayment." set paidStatus = 1, deductionDate = '".date('Y-m-d')."'
                 where id in (
                     select top ".$months." d.id 
                     from ".$qi($advancePayment)." as d
                     inner join ".$qi($mst)." as m on m.id = d.mstId
                     where employeeId = '".$employeeId."' and paidStatus = 0
                 ) 
		    ");   
        //echo $statement->getSql()."<br/>"; 
        //exit; 
        $statement->execute(); 
        //if($results) { 
            //return $results; 
        //} 
        //return 0; 
    } 
    
    public function getSumEmpAdvPaymentDue($advancePayment,$employeeId) {
            $adapter = $this->adapter;
            $qi = function($name) use ($adapter) {
                return $adapter->platform->quoteIdentifier($name);
            };
            $fp = function($name) use ($adapter) {
                return $adapter->driver->formatParameterName($name);
            };
            $mst = $advancePayment."Mst";
            $statement = $adapter->query("select count(d.id) as tot,sum(d.dueAmount) AS totAmount
    			from ".$qi($mst)." as m
    			INNER JOIN ".$qi($advancePayment)." AS d ON m.id = d.mstId
    			where
    			employeeId  = '".$employeeId."' and
			    paidStatus = 0
		    "); 
            //echo $statement->getSql()."<br/>";
            //exit;
            $results = $statement->execute()->current();
            if($results) {
                return $results;
            }
            return 0;
    }
    
    public function getTotalEmpAdvPaymentDue($advancePayment,$employeeId) { 
    	$adapter = $this->adapter;
    	$qi = function($name) use ($adapter) {
    		return $adapter->platform->quoteIdentifier($name);
    	};
    	$fp = function($name) use ($adapter) {
    		return $adapter->driver->formatParameterName($name);
    	};
    	$mst = $advancePayment."Mst";
    	$statement = $adapter->query("select sum(d.dueAmount) AS dueAmount
    			from ".$qi($mst)." as m
    			INNER JOIN ".$qi($advancePayment)." AS d ON m.id = d.mstId
    			where
				
    			employeeId  = '".$employeeId."' and
			    paidStatus = 0
		"); 
    	//echo $statement->getSql()."<br/>"; 
    	//exit; 
    	$results = $statement->execute()->current(); 
    	if($results['dueAmount']) { 
    		return number_format($results['dueAmount'],2,'.','');   
    	}   
    	return 0;    
    }  
    
    public function getFeCarLoanAmortization($advancePayment,$employeeId) {
        // CarAmortization
        $adapter = $this->adapter;
        $qi = function($name) use ($adapter) {
            return $adapter->platform->quoteIdentifier($name);
        };
        $fp = function($name) use ($adapter) {
            return $adapter->driver->formatParameterName($name);
        };
        $mst = $advancePayment."Mst";
        $statement = $adapter->query("select id,employeeNumber,paidDate,
                                      paidAmount,numberOfMonths from ".$qi($advancePayment)."
    			where  employeeNumber  = '".$employeeId."' 
		"); 
        //echo $statement->getSql()."<br/>";
        //exit;
        $row = $statement->execute()->current();
        if($row) {
            return $row; 
        }
        return 0;
    } 
     
    public function isHaveAdvanceHousingRecords() {
    	$sql = $this->getSql();
    	$select = $sql->select();
    	$select->from(array('e' => $this->entityTable))
    	       ->columns(array('id')) 
    		   ->where(array('isClosed' => 0))
    	; 
    	//echo $select->getSqlString();
    	//exit; 
    	$sqlString = $sql->getSqlStringForSqlObject($select);
    	$results = $this->adapter->query($sqlString)->execute()->current(); 
    	//var_dump($results);
    	//exit; 
        if($results['id']) {
        	return 1;
        } 
        return 0; 
    } 
    
    public function isHaveRepaymentRecords() {
        $sql = $this->getSql();
        $select = $sql->select();
        $select->from(array('e' => $this->repaymentTable))
               ->columns(array('id'))
               ->where(array('isClosed' => 0))
        ;
        //echo $select->getSqlString();
        //exit;
        $sqlString = $sql->getSqlStringForSqlObject($select);
        $results = $this->adapter->query($sqlString)->execute()->current();
        //var_dump($results);
        //exit;
        if($results['id']) {
            return 1;
        }
        return 0;
    } 
    
    public function getRepaymentRecords() {
        $sql = $this->getSql();
        $select = $sql->select();
        $select->from(array('e' => $this->repaymentTable))
               ->columns(array('*'))
               ->where(array('isClosed' => 0))
        ;
        //echo $select->getSqlString();
        //exit;
        $sqlString = $sql->getSqlStringForSqlObject($select);
        $results = $this->adapter->query($sqlString)->execute();
        //var_dump($results);
        //exit;
        if($results) {
            return $results;
        }
        return 0;
    }
    
    public function isHaveAdvanceSalaryRecords() {
    	$sql = $this->getSql();
    	$select = $sql->select();
    	$select->from(array('e' => $this->advanceSalaryBuffer))
    	       ->columns(array('id'))
    	       //->where(array('isClosed' => 0))
    	;
    	//echo $select->getSqlString();
    	//exit;
    	$sqlString = $sql->getSqlStringForSqlObject($select);
    	$results = $this->adapter->query($sqlString)->execute()->current();
    	//var_dump($results);
    	//exit;
    	if($results['id']) {
    		return 1;
    	}
    	return 0;
    }
    
    public function isHavePersonalLoanRecords() {
    	$sql = $this->getSql();
    	$select = $sql->select();
    	$select->from(array('e' => $this->personalLoanBuffer))
    	       ->columns(array('id'))
    	       //->where(array('isClosed' => 0))
    	;
    	//echo $select->getSqlString();
    	//exit;
    	$sqlString = $sql->getSqlStringForSqlObject($select);
    	$results = $this->adapter->query($sqlString)->execute()->current();
    	//var_dump($results);
    	//exit;
    	if($results['id']) {
    		return 1;
    	}
    	return 0;
    }
    
    public function getAdvanceHousing($employee,$dateRange) {
    	// @todo implementation 
    	return 0; 
    }
	
	public function insertAdvanceHousing($data) {
		$sql = $this->getSql(); 
		$insert = $sql->Insert($this->entityTable);  
		$insert->values($data);
		$sqlString = $sql->getSqlStringForSqlObject($insert); 
		$this->adapter->query($sqlString)->execute();	
	}
	
	public function insertRepayment($data) {
	    $sql = $this->getSql();
	    $insert = $sql->Insert($this->repaymentTable);
	    $insert->values($data);
	    $sqlString = $sql->getSqlStringForSqlObject($insert);
	    $this->adapter->query($sqlString)->execute();
	}
	
	public function insertAdvanceSalary($data) {
		$sql = $this->getSql();
		$insert = $sql->Insert($this->advanceSalaryBuffer);
		$insert->values($data);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute();
	}
	
	public function insertPersonalLoan($data) {
		$sql = $this->getSql();
		$insert = $sql->Insert('PersonalLoanBuffer');
		$insert->values($data);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute(); 
	} 
	
	public function insertSpecialLoan($data) {
	    $sql = $this->getSql();
	    $insert = $sql->Insert('SpecialLoanBuffer'); 
	    $insert->values($data);
	    $sqlString = $sql->getSqlStringForSqlObject($insert);
	    $this->adapter->query($sqlString)->execute();
	}
	
	public function insertPersonalLoanMst($data,$tableName = "") {
		$sql = $this->getSql();
		$insert = $sql->Insert('PersonalLoanMst');
		$insert->values($data);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$res = $this->adapter->query($sqlString)->execute();
		return  $res->getGeneratedValue();
	}
	
	public function insertSpecialLoanMst($data,$tableName = "") {
	    $sql = $this->getSql();
	    $insert = $sql->Insert('SpecialLoanMst');
	    $insert->values($data);
	    $sqlString = $sql->getSqlStringForSqlObject($insert);
	    $res = $this->adapter->query($sqlString)->execute();
	    return  $res->getGeneratedValue();
	}
	
	public function insertPersonalLoanDtls($data,$tableName = "") {
		$sql = $this->getSql();
		$insert = $sql->Insert('PersonalLoan'); 
		$insert->values($data);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute();
	} 
	
	public function insertSpecialLoanDtls($data,$tableName = "") {
	    $sql = $this->getSql();
	    $insert = $sql->Insert('SpecialLoan'); 
	    $insert->values($data);
	    $sqlString = $sql->getSqlStringForSqlObject($insert);
	    $this->adapter->query($sqlString)->execute();
	} 
	
	public function insertAdvanceHousingMst($data,$tableName = "") {
		$sql = $this->getSql();
		$insert = $sql->Insert('AdvanceHousingMst'); 
		$insert->values($data);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$res = $this->adapter->query($sqlString)->execute(); 
		return  $res->getGeneratedValue();
	}
	
	public function insertAdvanceHousingDtls($data,$tableName = "") {
		$sql = $this->getSql(); 
		$insert = $sql->Insert('AdvanceHousing'); 
		$insert->values($data);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute();
	}
	
	public function insertAdvanceSalaryMst($data,$tableName = "") {
		$sql = $this->getSql();
		$insert = $sql->Insert('AdvanceSalaryMst');
		$insert->values($data);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$res = $this->adapter->query($sqlString)->execute();
		return  $res->getGeneratedValue();
	}
	
	public function insertAdvanceSalaryDtls($data,$tableName = "") {
		$sql = $this->getSql();
		$insert = $sql->Insert('AdvanceSalary');
		$insert->values($data);
		$sqlString = $sql->getSqlStringForSqlObject($insert);
		$this->adapter->query($sqlString)->execute();
	}
	
	public function removeAdvanceHousing($id) { 
		$sql = $this->getSql();
		$delete = $sql->delete($this->entityTable);
		$delete->where(array(
				'id' => $id
		));
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	}
	
	public function removeRepayment($id) {
	    $sql = $this->getSql();
	    $delete = $sql->delete($this->repaymentTable);
	    $delete->where(array(
	        'id' => $id
	    ));
	    //$sqlString = $delete->getSqlString();
	    $sqlString = $sql->getSqlStringForSqlObject($delete);
	    return $this->adapter->query($sqlString)->execute()->count(); 
	}
	
	public function removeAdvanceSalary($id) {
		$sql = $this->getSql();
		$delete = $sql->delete($this->advanceSalaryBuffer);
		$delete->where(array(
				'id' => $id
		));
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	}
	
	public function removePersonalLoan($id) {
		$sql = $this->getSql();
		$delete = $sql->delete('PersonalLoanBuffer');
		$delete->where(array(
				'id' => $id
		));
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	} 
	
	public function removeSpecialLoan($id) {
	    $sql = $this->getSql();
	    $delete = $sql->delete('SpecialLoanBuffer'); 
	    $delete->where(array(
	        'id' => $id
	    ));
	    //$sqlString = $delete->getSqlString();
	    $sqlString = $sql->getSqlStringForSqlObject($delete);
	    return $this->adapter->query($sqlString)->execute()->count();
	}
	
	public function addThisMonthDue($due) { 
		$sql = $this->getSql(); 
		$insert = $sql->Insert($this->paymentBuffer); 
		$insert->values($due); 
		$sqlString = $sql->getSqlStringForSqlObject($insert); 
		$this->adapter->query($sqlString)->execute(); 
	} 
	
	public function removeThisMonthDue(Company $company) { 
		$sql = $this->getSql();
		$delete = $sql->delete($this->paymentBuffer); 
		$delete->where(array(
				'companyId' => $company->getId() 
		)); 
		//$sqlString = $delete->getSqlString(); 
		$sqlString = $sql->getSqlStringForSqlObject($delete); 
		return $this->adapter->query($sqlString)->execute()->count(); 
	} 
	
	public function getThisMonthDueList(Company $company) { 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('e' => $this->paymentBuffer))
		       ->columns(array('id','dtlsId','advancePaymentTable'))
		       ->where(array('companyId' => $company->getId()))
		;
		//echo $select->getSqlString();
		//exit;
		$sqlString = $sql->getSqlStringForSqlObject($select);
		$results = $this->adapter->query($sqlString)->execute();
		//var_dump($results);
		//exit;
		return $results;
	}
	
	public function closeAdvancePaymentDeduction($dtlsId,$advTable) {
		$adapter = $this->adapter;
		$qi = function($name) use ($adapter) {
			return $adapter->platform->quoteIdentifier($name);
		};
		$fp = function($name) use ($adapter) {
			return $adapter->driver->formatParameterName($name);
		};
		$statement = $adapter->query("update  ".$qi($advTable)." set
				    paidStatus = 1 where 
					id   = '".$dtlsId."'    
		");  
		// echo $statement->getSql();  
		// exit;  
		$statement->execute();   
	}  
	
	public function removeFromBuffer($bufferId) {
		$sql = $this->getSql();
		$delete = $sql->delete($this->paymentBuffer);
		$delete->where(array(
				'id' => $bufferId
		)); 
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	}
	
}