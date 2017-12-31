<?php

namespace Payment\Model; 

use Payment\Model\Payment;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventManagerInterface;

class UpdateAllAllowance extends Payment 
                         implements ListenerAggregateInterface  { 
    
    
	public function updateAllAllowance() {
		
	}
	
	/*
	 * effectiveDate
	 */ 
	public function reviseAllAllowance() {
		
		// get all allowance order By sequence
		// check is the updatedAllowance
		// update current allowance and other in the sequence 
	}
	
	public function updateInitial() {
		
	}
    public function detach(EventManagerInterface $events)
    {}

    public function attach(EventManagerInterface $events)
    {}
   
}   