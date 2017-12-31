<?php

/**
 * Description of DelegationTable
 *
 * @author AlkhatimVip
 */
namespace Position\Model;

use Zend\Db\Sql\Select;
use Position\Model\PositionDelegation;
use Zend\Db\Sql;

class PositionDelegationTable {
	private $tableGateway, $positionTableGateway, $dbConnection;
	public function __construct($tableGateway, $positionTableGateway) {
		$this->tableGateway = $tableGateway;
		$this->positionTableGateway = $positionTableGateway;
		$this->dbConnection = $tableGateway->getAdapter ()->getDriver ()->getConnection ();
	}
	public function fetchAll() {
		$resultSet = $this->tableGateway->select ();
		return $resultSet;
	}
	public function doesExist($id) {
		$rowset = $this->tableGateway->select ( array (
				'id' => $id 
		) );
		if ($rowset->count ()) {
			return true;
		}
		return false;
	}
	public function getDelegation($id) {
		$id = ( int ) $id;
		$rowset = $this->tableGateway->select ( function (Select $select) use($id) {
			$select->where ( array (
					'id' => $id 
			) );
			$select->order ( 'id Desc' );
		} );
		$row = $rowset->current ();
		if (! $row) {
			throw new \Exception ( "Could not find row $id" );
		}
		return $row;
	}
	public function saveDelegation(PositionDelegation $delegate) {
		try {
			$this->dbConnection->beginTransaction ();
			$data = array (
					'positionId' => $delegate->getPositionId (),
					'delegatedPositionId' => $delegate->getDelegatedPositionId (),
					'fromDate' => $delegate->getFromDate (),
					'toDate' => $delegate->getToDate () 
			);
			
			$id = ( int ) $delegate->getId ();
			if ($this->doesExist ( $id )) {
				$this->tableGateway->update ( $data, array (
						'id' => $id 
				) );
				$this->log ( $id, "Update" );
			} else {
				$this->tableGateway->insert ( $data );
				$this->log ( $this->tableGateway->getLastInsertValue (), "Insert" );
			}
			
			$this->dbConnection->commit ();
			return 1234;
		} catch ( \Zend\Db\Exception $ex ) {
			$this->dbConnection->rollBack ();
			\Zend\Debug\Debug::dump ( $ex );
		}
	}
	public function deleteDelegation($id) {
		try {
			$this->dbConnection->beginTransaction ();
			$this->log ( $id, "Delete" );
			$this->tableGateway->delete ( array (
					'id' => ( int ) $id 
			) );
			$this->dbConnection->commit ();
			return 1234;
		} catch ( \Zend\Db\Exception $ex ) {
			$this->dbConnection->rollBack ();
			\Zend\Debug\Debug::dump ( $ex );
		}
	}
	public function getPositionsArray() {
		$statement = $this->positionTableGateway->getAdapter ()->query ( 'SELECT p.positionId , p.positionName FROM position AS p
                                             WHERE p.positionId NOT IN (SELECT positionId FROM positiondelegation)' );
		
		$result = $statement->execute ();
		return $this->resulttoArray ( $result );
	}
	public function getDelegatedPositionsArray($id) {
		$statement = $this->positionTableGateway->getAdapter ()->query ( 'SELECT p.positionId , p.positionName FROM position AS p
                                             WHERE p.positionId NOT IN 
                                                 (
                                                     SELECT positionId FROM positiondelegation
                                                  )
                                              and p.positionId != "' . $id . '"
                                               ' );
		
		$result = $statement->execute ();
		return $this->resulttoArray ( $result );
	}
	public function log($id, $statement) {
		$delegate = $this->getDelegation ( $id );
		return $this->tableGateway->getAdapter ()->query ( 'INSERT INTO positiondelegationhistory 
                              (delegateId, positionId, delegatedPositionId, fromDate, toDate, addedUser, addedDate, statement) VALUES
                              (' . $delegate->getId () . ', ' . $delegate->getPositionId () . ',' . $delegate->getDelegatedPositionId () . ',"' . $delegate->getFromDate () . '","' . $delegate->getToDate () . '","alkhatim", NOW(), "' . $statement . '")' )->execute ();
	}
	public function resulttoArray($results) {
		$array = array ();
		foreach ( $results as $arr ) {
			$array [$arr ['positionId']] = $arr ['positionName'];
		}
		return $array;
	}
}