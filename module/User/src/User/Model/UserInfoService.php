<?php
 
namespace User\Model; 

class UserInfoService {
	
	private $authService;
	
	private $identity;
	
	public function __construct($sm) {
		$this->authService = $sm->get('Zend\Authentication\AuthenticationService');
		$this->identity = $this->authService->getIdentity(); 
	}
	
	public function getUserName() {
		return $this->identity['username']; 
	}
    	
	public function getEmployeeId() {
		return $this->identity['employeeId']; 
	}
	
	public function getCompany() {
		return $this->identity['company'];
	}
	
	public function getRole() {
		return $this->identity['role'];
	}
	
}