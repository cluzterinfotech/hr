<?php
namespace Allowance\Test;

use Allowance\Model\CalcTrial;

class CalcTrialTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CalcTrial
     */
    protected $object;
    
    protected function setUp()
    {
        $this->object = new CalcTrial();
    }
    
    public function testMyAdd()
    {
    	$x = true;
    	$expected = 10;
    	$this->assertTrue($x);
    	$this->assertEquals($expected, $this->object->add('5','5'));
    }
}
?>