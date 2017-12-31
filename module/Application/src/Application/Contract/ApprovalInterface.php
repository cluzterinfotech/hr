<?php

namespace Application\Contract;

interface ApprovalInterface { 
	
	public function checkIsApprover($applicant,$approvalLevel,$approver); 
    
}