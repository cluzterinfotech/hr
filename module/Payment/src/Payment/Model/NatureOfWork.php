<?php 
namespace Payment\Model; 

use Payment\Model\AbstractAllowance; 

class NatureOfWork extends AbstractAllowance { 
    
    
    public function calculateAmount(Employee $employee,DateRange $dateRange) {
    	// @todo implement condition
    	//echo "noj";
    	//exit; 
        $sgService = $this->service->get('salaryGradeService');
        $splAmount = $sgService->getSpecialAmount($employee->getEmployeeNumber(),$dateRange,$this->getTableName());
        //\Zend\Debug\Debug::dump($splHous);
        //exit;
        if($splAmount[0] == 1) {
            return $splAmount[1];
        }
    	$company = $this->service->get('company'); 
    	/*if($this->ishaveNatureOfJob($employee,$company,$dateRange)) {
    		echo "having";
    		exit;
    	}*/
    	if($this->ishaveNatureOfJob($employee,$company,$dateRange)) {
		    return $this->getBasic($employee,$company,$dateRange)
		    * ($this->getNojPercentage()/100);  
		}
		return 0;
	}
	
	public function calculateExemption(Employee $employee,DateRange $dateRange) {
		return 0;
	}
	
	private function getNojPercentage() {
		return 20;
	}
	
	private function ishaveNatureOfJob(Employee $employee,Company $company,DateRange $dateRange) { 
			$positionId = $employee->getEmpPosition();
			$companyId = $company->getId();
			// Nature of job only for permanent
			// @todo check condition from db
			if($companyId != 1) {
				// fetch from db entry
				return 0; 
			}
			// Note:it is salary grade Id not salary grade itself
			return $this->companyAllowance
			            ->isHaveNatureOfJob($positionId,$company,$dateRange);
	}
    
	public function getTableName() {
		return "NatureofWork";
	}
}   