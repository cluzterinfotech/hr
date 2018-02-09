<?php 
namespace Application\Model;

use User\Model\UserInfoService;
use Application\Mapper\MailMapper; 
use Zend\Mail\Transport\Sendmail as SendmailTransport;
use Zend\Mail;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Position\Model\PositionService;

require_once('Zend/Mail/Transport/Smtp.php');
class MailService  {
	
	protected $mailMapper; 
	
	public function __construct(MailMapper $mailMapper) {
	    $this->mailMapper = $mailMapper; 
	}
	
	public function sendMailAlert($from,$to,$subject,$body , $Cc = 'hr@oilenergyco.com' ) {  
	    try {
    		/*$row = array('mailSubject' => $subject ,
    		             'mailFrom'    => $from,
    		             'mailTo'      => $to,
    		             'mailbody'    => $body	
    		);*/   
    		//$from = 'hr@oilenergyco.com'; 
			//$to = 'doaa.m.osman@oilenergyco.com';
    		//$this->mailMapper->insert($row);  
    		$ccArray = array(); 
    		$ccArray[] = $from;
    		$ccArray[] = 'hr@oilenergyco.com';
    		$ccArray[] = $Cc; 
    		//\Zend\Debug\Debug::dump($from); 
    		//\Zend\Debug\Debug::dump($to);  
    		//\Zend\Debug\Debug::dump($ccArray);  
    		//exit; 
    		$message = new Message();
    		$message->setBody($body); 
    		$message->setFrom($from);
    		$message->addTo($to);
    		$message->addCc($ccArray); 
    		$message->setSubject($subject);
    		$smtpOptions = new SmtpOptions(); 
    		$smtpOptions->setHost('mail.oilenergyco.com')
                		->setName('mail.oilenergyco.com')
                		->setPort(25) 
                		->setConnectionConfig(array(
                		    'host'=>'localhost',
                		)
            );
            $transport = new SmtpTransport($smtpOptions);
            //$transport->send($message);  
    		/*$message = new Message();
    		$message->addTo($to)
    		        ->addFrom($from)
    		        ->setSubject($subject)
    		        ->setBody($body); 
    		$transport = new SmtpTransport();
    		$options   = new SmtpOptions(array(
    		    'name'              => 'mail.oilenergyco.com',
    		    'host'              => '196.1.200.3',
    		    'connection_class'  => 'login',
    		    'connection_config' => array(
    		        'username' => 'hr@oilenergyco.com',
    		        'password' => '123456',
    		    ),
    		));
    		$transport->setOptions($options);
    		$transport->send($message);*/
    		
	    } catch(\Exception $e) {
	        throw $e;
	    }  
	}   
	
	// Submit Alert 
	public function leaveFormSubmitAlert($requester,$approver) {
	    $sender = $this->mailMapper->getEmailIdByEmployee($requester);
	    $receiver = $this->mailMapper->getEmailIdByEmployee($approver);
	    $from = $sender['empEmail']; 
	    $to = $receiver['empEmail']; 
	    $empName = $sender['employeeName']; 
	    $superiorName = $receiver['employeeName']; 
	    //$name =
	    $subject = 'Leave Form';
	    $body = "<p>Dear Mr./Mrs." . $superiorName . "</p>
<p>Please be informed that you have been identified by Mr./Mrs." . $empName . " as his/her immediate supervisor. Please review the Leave form for your approval. </p>
<p>(If you have been  mistakenly choosen as a supervisor by Mr./Mrs." . $empName . " Please notify HRD)</p>
<p>Thank you. </p>";
	    //echo $body;
	    //exit; 
	    $this->sendMailAlert($from, $to, $subject, $body); 
	}
	// Approval Alert 
	public function leaveFormApprovalAlert($applicant,$approver,$hod) {
	    $sender = $this->mailMapper->getEmailIdByEmployee($applicant);
	    $receiver = $this->mailMapper->getEmailIdByEmployee($approver);
	    $hod = $this->mailMapper->getEmailIdByEmployee($hod);
	    $hodCc = $hod['empEmail'];
	    $from = $sender['empEmail'];
	    $to = $receiver['empEmail'];
	    $empName = $sender['employeeName'];
	    $superiorName = $receiver['employeeName']; 
		//$name = 
		$subject = 'Leave Form Approval Alert';
		$body = "<p>Dear Mr./Mrs." . $empName . "</p>
                 <p>Please be informed that your Leave form has been approved by  Mr./Mrs." . $superiorName . " . </p>
                 <p>Thank you. </p>";
		$this->sendMailAlert($from, $to, $subject, $body,$hodCc); 
	}
	
