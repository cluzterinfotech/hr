<?php

namespace Application\Mapper;

use Application\Abstraction\AbstractDataMapper,  
    Zend\Db\Adapter\Adapter as zendAdapter,
    Application\Model\MailTest;
use Zend\Db\Sql\Expression;

class MailMapper extends AbstractDataMapper {
	
	protected $entityTable = "MailTest";
    	
	protected function loadEntity(array $row) {
		 $entity = new MailTest();
		 return $this->arrayToEntity($row,$entity);
	}
	
	public function getEmailIdByEmployee($employeeId) {
	    //return array('empEmail' => 'doaa.m.osman@oilenergyco.com','employeeName' => 'doaa osman'); 
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => 'EmpEmployeeInfoMain'))
	           ->columns(array('empEmail','employeeName'))
	           ->where(array('employeeNumber' => $employeeId));
	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    //echo $sqlString;
	    //exit;
	    $results = $this->adapter->query($sqlString)->execute()->current();
	    if($results) {
	        return $results;
	    }
	    return 0;
		//return 'Fajr.H.Ahmed@oilenergyco.com'; 
        //return 'dhayal.impact@yahoo.co.in';
	}
	
	
	public function fetchAlertById($id) {
	    $sql = $this->getSql();
	    $select = $sql->select();
	    $select->from(array('e' => 'alerts'))
	    ->columns(array('mainid'=>'id' ))
	    ->join(array('am' => 'AlertsEmail'),'e.id = am.id',
	        array('PositionId' , 'isCc' , 'alertId' , 'id'))
	    ->where(array(
	        'am.id' => $id
	    ));

	    $sqlString = $sql->getSqlStringForSqlObject($select);
	    $results = $this->adapter->query($sqlString)->execute();
	    $results = $this->toArrayList($results,'id', 'alertId' ,'PositionId' , 'isCc' );
	    $entity = $this->loadEntity($results);
	    //echo \Zend\Debug\Debug::dump( $entity );
	    //exit;
	    $entity = $this->identityMap->set($id,$entity);
	    
	   // echo $sqlString;
	    //exit;
	    return $entity; 
	   // return $this->toArrayList($results,'Id','PositionId' , 'isCc' );
	} 

}