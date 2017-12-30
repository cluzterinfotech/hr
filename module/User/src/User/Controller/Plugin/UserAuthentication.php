<?php

namespace User\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin, 
    Zend\Authentication\AuthenticationService, 
    Zend\Db\Adapter\Adapter as DbAdapter, 
    Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;

class UserAuthentication extends AbstractPlugin {
	protected $_authAdapter = null;
	protected $_authService = null;
	public function hasIdentity() {
		return $this->getAuthService()->hasIdentity();
	}
	public function getIdentity() {
		//return $this->getAuthService()->getStorage()->read();
		return $this->getAuthService()->getIdentity();
	}
	
	public function setAuthAdapter(AuthAdapter $authAdapter) {
		$this->_authAdapter = $authAdapter;
		return $this;
	}
	// 10.70.1.13\petronas
	public function getAuthAdapter() {
		if ($this->_authAdapter === null) {
			  $this->setAuthAdapter(new AuthAdapter (new DbAdapter(array(
					'driver' => 'pdo',
				    'dsn' => 'sqlsrv:database=payrollUpgraded;Server=localhost',
			  		'UID' => 'sa',
			  		'PWD' => '123456'
			))));
			//$this->setAuthAdapter(new AuthAdapter(new DbAdapter()) );
		}
		return $this->_authAdapter; 
	}
	
	public function setAuthService(AuthenticationService $authService) {
		$this->_authService = $authService;
		return $this;
	}
	
	public function getAuthService() {
		if ($this->_authService === null) {
			$this->setAuthService(new AuthenticationService());
		} 
		return $this->_authService;
	}
	
	public function clearIdentity() {
		// return "";
		return $this->getAuthService()->clearIdentity(); 
	} 
}