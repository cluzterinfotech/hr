<?php
/*
namespace Position\Model;

use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Position\Model\Section;
use Zend\Db\Sql\Where;
use Position\Model\UserInfo;

class SectionTable {
	private $mainTableGateway, $historyTableGateway, $dbConnection;
	public function __construct($mainTableGateway, $historyTableGateway) {
		$this->mainTableGateway = $mainTableGateway;
		$this->historyTableGateway = $historyTableGateway;
		$this->dbConnection = $mainTableGateway->getAdapter ()->getDriver ()->getConnection ();
	}
	public function fetchAll($adapter) {
		// $resultSet = $this->mainTableGateway->select();
		// return $resultSet;
		$sql = new Sql ( $adapter );
		
		$select = $sql->select ();
		$select->from ( 'section' )->columns ( array (
				'*' 
		) );
		// var_dump($select);
		// exit;
		return $select;
	}
	public function isDuplicate(Section $section) {
		// Check whether combination of (name+department) or code are exist in main table
		$rowset = $this->mainTableGateway->select ( function (Select $select) use($section) {
			$where = new Where ();
			$where->NEST-> // start braket
EqualTo ( 'sectionCode', $section->getSectionCode () )->OR->equalTo ( 'sectionName', $section->getSectionName () )->AND->equalTo ( 'departmentId', $section->getDepartmentId () )->UNNEST-> // close braket
AND->NotEqualTo ( 'sectionId', $section->getSectionId () );
			$select->where ( $where );
		} );
		$row = $rowset->current ();
		if ($row) {
			return true;
		}
		
		// Check whether combination of (name+department) or code and the record status should be approved in history table
		$rowset = $this->historyTableGateway->select ( function (Select $select) use($section) {
			$where = new Where ();
			$where->NotEqualTo ( 'sectionId', $section->getSectionId () )->AND->NEST-> // start braket
EqualTo ( 'sectionCode', $section->getSectionCode () )->OR->equalTo ( 'sectionName', $section->getSectionName () )->AND->equalTo ( 'departmentId', $section->getDepartmentId () )->UNNEST->AND->NEST-> // start braket
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
				'sectionId' => $id 
		) );
		if ($rowset->count ()) {
			return true;
		}
		return false;
	}
	public function getSection($id, $table) {
		$id = ( int ) $id;
		if ($table == 'main') {
			$rowset = $this->mainTableGateway->select ( function (Select $select) use($id) {
				$select->where ( array (
						'sectionId' => $id 
				) );
			} );
		} else if ($table == 'history') {
			$rowset = $this->historyTableGateway->select ( function (Select $select) use($id) {
				$select->where ( array (
						'sectionId' => $id 
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
	public function approveSection(Section $section, $status, UserInfo $user) {
		try {
			$this->dbConnection->beginTransaction ();
			
			if ($status == 2) {
				$data = array (
						'sectionId' => $section->getSectionId (),
						'sectionName' => $section->getSectionName (),
						'sectionCode' => $section->getSectionCode (),
						'departmentId' => $section->getDepartmentId () 
				);
				
				$id = ( int ) $section->getSectionId ();
				if ($this->doesExist ( $id )) {
					$this->mainTableGateway->update ( $data, array (
							'sectionId' => $id 
					) );
				} else {
					$this->mainTableGateway->insert ( $data );
				}
			}
			
			$data ['updatedUser'] = $user->getName ();
			$data ['updatedDate'] = new \Zend\Db\Sql\Expression ( 'NOW()' );
			$data ['recordStatus'] = $status;
			
			$id = ( int ) $this->getSection ( $section->getSectionId (), 'history' )->getId ();
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
	public function saveSection(Section $section, UserInfo $user) {
		try {
			if ($this->isDuplicate ( $section ))
				return 0;
			
			$this->dbConnection->beginTransaction ();
			
			$data = array (
					'updatedUser' => $user->getName (),
					'updatedDate' => new \Zend\Db\Sql\Expression ( 'NOW()' ),
					'recordStatus' => 3 
			);
			
			$id = ( int ) $section->getId ();
			$this->historyTableGateway->update ( $data, array (
					'id' => $id 
			) );
			
			$data = array (
					'sectionId' => $section->getSectionId (),
					'sectionName' => $section->getSectionName (),
					'sectionCode' => $section->getSectionCode (),
					'departmentId' => $section->getDepartmentId (),
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
	public function getLastInsertedSectionId() {
		$rowset = $this->historyTableGateway->select ( function (Select $select) {
			$select->order ( 'sectionId Desc' );
		} );
		$row = $rowset->current ();
		if (! $row) {
			// no records in the table
			return 5;
		}
		return $row->getSectionId ();
	}
	public function objtoArray() {
		$getSections = $this->fetchAll ();
		$array = array ();
		foreach ( $getSections as $sect ) {
			$array [$sect->getSectionId ()] = $sect->getSectionName ();
		}
		return $array;
	}
}
*/