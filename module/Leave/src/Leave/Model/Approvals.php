<?php 

namespace Leave\Model;

use Employee\Mapper\TravelingFormMapper; 
// use Leave\Model\ApprovalService;
use User\Model\UserInfoService;
use Application\Persistence\TransactionDatabase;
use Application\Model\MailService;
use Position\Model\PositionService;
use Application\Model\NonWorkingDaysService;
use Payment\Model\DateMethods;
use Leave\Mapper\LeaveFormMapper;
//use Application\Model\LookupService;
//use Application\Mapper\LookupMapper;
use Pms\Mapper\PmsFormMapper;

abstract class Approvals {
	
	protected $leaveFormMapper; 
	protected $approvalService; 
	protected $userInfoService; 
	protected $databaseTransaction; 
	protected $mailService;  
	protected $positionService;   
	protected $nonWorkingDays;  
	protected $dateMethods;  
	protected $travelingFormMapper;  
	protected $services; 
	protected $pmsFormMapper;  
	//protected $lookupMapper; 
    
	public function __construct(LeaveFormMapper $leaveMapper,
			ApprovalService $approvalService,UserInfoService $userInfoService,
			TransactionDatabase $transaction,MailService $mailService,
			PositionService $positionService,NonWorkingDaysService $nonWorkingDays,
			DateMethods $dateMethods,TravelingFormMapper $travelingFormMapper,
	        PmsFormMapper $pmsFormMapper,$sm
			) {
		$this->leaveFormMapper = $leaveMapper;
		$this->approvalService = $approvalService;
		$this->userInfoService = $userInfoService;
		$this->databaseTransaction = $transaction;
		$this->mailService = $mailService;
		$this->positionService = $positionService; 
		$this->nonWorkingDays = $nonWorkingDays; 
		$this->dateMethods = $dateMethods; 
		$this->travelingFormMapper = $travelingFormMapper; 
		$this->pmsFormMapper = $pmsFormMapper;
		$this->services = $sm; 
	} 
	
	public function getCheckListService() {
		return $this->services->get('checkListService');
	}
	/*protected function getLeaveIdByName($leaveName = null) {
		if(!$leaveName) {
			$leaveName = $this->getLeaveName(); 
		}
		return $this->leaveMapper->getIdByName($leaveName); 
	}*/  
	/*
	public function getOverlapProcessList() {
		// @todo fetch from db
		// @todo add only after  
		return array(
		    'traveling'     => 'TravelingLocal',
		    'leaveService'  => 'Leave',
			'Suspend'       => 'Suspend' 
		); 
	} */  
	// public function isHaveProcess 
	// Abstract Methods 
	// abstract function getLeaveName();
	
}