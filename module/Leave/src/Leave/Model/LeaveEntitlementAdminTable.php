<?php

namespace Leave\Model;

// use Leave\Model\LeaveEntitlementAdmin;
// use Zend\Db\ResultSet\ResultSet;
// //use Zend\Db\TableGateway\TableGateway;
// use Zend\Db\Sql\Select;
// use Zend\Paginator\Adapter\DbSelect;
// use Zend\Paginator\Paginator;
use Zend\Db\Sql\Sql;

class LeaveEntitlementAdminTable {
	protected $leaveEntitlemen;
	protected $leaveEntitlementHistory;
	protected $adapter;
	protected $sql;
	protected $connection;
	public function __construct($leaveEntitlementTableGateway, $leaveEntitlementHistoryTableGateway) {
		$this->leaveEntitlemen = $leaveEntitlementTableGateway;
		$this->leaveEntitlementHistory = $leaveEntitlementHistoryTableGateway;
		$this->adapter = $this->leaveEntitlemen->getAdapter ();
		$this->sql = new Sql ( $this->adapter );
		$this->connection = $this->adapter->getDriver ()->getConnection ();
	}
	public function isLeaveEntitlement($id) {
		$resultSet = $this->leaveEntitlement->select ( array (
				'id' => $id 
		) );
		if ($resultSet->count () > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function fetchAllUnApprove() {
		$resultSet = $this->leaveEntitlementHistory->select ( array (
				'recordStatus' => '1' 
		) );
		// \Zend\Debug\Debug::dump($resultSet);
		return $resultSet;
	}
	public function approve($id) {
		try {
			$this->connection->beginTransaction ();
			$result = $this->leaveEntitlementHistory->select ( array (
					'id' => $id 
			) );
			$leaveEntitlememnt = $result->current ();
			$data = array (
					'id' => $leaveEntitlememnt->getId (),
					'yearsOfService' => $leaveEntitlememnt->getYearsOfService (),
					'numberOfDays' => $leaveEntitlememnt->getNumberOfDays (),
					'companyId' => $leaveEntitlememnt->getCompanyId () 
			);
			$this->leaveEntitlemen->insert ( $data );
			$data2 = array (
					'recordStatus' => '0' 
			);
			$this->leaveEntitlementHistory->update ( $data2, array (
					'id' => $id 
			) );
			$this->connection->commit ();
		} catch ( \Exception $e ) {
			if ($this->connection instanceof \Zend\Db\Adapter\Driver\ConnectionInterface) {
				$this->connection->rollback ();
				return $e;
			}
		}
	}
	public function reject($id) {
		// try
		// {
		// $this->connection->beginTransaction();
		// $result = $this->leaveEntitlementHistory->select(array('id' => $id));
		// $leaveEntitlememnt = $result->current();
		// $data = array(
		// 'id' => $leaveEntitlememnt->getId(),
		// 'yearsOfService' => $leaveEntitlememnt->getYearsOfService(),
		// 'numberOfDays' => $leaveEntitlememnt->getNumberOfDays(),
		// 'companyId' => $leaveEntitlememnt->getCompanyId(),
		// );
		// $this->leaveEntitlemen->insert($data);
		$data2 = array (
				'recordStatus' => '2' 
		);
		$this->leaveEntitlementHistory->update ( $data2, array (
				'id' => $id 
		) );
		// $this->connection->commit();
		// } catch (\Exception $e)
		// {
		// if ($this->connection instanceof \Zend\Db\Adapter\Driver\ConnectionInterface) {
		// $this->connection->rollback();
		// throw $e;
		// }
		// }
	}
	// }
}