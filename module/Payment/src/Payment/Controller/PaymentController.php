<?php

namespace Payment\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PaymentController extends AbstractActionController {
    	
	public function indexAction() {
        return new ViewModel();
	}
	
	
}