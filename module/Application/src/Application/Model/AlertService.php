<?php 
namespace Application\Model;

use User\Model\UserInfoService;
use Application\Mapper\AlertMapper;
use Application\Mapper\MailMapper; 
use Zend\Mail\Transport\Sendmail as SendmailTransport;
use Zend\Mail;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Position\Model\PositionService;

require_once('Zend/Mail/Transport/Smtp.php');
class AlertService  {
	
	protected $alertMapper; 
	
	public function __construct(AlertMapper $alertMapper) {
	    $this->alertMapper = $alertMapper; 
	}
	
	
	/******* Doaa **************/
	public function getCcOptions() {
	    return $this->alertMapper->getCcOptions();
		 
	}
	public function getAlertsTypes() {
	    return $this->alertMapper->getAlertsTypes();
	    
	}// Rejected Alert
	public function insert($alert) {
	    //echo \Zend\Debug\Debug::dump( $entity );
	    //exit;
	    return $this->alertMapper->insertAlert($alert);
	}
	public function fetchAlertById($id) {
	    // echo \Zend\Debug\Debug::dump( $entity );
	    // exit;
	    return $this->alertMapper->fetchAlertById($id);
	}
	public function getAllAlerts() {
	   // echo \Zend\Debug\Debug::dump( $entity );
	    //exit;
	    return $this->alertMapper->getAllAlerts();
	}	/******* Doaa **************/
	public function getAlertsTypesObj() {
	   // echo \Zend\Debug\Debug::dump( $entity );
	    //exit;
	    return $this->alertMapper->getAlertsTypesObj();
	}
	public function PerpareEmployees($formula , $alertId) {
	   // echo \Zend\Debug\Debug::dump( $entity );
	    //exit;
	    if($alertId == 1 )
	        return $this->alertMapper->getAnnversaryEmp($formula);
	    if($alertId == 2 )
	            return $this->alertMapper->getTerminatedEmp($formula);
	    if($alertId == 3 )
	            return $this->alertMapper->getRetirmentEmp($formula);
	   /* if($alertId == 4 )
	            return $this->alertMapper->getRetirmentEmp($formula); */
	                
	                
	}
	public function getToEmails($alertId) {
	   // echo \Zend\Debug\Debug::dump( $entity );
	    //exit;

	    return $this->alertMapper->getToEmails($alertId);
	}/******* Doaa **************/

	public function DeleteAlertById($id) {
	    return $this->alertMapper->DeleteAlertById($id);
	} 
	
    
}