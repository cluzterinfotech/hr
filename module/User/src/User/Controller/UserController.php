<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController, 
Zend\Session\Container as SessionContainer, 
Zend\View\Model\ViewModel, 
User\Form\Login as LoginForm, 
User\Model\User as UserFilter;

class UserController extends AbstractActionController {
	
	public function indexAction() { }
	
	public function loginAction() {
		//$viewmodel = new ViewModel ();
		// disable layout if request by Ajax
		//$viewmodel->setTerminal ( 1 );
		$form = new LoginForm ();
		$form->get('company')
		     ->setOptions(array('value_options' => $this->getCompany()
		));
		$request = $this->getRequest();
		if ($request->isPost ()) {
			$usrFilter = new UserFilter ();
			$form->setInputFilter($usrFilter->getInputFilter());
			$form->setData($request->getPost());
			
			if ($form->isValid ()) {
				$usrData = $form->getData(); 
				//var_dump($usrData); 
				//exit; 
				$usrFilter->exchangeArray($usrData); 
				$uAuth = $this->userAuthentication(); 
				
				//$uAuth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService'); 
				//$uAuth = $this->getServiceLocator()->get('User\Event\Authentication');
				// \Zend\Debug\Debug::dump($uAuth);
				$authAdapter = $uAuth->getAuthAdapter();
				// $authService = $uAuth->getAuthAdapter();
				
				$authAdapter->setTableName('user')
				            ->setIdentityColumn('username')
				            ->setCredentialColumn('password');
				$authAdapter->setIdentity($usrData['username']);
				$authAdapter->setCredential($usrData['password']);
				
				$result = $uAuth->getAuthService()->authenticate($authAdapter);
				if ($result->isValid()) {
					$stor = $authAdapter->getResultRowObject();
					// @todo get employee id
					$positionId = $stor->positionId; 
					//\Zend\Debug\Debug::dump($positionId); 
					//exit; 
					$positionService = $this->serviceLocator->get('positionService'); 
					$positionName = $positionService->getPositionNameById($positionId);  
	                				
					//\Zend\Debug\Debug::dump($positionId); 
					//\Zend\Debug\Debug::dump($positionName); 
					//exit;  
					
					$uAuth->getAuthService()->getStorage()->write(
							array(//'id'          => $resultRow->id,
								'username'   => $stor->username,
								'ipAddress'  => $request->getServer('REMOTE_ADDR'),
								'userAgent'  => $request->getServer('HTTP_USER_AGENT'),
								'role'       => $positionId,
								'company'    => $usrData['company'], 
								'employeeId' => $stor->employeeId, 	
							)
					); 
					
					/* $sessCont = new SessionContainer('my'); 
					$sessCont->role = $stor->role;
					$sessCont->id = $stor->id;
					$sessCont->company = $stor->company;
					$company = $this->getServiceLocator()->get('company');
					$company->setId('1');
					$company->setCompanyName('Permanent'); */
					//\Zend\Debug\Debug::dump($company); 
					// exit;
					// return array('authStatus' => '<li>Authenticated Successfully</li>','loginForm' => $form);
					// if ($stor->role == 'order') {
					return $this->redirect()->toRoute('home'); 
					
				} else {
					return array (
							'authStatus' => 'Invalid Username/Password',
							'loginForm' => $form 
					);
					$this->userAuthentication()->clearIdentity(); 
				}
			}
		}
		
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$agent = $_SERVER['HTTP_USER_AGENT'];
		}
		if (strlen(strstr($agent, "Firefox")) > 0) {
			//$browser = 'firefox';
			$info = '';
		} else {
			$info = 'Your browser is not firefox, some features may not work in this browser';
		}
		
		/* $viewmodel->setVariables ( array (
				'loginForm' => $form,
				'info' => $info 
		)
		// 'is_xmlhttprequest' => $is_xmlhttprequest //need for check this form is in modal dialog or not in view
		); 
		return $viewmodel; */
		return array (
				'loginForm' => $form,
				'info'      => $info 
		); 
		// return array('loginForm' => $form); 
	} 
	
	private function getCompany() {
		return $this->getLookupService()->getCompanyList();
	} 
	
	private function getLookupService() {
		return $this->getServiceLocator()->get('lookupService');
	} 
	
	public function logoutAction() {
		$this->userAuthentication()->clearIdentity(); 
		return $this->redirect()->toRoute('user'); 
	}
	
	public function pagenotfoundAction() {
		// $this->userAuthentication()->clearIdentity();
		// return $this->redirect()->toRoute('user');
		exit ();
	} 
}   