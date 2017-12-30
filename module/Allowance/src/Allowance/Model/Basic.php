<?php
namespace Allowance\Model;

use Allowance\Model\Initial;
    
class Basic {
	
	private $basic;
	
	/* public function __construct($basic) {
		$this->basic= $basic;
	} */
	
	public function getBasic() {
		
		$initial = new Initial('4500');
		$this->basic = $initial->getAmount();
		
		$allowanceInBasic = array('cola');
		
		foreach ($allowanceInBasic as $allowanceBasic) {
			$allowance = $this->getService($allowanceBasic);
			$this->basic += $allowance->getAmount();
		}
		return $this->basic;
	}
    
}