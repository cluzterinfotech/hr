<?php

namespace User\Event;

use Zend\Mvc\MvcEvent as MvcEvent;
use Zend\Session\Container as SessionContainer;
use User\Controller\Plugin\UserAuthentication as AuthPlugin;
use User\Acl\Acl as AclClass;

class Authentication {
	
	protected $_userAuth = null;
	protected $_aclClass = null;
	protected $sesscontainer;
	
	private function getSessContainer() {
		if (! $this->sesscontainer) {
			$this->sesscontainer = new SessionContainer('my');
		}
		return $this->sesscontainer;
	}
	
	public function preDispatch(MvcEvent $event) {
		$userAuth = $this->getUserAuthenticationPlugin(); 
		$acl = $this->getAclClass ();
		$role = AclClass::DEFAULT_ROLE;
		
		if ($userAuth->hasIdentity()) {
			$user = $userAuth->getIdentity();
			$role = $user['role']; 
		} 
        
		$routeMatch = $event->getRouteMatch();
		$controller = $routeMatch->getParam('controller');
		$action = $routeMatch->getParam('action');
        
		if (!$acl->hasResource($controller)) {
			throw new \Exception('Resource ' . $controller . ' not defined');
		}
		
		if (!$acl->isAllowed($role,$controller,$action)) {
			$url = $event->getRouter()->assemble(array(), array('name' => 'user'));
			$response = $event->getResponse();
			$response->getHeaders()->addHeaderLine('Location',$url);
			$response->setStatusCode(302);
			$response->sendHeaders();
			exit; 
		}	
	}
	
	public function setUserAuthenticationPlugin(AuthPlugin $userAuthenticationPlugin) {
		$this->_userAuth = $userAuthenticationPlugin;
		return $this;
	}
	
	public function getUserAuthenticationPlugin() {
		if ($this->_userAuth === null) {
			$this->_userAuth = new AuthPlugin ();
		} 
		return $this->_userAuth;
	}
	
	public function setAclClass(AclClass $aclClass) {
		$this->_aclClass = $aclClass;
		return $this;
	}
	
	public function getAclClass() {
		if ($this->_aclClass === null) {
			$this->_aclClass = new AclClass ( array () );
		} 
		return $this->_aclClass;
	}
}