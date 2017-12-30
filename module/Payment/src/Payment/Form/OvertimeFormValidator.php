<?php 
namespace Payment\Form; 

use Zend\InputFilter\Factory as InputFactory; 
use Zend\InputFilter\InputFilter; 
use Zend\InputFilter\InputFilterAwareInterface; 
use Zend\InputFilter\InputFilterInterface; 
use Payment\Model\DateMethods;

class OvertimeFormValidator extends DateMethods implements InputFilterAwareInterface 
{ 
    protected $inputFilter; 
    
    public function setInputFilter(InputFilterInterface $inputFilter) 
    { 
        throw new \Exception("Not used"); 
    } 
    
    public function getInputFilter() 
    { 
        if (!$this->inputFilter) 
        { 
            $inputFilter = new InputFilter(); 
            $factory = new InputFactory(); 
            
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'empIdOvertime', 
	        	'required' => true,
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( ), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'employeeNoNOHours', 
	            'required' => true, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ),'validators' => array(
	            	//array('name' => 'Date') 
	            ),
	        ]));

	        $inputFilter->add($factory->createInput([ 
	        	'name' => 'employeeNoHOHours', 
	        	'required' => true,
	        	'filters' => array( 
	        		array('name' => 'StripTags'),
	        		array('name' => 'StringTrim'),
	        	),'validators' => array(
	        		//array('name' => 'Date')
	        	), 
	        ]));     
	        
	        $this->inputFilter = $inputFilter;
        } 
        return $this->inputFilter;
    } 
} 