	public function leaveFormRejectedAlert($applicant,$approver,$hod) {
	    $sender = $this->mailMapper->getEmailIdByEmployee($applicant);
	    $receiver = $this->mailMapper->getEmailIdByEmployee($approver);
	    $hod = $this->mailMapper->getEmailIdByEmployee($hod);
	    $hodCc = $hod['empEmail'];
	    $from = $sender['empEmail'];
	    $to = $receiver['empEmail'];
	    $empName = $sender['employeeName'];
	    $superiorName = $receiver['employeeName'];
	    //$name =
	    $subject = 'Leave Form Rejection Alert';
	    $body = "<p>Dear Mr./Mrs." . $empName . "</p>
                 <p>Please be informed that your Leave form has been rejected by  Mr./Mrs." . $superiorName . " . </p>
                 <p>Thank you. </p>";
	    $this->sendMailAlert($from, $to, $subject, $body,$hodCc); 
	}
	/******* Doaa **************/
	public function SendEmpAlerts($EmpArray , $ToMailsArray , $alertType) {
	    $from = 'hr@oilenergyco.com';
	    $to = '';
	    $Cc = 'hr@oilenergyco.com';
	    $subject = $alertType;
	    foreach($ToMailsArray as $ToMail) {
	        if($ToMail['isCc'] = '1')
	            $Cc .= $ToMail['empEmail'].',';
	        else
	           $to .= $ToMail['empEmail'].',';
	    }
	    //$name = 
	   foreach($EmpArray as $emp) {
	        $empId = $alert['employeeNumber'];
	        $body  = " its " .$emp['employeeName']  . $subject .' Joind At  ' .$emp['empJoinDate'] ;
	        $empEmail = $emp['empEmail'];
	        $this->sendMailAlert($from, $to, $subject, $body , $Cc); 
	    }

	}	
	public function getCcOptions() {
	    return $this->mailMapper->getCcOptions();
		 
	}
	public function getAlertsTypes() {
	    return $this->mailMapper->getAlertsTypes();
	    
	}// Rejected Alert
	public function insert($entity) {
	    //echo \Zend\Debug\Debug::dump( $entity );
	    //exit;
	    return $this->mailMapper->insert($entity);
	}
	public function fetchById($entity) {
	    // echo \Zend\Debug\Debug::dump( $entity );
	    // exit;
	    return $this->mailMapper->fetchAlertById($entity);
	}
	public function getAllAlerts() {
	   // echo \Zend\Debug\Debug::dump( $entity );
	    //exit;
	    return $this->mailMapper->getAllAlerts();
	}	/******* Doaa **************/
	
