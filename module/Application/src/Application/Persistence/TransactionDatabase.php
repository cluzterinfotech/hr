<?php
namespace Application\Persistence;

use Zend\Db\Adapter\Adapter as zendAdapter;

class TransactionDatabase {
	
	private $adapter;
	
	public function __construct(zendAdapter $adapter) {
		$this->adapter = $adapter;
	}
	
	public function beginTransaction() {
		$this->adapter->getDriver()->getConnection()->beginTransaction();
		//$this->adapter->getDriver()->getConnection()->
	}
	
	public function commit() {
		$this->adapter->getDriver()->getConnection()->commit();
	}
	
	public function rollBack() {
		$this->adapter->getDriver()->getConnection()->rollback();
	} 	
}	

