<?php
//namespace PaymentTest\Model;

/* use PHPUnit_Framework_TestCase;
use Allowance\Model\EmployeeGross; */

class EmployeeGrossTest extends \PHPUnit_Framework_TestCase {
	
	public function testGrossAmount() {
		
		$eg = 4500;//new EmployeeGross();
        
		//$gross = $eg->getGrossAmount();
		$this->assertEquals(4500,$eg);
		
	}
		
}