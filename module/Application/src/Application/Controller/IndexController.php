<?php 
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController  {
	
	public function dashboardAction() { 
	    /*$service = $this->getService(); 
	    if(!$service->isDailyProcessPrepared()) { 
	        $service->performDailyProcess();    
	    }*/ 
	}  
	 
	public function unabletoprepareAction() {
		return array();
	}
	
	public function nothavepermissionAction() {
		return array();
	}
	
	public function indexAction() { } 
	
	private function getService() { 
		return $this->getServiceLocator()->get('everydayProcessService');
	}
	
	private function getDateService() {
		return $this->getServiceLocator()->get('dateRange');
	} 
	
	private function getUser() {
		return $this->getUserInfoService()->getEmployeeId();
	}
	
	private function getUserInfoService() {
		return $this->getServiceLocator()->get('userInfoService');
	} 
	
}     