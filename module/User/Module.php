<?php

namespace User;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface, 
    Zend\EventManager\StaticEventManager, 
    Zend\ModuleManager\ModuleManager,
Zend\EventManager\EventManagerAwareInterface;
use Zend\View\HelperPluginManager;
use Zend\Permissions\Acl\Acl;
//use Zend\Permissions\Acl\Role\GenericRole;
//use Zend\Permissions\Acl\Resource\GenericResource;
use User\Model\UserInfoService;

class Module implements AutoloaderProviderInterface {
    	
	// Note : Priority -ve holds less, +ve more value more 
	public function init(ModuleManager $moduleManager) {
		$events = StaticEventManager::getInstance ();
		$events->attach('Zend\Mvc\Controller\AbstractActionController','dispatch',array(
				$this,
				'mvcPredispatch' 
		),89); 
		$events->attach('Zend\Mvc\Controller\AbstractActionController','dispatch',array(
				$this,
				'checkCheckList'
		),99); 
		$sharedEvents = $moduleManager->getEventManager()->getSharedManager(); 
		$sharedEvents->attach(__NAMESPACE__,'dispatch',function($e) {
			$controller = $e->getTarget ();
			$controller->layout('layout/blank'); 
		}, 90);  
	}
    
	public function getAutoloaderConfig() {
		return array (
				'Zend\Loader\ClassMapAutoloader' => array (
						__DIR__ . '/autoload_classmap.php' 
				),
				'Zend\Loader\StandardAutoloader' => array (
						'namespaces' => array (
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__ 
						) 
				) 
		); 
	} 
	
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
	
	public function mvcPredispatch($event) {
		$di = $event->getTarget()->getServiceLocator();
		$auth = $di->get('User\Event\Authentication');
		//echo "executed first predispatch";
		//exit;
		return $auth->preDispatch($event);
	}
	
	public function checkCheckList($event) {
		$sm = $event->getTarget()->getServiceLocator(); 
		$routeMatch = $event->getRouteMatch();
		$controller = $routeMatch->getParam('controller');
		$action = $routeMatch->getParam('action');
        
		$checkListService = $sm->get('checkListService'); 
		$isAllowed = $checkListService->isAllowedThisProcess($controller,$action); 
		
		//\Zend\Debug\Debug::dump($isAllowed);  
		//exit; 
		if(!$isAllowed) { 
			$url = $event->getRouter()->assemble(array(), array('name' => 'unabletoprepare'));
			$response = $event->getResponse();
			$response->getHeaders()->addHeaderLine('Location', $url);
			$response->setStatusCode(302);
			$response->sendHeaders();
			exit;
		} 
		
	}
	
	
	public function getViewHelperConfig()
	{   
		return array( 
			'factories' => array( 
				'navigation' => function(HelperPluginManager $pm) { 
					$sm = $pm->getServiceLocator();
					$acl = new \User\Acl\Acl();
					$auth = $sm->get('Zend\Authentication\AuthenticationService');
					$role = $acl::DEFAULT_ROLE;
					if($auth->hasIdentity()) {
						$identity = $auth->getIdentity();
						$role = $identity['role'];
						$navigation = $pm->get('Zend\View\Helper\Navigation');
						$navigation->setAcl($acl)
						                     ->setRole($role);  
						return $navigation; 
					}   
				},
			)
		); 
	} 
	
	public function getServiceConfig() {
		return array (
			'factories' => array(
				'userInfoService' => function($sm) { 
					return new UserInfoService($sm); 
				}, 
			) 
		); 
	}
	
}