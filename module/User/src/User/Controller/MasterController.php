<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class MasterController extends AbstractActionController {
	protected $dbAdapter;
	public function setDbAdapter($db) {
		$this->dbAdapter = $db;
	}
}