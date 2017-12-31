<?php 

namespace Application\Model; 

use User\Model\UserInfoService;
use Position\Model\PositionService;
use Zend\EventManager\StaticEventManager;

class CheckListService  {
    
	private $userInfoService;
	private $positionService;
	private $service;
	private $checkListMapper;
	
	public function __construct(UserInfoService $userInfoService,
			PositionService $positionService,$sm,CheckListMapper $checkListMapper) {
		$this->userInfoService = $userInfoService;
		$this->service = $sm; 
		$this->checkListMapper = $checkListMapper;
	    // checklist mapper
	    // daterange
	}
	
	public function isAllowedThisProcess($link,$action) { 
		// echo $this->userInfoService->getRole();
		// exit; 
		//\Zend\Debug\Debug::dump($link); 
		//exit; 
		list($module,$controller,$controllerName) = explode('\\',$link);
		//\Zend\Debug\Debug::dump($controllerName);
		//exit;
        $company = $this->service->get('company');  
        $list = $this->checkListMapper->getMonthlyCheckList($controllerName,$company);  
        
        foreach ($list as $lst) {
		    $relController = $lst['relatedController']; 
            $isHave = $this->isHaveController($relController,$company);    
            if($isHave) {
            	return 0;
            } 
            
        }
        //\Zend\Debug\Debug::dump($lst);
        //exit;
	    return 1;
		// return 0; 
	}   
	
	public function isHaveController($relController,$company) {
		return $this->checkListMapper->isHaveController($relController,$company);
	}
	
	// logs single entry 
	public function checkListlog($routeInfo) { 
        list($module,$controller,$controllerName) = explode('\\',$routeInfo['controller']); 
		$data = array(
			'module'        => $module, 
		    'controller'    => $controllerName, 
		    'name'          => 'save', 
		    'companyId'     => $this->userInfoService->getCompany(),
		    'loggedDate'    => date('Y-m-d'),
		); 
		$this->checkListMapper->checkListlog($data); 
	} 
	// removes single entry 
	public function removeLog($routeInfo) { 
		list($module,$controller,$controllerName) = explode('\\',$routeInfo['controller']);
		$data = array(
				'module'        => $module,
				'controller'    => $controllerName, 
				'companyId'     => $this->userInfoService->getCompany(),
				'loggedDate'    => date('Y-m-d'),
		); 
		$this->checkListMapper->removeLog($data);
	}
	// closes all entries 
	public function closeLog($routeInfo) {
		list($module,$controller,$controllerName) = explode('\\',$routeInfo['controller']);
		$data = array(
				'module'        => $module,
				'controller'    => $controllerName,
				//'name'          => 'close',
				'companyId'     => $this->userInfoService->getCompany(),
				//'loggedDate'    => date('Y-m-d'),
		);
		$this->checkListMapper->closeLog($data);
	}
	
	public function checkList($controller,$action,$employee) {
	    	
	} 
	
	public function selectChecklist() {
	    return $this->checkListMapper->selectChecklist();
	}
	
	public function selectChecklistCurrent() {
		return $this->checkListMapper->selectChecklistCurrent();
	}
	
	
}