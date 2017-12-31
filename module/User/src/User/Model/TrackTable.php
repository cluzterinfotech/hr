<?php

namespace User\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;

class TrackTable extends AbstractTableGateway {
	protected $table = 'user';
	public function __invoke(Adapter $adapter) {
		$this->adapter = $adapter;
		$this->initialize ();
	}
	public function fetchAll() {
		$resultSet = $this->select ();
		return $resultSet->toArray ();
	}
}