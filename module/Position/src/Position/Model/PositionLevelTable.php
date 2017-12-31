<?php
/*
namespace Position\Model;

use Zend\Db\Sql\Select;
use Position\Model\PositionLevel;
use Zend\Db\Sql\Predicate;
use Zend\Db\Sql\Where;
use Position\Model\UserInfo;

class PositionLevelTable {
	private $mainTableGateway, $historyTableGateway, $dbConnection;
	public function __construct($mainTableGateway, $historyTableGateway) {
		$this->mainTableGateway = $mainTableGateway;
		$this->historyTableGateway = $historyTableGateway;
		$this->dbConnection = $mainTableGateway->getAdapter ()->getDriver ()->getConnection ();
	}
	public function fetchAll() {
		$resultSet = $this->mainTableGateway->select ();
		return $resultSet;
	}
	public function isDuplicate(PositionLevel $level) {
		// Check either name or sequence are exist in main table
		$rowset = $this->mainTableGateway->select ( function (Select $select) use($level) {
			$select->where ( array (
					'levelName' => $level->getLevelName () 
			) );
			$select->where ( array (
					'levelSequence' => $level->getLevelSequence () 
			), Predicate\PredicateSet::OP_OR );
			$select->where ( 'positionLevelId != ?', $level->getPositionLevelId () );
		} );
		$row = $rowset->current ();
		if ($row) {
			return true;
		}
		
		// Check either name or sequence and the record status should be approved in history table
		$rowset = $this->historyTableGateway->select ( function (Select $select) use($level) {
			$where = new Where ();
			$where->NotEqualTo ( 'positionLevelId', $level->getPositionLevelId () )->AND->NEST-> // start braket
EqualTo ( 'levelName', $level->getLevelName () )->OR->equalTo ( 'levelSequence', $level->getLevelSequence () )->UNNEST-> // close braket
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
				'positionLevelId' => $id 
		) );
		if ($rowset->count ()) {
			return true;
		}
		return false;
	}
	public function getPositionLevel($id, $table) {
		$id = ( int ) $id;
		if ($table == 'main') {
			$rowset = $this->mainTableGateway->select ( function (Select $select) use($id) {
				$select->where ( array (
						'positionLevelId' => $id 
				) );
			} );
		} else if ($table == 'history') {
			$rowset = $this->historyTableGateway->select ( function (Select $select) use($id) {
				$select->where ( array (
						'positionLevelId' => $id 
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
	public function approveLevel(PositionLevel $level, $status, UserInfo $user) {
		try {
			$this->dbConnection->beginTransaction ();
			
			if ($status == 2) {
				$data = array (
						'positionLevelId' => $level->getPositionLevelId (),
						'levelName' => $level->getLevelName (),
						'levelSequence' => $level->getLevelSequence () 
				);
				
				$id = ( int ) $level->getPositionLevelId ();
				if ($this->doesExist ( $id )) {
					$this->mainTableGateway->update ( $data, array (
							'positionLevelId' => $id 
					) );
				} else {
					$this->mainTableGateway->insert ( $data );
				}
			}
			
			$data ['updatedUser'] = $user->getName ();
			$data ['updatedDate'] = new \Zend\Db\Sql\Expression ( 'NOW()' );
			$data ['recordStatus'] = $status;
			
			$id = ( int ) $this->getPositionLevel ( $level->getPositionLevelId (), 'history' )->getId ();
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
	public function saveLevel(PositionLevel $level, UserInfo $user) {
		try {
			if ($this->isDuplicate ( $level ))
				return 0;
			
			$this->dbConnection->beginTransaction ();
			
			$data = array (
					'updatedUser' => $user->getName (),
					'updatedDate' => new \Zend\Db\Sql\Expression ( 'NOW()' ),
					'recordStatus' => 3 
			);
			
			$id = ( int ) $level->getId ();
			$this->historyTableGateway->update ( $data, array (
					'id' => $id 
			) );
			
			$data = array (
					'positionLevelId' => $level->getPositionLevelId (),
					'levelName' => $level->getLevelName (),
					'levelSequence' => $level->getLevelSequence (),
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
	public function getLastInsertedLevelId() {
		$rowset = $this->historyTableGateway->select ( function (Select $select) {
			$select->order ( 'positionLevelId Desc' );
		} );
		$row = $rowset->current ();
		if (! $row) {
			// no records in the table
			return 5;
		}
		return $row->getPositionLevelId ();
	}
	public function objtoArray() {
		$getPositionLevels = $this->fetchAll();
		$array = array ();
		foreach ( $getPositionLevels as $sect ) {
			$array [$sect->getPositionLevelId ()] = $sect->getLevelName ();
		}
		return $array;
	}
}
*/