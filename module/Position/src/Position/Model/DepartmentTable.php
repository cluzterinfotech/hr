<?php
/*
namespace Position\Model;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Predicate;
use Position\Model\Department;
use Position\Model\UserInfo;

class DepartmentTable {
	private $mainTableGateway, $historyTableGateway, $dbConnection;
	public function __construct($mainTableGateway, $historyTableGateway) {
		$this->mainTableGateway = $mainTableGateway;
		$this->historyTableGateway = $historyTableGateway;
		$this->dbConnection = $mainTableGateway->getAdapter ()->getDriver ()->getConnection ();
	}
	public function fetchAll($adapter) {
		// return $this->mainTableGateway->select();
		$sql = new Sql ( $adapter );
		
		$select = $sql->select ();
		$select->from ( 'Department' )->columns ( array (
				'*' 
		) );
		// var_dump($select);
		// exit;
		return $select;
	}
	public function isDuplicate(Department $department) {
		// Check whether name or code is exist in main table
		$rowset = $this->mainTableGateway->select ( function (Select $select) use($department) {
			$where = new Where ();
			$where->NotEqualTo ( 'departmentId', $department->getDepartmentId () )->AND->NEST-> // start braket
equalTo ( 'departmentName', $department->getDepartmentName () )->OR->equalTo ( 'deptFunctionCode', $department->getDeptFunctionCode () )->UNNEST; // close braket
			$select->where ( $where );
			// \Zend\Debug\Debug::dump($select->getSqlString()) ;
		} );
		
		$row = $rowset->current ();
		if ($row) {
			return true;
		}
		
		// Check whether name or code is exist and the record status should be approved in history table
		$rowset = $this->historyTableGateway->select ( function (Select $select) use($department) {
			$where = new Where ();
			$where->NotEqualTo ( 'departmentId', $department->getDepartmentId () )->AND->NEST-> // start braket
equalTo ( 'departmentName', $department->getDepartmentName () )->OR->equalTo ( 'deptFunctionCode', $department->getDeptFunctionCode () )->UNNEST-> // close braket
AND->NEST-> // start braket
equalTo ( 'recordStatus', 2 )->OR->equalTo ( 'recordStatus', 1 )->UNNEST; // close braket
			$select->where ( $where );
		} );
		$row = $rowset->current ();
		if ($row) {
			return true;
		}
		
		return false;
	}
	
	
	public function doesExist($id) {
		$rowset = $this->mainTableGateway->select ( array (
				'departmentId' => $id 
		) );
		if ($rowset->count ()) {
			return true;
		}
		return false;
	}
	public function getDepartment($id, $table) {
		$id = ( int ) $id;
		if ($table == 'main') {
			$rowset = $this->mainTableGateway->select ( function (Select $select) use($id) {
				$select->where ( array (
						'departmentId' => $id 
				) );
			} );
		} else if ($table == 'history') {
			$rowset = $this->historyTableGateway->select ( function (Select $select) use($id) {
				$select->where ( array (
						'departmentId' => $id 
				) );
				$select->order ( 'addedDate Desc' );
			} );
		} else {
			throw new \Exception ( "Could not find table" );
		}
		
		$row = $rowset->current ();
		if (! $row) {
			throw new \Exception ( "Could not find row $id" );
		}
		return $row;
	}
	public function getNonApproval() {
		$results = $this->historyTableGateway->select ( array (
				'recordStatus' => 1 
		) );
		return $results;
	}
	public function approveDepartment(Department $department, $status, UserInfo $user) {
		try {
			$this->dbConnection->beginTransaction ();
			
			if ($status == 2) {
				$data = array (
						'departmentId' => $department->getDepartmentId (),
						'departmentName' => $department->getDepartmentName (),
						'deptFunctionCode' => $department->getDeptFunctionCode (),
						'noOfWorkDays' => $department->getNoOfWorkDays (),
						'deptAssistantPositionId' => $department->getDeptAssistantPositionId (),
						'workHoursPerDay' => $department->getWorkHoursPerDay () 
				);
				
				$id = ( int ) $department->getDepartmentId ();
				if ($this->doesExist ( $id )) {
					$this->mainTableGateway->update ( $data, array (
							'departmentId' => $id 
					) );
				} else {
					$this->mainTableGateway->insert ( $data );
				}
			}
			
			$data ['updatedUser'] = $user->getName ();
			$data ['updatedDate'] = new \Zend\Db\Sql\Expression ( 'NOW()' );
			$data ['recordStatus'] = $status;
			
			$id = ( int ) $this->getDepartment ( $department->getDepartmentId (), 'history' )->getId ();
			$this->historyTableGateway->update ( $data, array (
					'id' => $id 
			) );
			
			$this->dbConnection->commit ();
			return 1234;
		} catch ( \Zend\Db\Exception $e ) {
			$this->dbConnection->rollBack ();
			\Zend\Debug\Debug::dump ( $e->getMessage () );
			return $e->getMessage ();
		}
	}
	public function saveDepartment(Department $department, UserInfo $user) {
		try {
			if ($this->isDuplicate ( $department ))
				return 0;
			
			$this->dbConnection->beginTransaction ();
			
			$data = array (
					'updatedUser' => $user->getName (),
					'updatedDate' => new \Zend\Db\Sql\Expression ( 'NOW()' ),
					'recordStatus' => 3 
			);
			
			$id = ( int ) $department->getId ();
			$this->historyTableGateway->update ( $data, array (
					'id' => $id 
			) );
			
			$data = array (
					'departmentId' => $department->getDepartmentId (),
					'departmentName' => $department->getDepartmentName (),
					'deptFunctionCode' => $department->getDeptFunctionCode (),
					'noOfWorkDays' => ( int ) $department->getNoOfWorkDays (),
					'deptAssistantPositionId' => ( int ) $department->getDeptAssistantPositionId (),
					'workHoursPerDay' => ( int ) $department->getWorkHoursPerDay (),
					'addedUser' => $user->getName (),
					'addedDate' => new \Zend\Db\Sql\Expression ( 'NOW()' ),
					'recordStatus' => 1 
			);
			
			$this->historyTableGateway->insert ( $data );
			
			$this->dbConnection->commit ();
			return 1234;
		} catch ( \Zend\Db\Exception $e ) {
			$this->dbConnection->rollBack ();
			\Zend\Debug\Debug::dump ( $e->getMessage () );
			return $e->getMessage ();
		}
	}
	public function getLastInsertedDepartmentId() {
		$rowset = $this->historyTableGateway->select ( function (Select $select) {
			$select->order ( 'departmentId Desc' );
		} );
		$row = $rowset->current ();
		if (! $row) {
			// no records in the table
			return 0;
		}
		return $row->getDepartmentId ();
	}
	public function objtoArray() {
		$getDepartments = $this->fetchAll ();
		$array = array ();
		foreach ( $getDepartments as $arr ) {
			$array [$arr->getDepartmentId ()] = $arr->getDepartmentName ();
		}
		return $array;
	}
}



*/
