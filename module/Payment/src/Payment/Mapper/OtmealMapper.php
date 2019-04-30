<?php 
namespace Payment\Mapper;

use Payment\Model\OvertimeMst,
    Application\Abstraction\AbstractDataMapper, 
    Application\Contract\EntityCollectionInterface, 
    Application\Contract\DataMapperInterface, 
    Zend\Db\Adapter\Adapter as zendAdapter;
use Zend\Db\Sql\Expression;

class OtmealMapper extends AbstractDataMapper {
	
	protected $entityTable = "OvertimeMst";
    	
	protected function loadEntity(array $row) {
		 $entity = new OvertimeMst();
		 return $this->arrayToEntity($row,$entity);
	}
//*******************************get overtime batch************************
public function getOvertimeBatchList() {
		//echo 'AAAAAAAAAAAAAAAAAAAAAAAAAAAA';exit;
                $sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('e' => 'OvertimeMealMst'))
		       ->columns(array('OvertimeMealMstId','CompanyId','Month','PreparedBy','ApprovedBy','Status','IsPosted','Approve_Date','Apply_Date'))
                       ->where (array('Status' =>'0',
                                    'IsPosted'=>'false'
                           )
                               )   
		;
//		echo $select->getSqlString();
//		exit;
		return $select;
	}
 public function getCurrentOvertimeBatch() {
     
        $adapter = $this->adapter;
        $qi = function($name) use ($adapter) {
                    return $adapter->platform->quoteIdentifier($name);
                };
        $fp = function($name) use ($adapter) {
                    return $adapter->driver->formatParameterName($name);
                };
                
        $statement1 = $adapter->query("SELECT OvertimeMealMstId  FROM OvertimeMealMst
            WHERE     (Status = 0) AND (IsPosted = 'false') ");
//       echo $statement1->getSql();        
//        exit;
        $rowset = $statement1->execute();        
        $res = $rowset->current();
        //return $res;
        if ($res) {
           return $res['OvertimeMealMstId'];
            //echo $res;
        } else {
            return 0;
        }
               	}
//*************************************************************************        
	public function getOvertimeList() {
		$sql = $this->getSql(); 
		$select = $sql->select(); 
		$select->from(array('d' => 'mealDtls'))
		       ->columns(array('*')) 
		       ->join(array('e' => 'EmpEmployeeInfoMain'),'d.employeeId = e.employeeNumber',
		       		array('employeeName'))
		       ->where (array('d.Status' =>'0'))
		       //->join(array('l' => 'Location'), 'e.locationId = l.id', 
		       		//array('locationName'))
		;
		//echo $select->getSqlString();
		//exit;
		return $select;
	}
	
	public function saveOverTime($data) {
           //  \Zend\Debug\Debug::dump($data); exit;
		$sql = $this->getSql(); 
		$insert = $sql->Insert('mealDtls'); 
		$insert->values($data); 
		$sqlString = $sql->getSqlStringForSqlObject($insert);  
                // echo $sql->getSqlStringForSqlObject($insert);  exit;
		$res = $this->adapter->query($sqlString)->execute($sqlString); 
		return $res->getGeneratedValue(); 
             // \Zend\Debug\Debug::dump($res); exit;
	} 
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
  public function saveOverTimeBatch($data) {
		$sql = $this->getSql(); 
                if($this->getCurrentOvertimeBatch()==0){
		$insert = $sql->Insert('OvertimeMealMst'); 
		$insert->values($data); 
		$sqlString = $sql->getSqlStringForSqlObject($insert);  
                //echo $sql->getSqlStringForSqlObject($insert);  exit;
		$res = $this->adapter->query($sqlString)->execute($sqlString); 
                \Zend\Debug\Debug::dump($res); exit;
                 return $res->getGeneratedValue(); 
                
                }
 elseif($this->getCurrentOvertimeBatch()<>0){
    // echo 'Erorr';
     return 0;
  }
             // \Zend\Debug\Debug::dump($res); exit;
	}       
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//************************************Apply overtime******************************************************
//3----------- to insert data into table and update the temperary table and remove the grid	
      public function applyOverTime($data ,$data2) {
		$sql = $this->getSql();
               	$update = $sql->Update('OvertimeMealMst');
		$array = $this->entityToArray($data);
		$id = $array['OvertimeMealMstId'];
		unset($array['OvertimeMealMstId']);
		$update->set($array);
		$update->where(array(
			'OvertimeMealMstId' => $id
		)); 
		$sqlString = $update->getSqlString();  
		 
               
		$sqlString = $sql->getSqlStringForSqlObject($update); 
		//return 
               $this->adapter->query($sqlString)->execute()->count(); 
//**********************************for details updation
             
               $sql2 = $this->getSql();
               $update2 = $sql2->Update('OvertimeMealDtls');
            $array2 = $this->entityToArray($data2);
            $id = $array2['OvertimeMealMstId'];
            unset($array2['OvertimeMealMstId']);
            $update2->set($array2);
            $update2->where(array(
            'OvertimeMealMstId' => $id
            )); 
            $sqlString2 = $update2->getSqlString();  
         
         $sqlString2 = $sql2->getSqlStringForSqlObject($update2); 
            $res2=$this->adapter->query($sqlString2)->execute()->count();
              

return 1;
             // \Zend\Debug\Debug::dump($res); exit;
	}   
      
//**************************************************************************************************        
	public function isEmployeeAlreadyInCurrentBatch($employeeId) {
		
		return 0;
	}
	
	public function removeOverTime($id) {
        		
		$sql = $this->getSql();
		$delete = $sql->delete('mealDtls');
		$delete->where(array(
				'id' => $id
		)); 
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
		return $this->adapter->query($sqlString)->execute()->count();
	}
//***************************Remove Batch**********************************
        public function removeOvertimeBatch($id) {
		$sql = $this->getSql();
		$delete = $sql->delete('OvertimeMealMst');
		$delete->where(array(
				'OvertimeMealMstId' => $id
		)); 
		//$sqlString = $delete->getSqlString();
		$sqlString = $sql->getSqlStringForSqlObject($delete);
            //   echo $sql->getSqlStringForSqlObject($delete);  exit;
		return $this->adapter->query($sqlString)->execute()->count();
                /*
                 $sql2 = $this->getSql();
		$delete2 = $sql->delete('OvertimeMealDtls');
		$delete2->where(array(
				'OvertimeMealMstId' => $id
		)); 
		//$sqlString2 = $delete2->getSqlString();
		$sqlString2 = $sql2->getSqlStringForSqlObject($delete2);
		return $this->adapter->query($sqlString2)->execute()->count(); 
                  
                 
                 */
	}
/*((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((((       
        public function  checkEmployee() {
          	  $adapter = $this->adapter;
        $qi = function($name) use ($adapter) {
                    return $adapter->platform->quoteIdentifier($name);
                };
        $fp = function($name) use ($adapter) {
                    return $adapter->driver->formatParameterName($name);
                };
                
        $statement1 = $adapter->query("SELECT Emp_Mst_Id 
            FROM  Overtime_Dtls
            WHERE Overtime_Mst_Id =".$this->getCurrentOvertimeBatch());
//       echo $statement1->getSql();        
//        exit; 
         $rowset = $statement1->execute();        
        $res = $rowset->current();
        return $this->toArrayList($res,'employeeNumber');
        }
       	public function getEmployeeList() { 
		  $adapter = $this->adapter;
        $qi = function($name) use ($adapter) {
                    return $adapter->platform->quoteIdentifier($name);
                };
        $fp = function($name) use ($adapter) {
                    return $adapter->driver->formatParameterName($name);
                };
                $empNo=$this->checkEmployee();
        $statement1 = $adapter->query("SELECT id,employeeNumber,locationId ,ep.employeeName 
            FROM EmpEmployeeInfo as e join EmpPersonalInfo ep on ep.id = e.empPersonalInfoId
            WHERE e.id not in  ".$empNo['employeeNumber']);
       echo $statement1->getSql();        
        exit;
        $rowset = $statement1->execute();        
        $res = $rowset->current();
       if ($res) {
          return $this->toArrayList($res,'employeeNumber','employeeName');
            //echo $res;
        } else {
            return 0;
        }                
	}  
        
   /*)))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))))*/    
        
      
        
        
//************************************************************************
	public function getPositionNameById($positionId) {
		return 'admin';
	}
	
	public function getHigherPosition($id) { 
		return  array(
				'' => '',
				//'1' => 'Admin Assistant',
				'2' => $id." test",
				'3' => 'Manager'
		);
	} 
	
	public function getLevelByEmployee($employeeId) {
		// 
		$sql = $this->getSql();
		$select = $sql->select();
		$select->from(array('pe' => 'positionEmployee'))
		       ->columns(array('id','employeeId','positionId')) 
		       ->join(array('p' => 'Position'),'p.id = pe.positionId',
		              array('organisationLevel'))
		       ->where(array('employeeId' => $employeeId)) 
		; 
		$sqlString = $sql->getSqlStringForSqlObject($select); 
		$results = $this->adapter->query($sqlString)->execute()->current(); 
		return $results['organisationLevel'];
	}
	
	public function getImmediateSupervisorByEmployee($employeeId) {
		// if level is 1 no supervisor
		if($this->getLevelByEmployee($employeeId) == 1) {
		    return false;
		} 
		return $immediateSupervisor;
	}
	
	public function getHodByEmployee($employeeId) {
		// 
		return $hod;
	}
	
	// methods below here are for special 
	public function getHrManagerId() {
		// 
		return $hrManager;
	}
    
}