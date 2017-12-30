
<?php

namespace Leave\Model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AnnualLeaveApproval implements IApproval {
	protected $supervisorApprove;
	protected $hodApprove;
	protected $aprove;
	public function __construct(IApproval $supervisorApprove, IApproval $hodApprove) {
		$this->supervisorApprove = $supervisorApprove;
		$this->hodApprove = $hodApprove;
	}
	public function approve() {
		$this->supervisorApprove->approve ();
		$this->hodApprove->approve ();
	}
	public function reject() {
		$this->supervisorApprove->reject ();
		$this->hodApprove->reject ();
	}
	
	// put your code here
}
