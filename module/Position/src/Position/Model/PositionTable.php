<?php

namespace Position\Model;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Sql;
use Position\Model\Position;
use Position\Model\UserInfo;
use Zend\Db\ResultSet\ResultSet;

class PositionTable {
	private $mainTableGateway, $historyTableGateway, $dbConnection;
	public function __construct($mainTableGateway, $historyTableGateway) {
		// $this->adapter = $mainTableGateway;
		// $this->resultSetPrototype = new ResultSet();
		// $this->resultSetPrototype->setArrayObjectPrototype(new Position());
		$this->mainTableGateway = $mainTableGateway;
		$this->historyTableGateway = $historyTableGateway;
		$this->dbConnection = $mainTableGateway->getAdapter ()->getDriver ()->getConnection ();
		
		// $this->initialize();
	}
	public function fetchAll($adapter) {
		$sql = new Sql ( $adapter );
		
		$select = $sql->select ();
		$select->from ( 'position' )->columns ( array (
				'*' 
		) );
		// var_dump($select);
		// exit;
		return $select;
		// $resultSet = $this->mainTableGateway->select();
		// return $resultSet;
	}
	public function getHigherPosition($levelId) {
		$results = $this->mainTableGateway->select ( function (Select $select) use($levelId) {
			$select->where ( array (
					"positionLevelId < $levelId" 
			) );
		} );
		return $results;
	}
	public function isDuplicate(Position $position) {
		// Check whether combination of (name+level+code+section) are exist in main table
		$rowset = $this->mainTableGateway->select ( function (Select $select) use($position) {
			$select->where ( array (
					'positionName' => $position->getPositionName () 
			) );
			$select->where ( array (
					'positionLevelId' => $position->getPositionLevelId () 
			) );
			$select->where ( array (
					'positionCode' => $position->getPositionCode () 
			) );
			$select->where ( array (
					'sectionId' => $position->getSectionId () 
			) );
		} );
		$row = $rowset->current ();
		if ($row) {
			return true;
		}
		
		// Check whether combination of (name+level+code+section) and the record status should be approved in history table
		$rowset = $this->historyTableGateway->select ( function (Select $select) use($position) {
			$where = new Where ();
			$where->EqualTo ( 'positionName', $position->getPositionName () )->AND->EqualTo ( 'positionLevelId', $position->getPositionLevelId () )->AND->EqualTo ( 'positionCode', $position->getPositionCode () )->AND->EqualTo ( 'sectionId', $position->getSectionId () )->AND->NEST-> // start braket
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
				'positionId' => $id 
		) );
		if ($rowset->count ()) {
			return true;
		}
		return false;
	}
	public function getPosition($id, $table) {
		$id = ( int ) $id;
		if ($table == 'main') {
			$rowset = $this->mainTableGateway->select ( function (Select $select) use($id) {
				$select->where ( array (
						'positionId' => $id 
				) );
			} );
		} else if ($table == 'history') {
			$rowset = $this->historyTableGateway->select ( function (Select $select) use($id) {
				$select->where ( array (
						'positionId' => $id 
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
	public function approvePosition(Position $position, $status, UserInfo $user) {
		try {
			$this->dbConnection->beginTransaction ();
			
			if ($status == 2) {
				$data = array (
						'positionId' => $position->getPositionId (),
						'positionName' => $position->getPositionName (),
						'positionLevelId' => $position->getPositionLevelId (),
						'positionCode' => $position->getPositionCode (),
						'sectionId' => $position->getSectionId (),
						'reportingPositionId' => $position->getReportingPositionId (),
						'positionStatus' => $position->getPositionStatus () 
				);
				
				$id = ( int ) $position->getPositionId ();
				if ($this->doesExist ( $id )) {
					$this->mainTableGateway->update ( $data, array (
							'positionId' => $id 
					) );
				} else {
					$this->mainTableGateway->insert ( $data );
				}
			}
			
			$data ['updatedUser'] = $user->getName ();
			$data ['updatedDate'] = new \Zend\Db\Sql\Expression ( 'NOW()' );
			$data ['recordStatus'] = $status;
			
			$id = ( int ) $this->getPosition ( $position->getPositionId (), 'history' )->getId ();
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
	public function savePosition(Position $position, UserInfo $user) {
		try {
			if ($this->isDuplicate ( $position )) {
				return 0;
			}
			
			$this->dbConnection->beginTransaction ();
			
			$data = array (
					'updatedUser' => $user->getName (),
					'updatedDate' => new \Zend\Db\Sql\Expression ( 'NOW()' ),
					'recordStatus' => 3 
			);
			
			$id = ( int ) $position->getId ();
			$this->historyTableGateway->update ( $data, array (
					'id' => $id 
			) );
			
			$data = array (
					'positionId' => $position->getPositionId (),
					'positionName' => $position->getPositionName (),
					'positionLevelId' => $position->getPositionLevelId (),
					'positionCode' => $position->getPositionCode (),
					'sectionId' => $position->getSectionId (),
					'reportingPositionId' => $position->getReportingPositionId (),
					'positionStatus' => $position->getPositionStatus (),
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
	public function getLastInsertedPositionId() {
		$rowset = $this->historyTableGateway->select ( function (Select $select) {
			$select->order ( 'positionId Desc' );
		} );
		$row = $rowset->current ();
		if (! $row) {
			// no records in the table
			return 0;
		}
		return $row->getPositionId ();
	}
	public function objtoArray($id = null) {
		if ($id == null)
			$getPositions = $this->fetchAll ();
		else
			$getPositions = $this->getHigherPosition ( $id );
		
		$array = array ();
		foreach ( $getPositions as $arr ) {
			$array [$arr->getPositionId ()] = $arr->getPositionName ();
		}
		return $array;
	}
}
