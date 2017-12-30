<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Application\Model\MailTest;
use Application\Model\Alert;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

class AlertMapper extends AbstractDataMapper {
	
	protected $entityTable = "AlertsEmail";
    	
	protected function loadEntity(array $row) {
		 $entity = new Alert();
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function getEmailIdByEmployee($employeeId) {
		return 'doaa.m.osman@oilenergyco.com'; 
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => 'EmpEmployeeInfoMain'))
	           ->columns(array('empEmail'))
	           ->where(array('employeeNumber' => $employeeId));
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    //echo $sqlString;
	    //exit;
	    $results = $this->adapter->query($sqlString)->execute()->current();
	    if($results) {
	        return $results['empEmail'];
	    }
	    return 0;
		//return 'Fajr.H.Ahmed@oilenergyco.com'; 
        //return 'dhayal.impact@yahoo.co.in';
	}
	public function getCcOptions(){
	   return  array("0" => 'No' ,
	          "1" => 'Yes' ,
	    );
	}
	
	public function  getAlertsTypesObj(){
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => 'alerts'))
	    ->columns(array('*' ))
	    ;
	   $sqlString = $sql->getSqlStringForSqlObject($select);

	   $results = $this->adapter->query($sqlString)->execute();
	   return $results;
	   //return $this->toArrayList($results,'id','alertType' , 'formula' );
	}
	public function  insertAlert($alert){
	    
	    
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    $statement = $adapter->query("UPDATE alerts SET formula =  ".$alert['formula']." WHERE id = ".$alert['alertId']);    
	   
	    $statement->execute();
	    
	    
	   /* $sql = $this->getSql();
	    $insert = $sql->insert('AlertsEmail');
	    $newData = array(
	        'positionId'=> $alert['positionId'],
	        'isCC'=> $alert['isCC'],
	        'alertId'=> $alert['alertId']
	    );
	    $insert->values($newData);
	    $selectString = $sql->getSqlStringForSqlObject($insert);
	    $results = $this->adapter->query($sqlString)->execute();*/
	    $sql = $this->getSql();
	    $insert = $sql->Insert('AlertsEmail');
	    $initialInfo = array(
	        'positionId'=> $alert['positionId'],
	        'isCC'=> $alert['isCC'],
	        'alertId'=> $alert['alertId']
	    );
	    $insert->values($initialInfo);
	    $sqlString = $sql->getSqlStringForSqlObject($insert);
	    $this->adapter->query($sqlString)->execute();
	    
	    
	    
	    
	    //echo \Zend\Debug\Debug::dump( $statement ); exit;
	    //return  $results;
	}
	public function  getAlertsTypes(){
	  /*  $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => 'alerts'))
	    ->columns(array('*' ))
	    ;
	    $sqlString = $sql->getSqlStringForSqlObject($select);

	    $results = $this->adapter->query($sqlString)->execute();
	   
	    $list = $this->toArrayList($results,'id','alertType' , 'formula' );
	    echo \Zend\Debug\Debug::dump( $list ); exit;
	    return $results;*/
	    return array( "1" => "Anniversary" , 
	                  "2" => "termination" , 
	                  "3" => "retirement" ,
	                  "4" => "new Employeement" 
                     );
	}
	public function  getAllAlerts(){
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => 'alerts'))
	    ->columns(array('alertId'=>'alertType' , 'formula' ))
	    ->join(array('am' => 'AlertsEmail'),'e.id = am.alertId',
	        array('isCC' , 'id'))
	    ->join(array('p' => 'Position'),'p.id = am.positionId',
	        array('positionName' => new Expression(" levelName+ ' ' +p.positionName")))
	    ->join(array('pl' => 'PositionLevel'),'pl.levelSequence = p.organisationLevel',
	        array('levelName'))
	    ;
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	  // echo $sqlString;
	   // exit; 
	    return $select; 
	   //$sqlString = $sql->getSqlStringForSqlObject($select);
	   //echo $sqlString;
	   //exit; 	   
	   //$results = $this->adapter->query($sqlString)->execute();

	   //return $this->toArrayList($results,'Id','alertType','positionName' , 'formula' , 'isCC');
	}
	public function  getToEmails($alertId){
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    $statement = $adapter->query(
	        "SELECT * FROM  EmpEmployeeInfoMain e INNER JOIN AlertsEmail a ON a.positionId = e.empPosition WHERE a.alertId = ".$alertId);
	    
	    
	    return $statement->execute();
	}
	public function  getAnnversaryEmp($formula){
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    $statement = $adapter->query(
	        "SELECT * FROM  EmpEmployeeInfoMain   WHERE 365 - DATEDIFF(DAY,empJoinDate , GETDATE()  )   = ".$formula);

	        
	    return $statement->execute();

	}
	public function  getTerminatedEmp($formula){
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    $statement = $adapter->query(
	        "SELECT * FROM  EmpEmployeeInfoMain   WHERE 365 - DATEDIFF(DAY,empJoinDate , GETDATE()  )   = ".$formula);

	        
	    return $statement->execute();

	}	
	public function  getRetirmentEmp($formula){
	    $adapter = $this->adapter;
	    $qi = function($name) use ($adapter) {
	        return $adapter->platform->quoteIdentifier($name);
	    };
	    $fp = function($name) use ($adapter) {
	        return $adapter->driver->formatParameterName($name);
	    };
	    $statement = $adapter->query(
	        "SELECT * FROM  EmpEmployeeInfoMain   WHERE 365 - DATEDIFF(DAY,empJoinDate , GETDATE()  )   = ".$formula);

	        
	    return $statement->execute();

	}	
	public function fetchAlertById($id) {
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => 'alerts'))
	    ->columns(array('mainid'=>'id' ))
	    ->join(array('am' => 'AlertsEmail'),'e.id = am.alertId',
	        array('PositionId' , 'isCc' , 'alertId' , 'id'))
	    ->where(array(
	        'am.id' => $id
	    ));

	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    $results = $this->adapter->query($sqlString)->execute()->current(); 
	   // $results = $this->toArrayList($results,'id', 'alertId' ,'PositionId' , 'isCc' );
	   // echo $sqlString;
	   // echo \Zend\Debug\Debug::dump( $results );
	   // exit;	    
	   // 
	    //exit;
	    return $results; 
	   // return $this->toArrayList($results,'Id','PositionId' , 'isCc' );
	} 
	public function DeleteAlertById($id) {
	    $sql = $this->getSql();
	    $delete = $sql->delete('AlertsEmail');
	    $delete->where(array(
	        'id' => $id
	    ));
	    //$sqlString = $delete->getSqlString();
	    $sqlString = $sql->getSqlStringForSqlObject($delete);
	    return $this->adapter->query($sqlString)->execute()->count();
	} 
}