	// Rejected Alert
	public function travelFormLocalRejectedAlert($applicant,$approver) {
	    $sender = $this->mailMapper->getEmailIdByEmployee($applicant);
	    $receiver = $this->mailMapper->getEmailIdByEmployee($approver);
	    $hod = $this->mailMapper->getEmailIdByEmployee($hod);
	    $hodCc = $hod['empEmail'];
	    $from = $sender['empEmail'];
	    $to = $receiver['empEmail'];
	    $empName = $sender['employeeName'];
	    $superiorName = $receiver['employeeName'];
	    $subject = 'Traveling Form Rejection Alert';
	    $body = "<p>Dear Mr./Mrs." . $empName . "</p>
                 <p>Please be informed that your Traveling form has been rejected by  Mr./Mrs." . $superiorName . " . </p>
                 <p>Thank you. </p>";
	    $this->sendMailAlert($from, $to, $subject, $body);
	}
	// Submit Alert 
	public function travelFormLocalSubmitAlert($applicant,$approver) { 
	    $sender = $this->mailMapper->getEmailIdByEmployee($applicant);
	    $receiver = $this->mailMapper->getEmailIdByEmployee($approver);
	    $from = $sender['empEmail'];
	    $to = $receiver['empEmail'];
	    $empName = $sender['employeeName'];
	    $superiorName = $receiver['employeeName'];
	    //$name =
	    $subject = 'Traveling Form Local';
	    $body = "<p>Dear Mr./Mrs." . $superiorName . "</p>
        <p>Please be informed that you have been identified by Mr./Mrs." . $empName . " as his/her immediate supervisor. Please review the Traveling form for your approval. </p>
        <p>(If you have been  mistakenly choosen as a supervisor by Mr./Mrs." . $empName . " Please notify HRD)</p>
        <p>Thank you. </p>";
	    //echo $body;
	    //exit;
	    $this->sendMailAlert($from, $to, $subject, $body);
	}
	 
	public function travelFormLocalApprovalAlert($applicant,$approver) {
	    $sender = $this->mailMapper->getEmailIdByEmployee($applicant);
	    $receiver = $this->mailMapper->getEmailIdByEmployee($approver);
	    $hod = $this->mailMapper->getEmailIdByEmployee($hod);
	    $hodCc = $hod['empEmail'];
	    $from = $sender['empEmail'];
	    $to = $receiver['empEmail'];
	    $empName = $sender['employeeName']; 
	    $superiorName = $receiver['employeeName']; 
	    $subject = 'Traveling Form Approval Alert'; 
	    $body = "<p>Dear Mr./Mrs." . $empName . "</p>
                 <p>Please be informed that your Traveling form has been approved by  Mr./Mrs." . $superiorName . " . </p>
                 <p>Thank you. </p>";
	    $this->sendMailAlert($from, $to, $subject, $body);
	}   
	// Approval Alert 
	public function travelFormAbroadApprovalAlert() { 
	    
	}
	// Submit Alert
	public function travelFormAbroadSubmitAlert() {
	
	}
	
	public function overtimeFormSubmitAlert($applicant,$approver) {
	    $sender = $this->mailMapper->getEmailIdByEmployee($applicant);
	    $receiver = $this->mailMapper->getEmailIdByEmployee($approver);
	    $from = $sender['empEmail'];
	    $to = $receiver['empEmail'];
	    $empName = $sender['employeeName'];
	    $superiorName = $receiver['employeeName'];
	    //$name =
	    $subject = 'Ovetime Form';
	    $body = "<p>Dear Mr./Mrs." . $superiorName . "</p>
        <p>Please be informed that you have been identified by Mr./Mrs." . $empName . " as his/her immediate supervisor. Please review the Overtime form for your approval. </p>
        <p>(If you have been  mistakenly choosen as a supervisor by Mr./Mrs." . $empName . " Please notify HRD)</p>
        <p>Thank you. </p>";
	    //echo $body;
	    //exit;
	    $this->sendMailAlert($from, $to, $subject, $body);
	} 
	// Approval Alert
	
	public function overtimeFormLocalApprovalAlert($applicant,$approver) {
	    $sender = $this->mailMapper->getEmailIdByEmployee($applicant);
	    $receiver = $this->mailMapper->getEmailIdByEmployee($approver);
	    $hod = $this->mailMapper->getEmailIdByEmployee($hod);
	    $hodCc = $hod['empEmail'];
	    $from = $sender['empEmail'];
	    $to = $receiver['empEmail'];
	    $empName = $sender['employeeName'];
	    $superiorName = $receiver['employeeName'];
	    $subject = 'Overtime Form Approval Alert';
	    $body = "<p>Dear Mr./Mrs." . $empName . "</p>
                 <p>Please be informed that your Overtime form has been approved by  Mr./Mrs." . $superiorName . " . </p>
                 <p>Thank you. </p>";
	    $this->sendMailAlert($from, $to, $subject, $body); 
	}
	
	
	
    
}