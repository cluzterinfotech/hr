<?php 
namespace Leave\Form; 

use Zend\InputFilter\Factory as InputFactory; 
use Zend\InputFilter\InputFilter; 
use Zend\InputFilter\InputFilterAwareInterface; 
use Zend\InputFilter\InputFilterInterface; 
use Payment\Model\DateMethods;


class AnnualLeaveFormValidator extends DateMethods implements InputFilterAwareInterface 
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
	            'name' => 'employeeId', 
	        	'required' => true,
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( ), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'joinDate', 
	            'required' => true, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ),'validators' => array(
	            	array('name' => 'Date') 
	            ),
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'positionId', 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array(), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'departmentId', 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( ), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'locationId', 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( ), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'leaveFrom', 
	            'required' => true, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array(
	            	array('name' => 'Date'),
	            ), 
	        ]));
	        
	        $inputFilter->add($factory->createInput(array(
	            'name' => 'leaveTo',
	        	'required' => true,
	        	'filters' => array(
	        		array('name' => 'StripTags'),
	        		array('name' => 'StringTrim'),
	        	),
	        	'validators' => array(
	        		array(
	        			'name' => 'Callback',
	        			'options' => array(
	        				'messages' => array(
	        					\Zend\Validator\Callback::INVALID_VALUE 
	        						=> 'The leave to date should be greater than from date',
	        				),
	        				'callback' => function($value, $context = array()) {
	        					return $this->isToDateGreaterOrEqual($context['leaveFrom'], $value); 
	        				}, 
	        			),
	        		),
	        	),
	        )));
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'advanceRequired', 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	                array ( 
	                    'name' => 'InArray', 
	                    'options' => array( 
	                        'haystack' => array(0,1), 
	                        'messages' => array( 
	                            'notInArray' => 'undefined' 
	                        ),
	                    ), 
	                ), 
	
	            ), 
	        ])); 
	 
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'address', 
	            'required' => true, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	            ), 
	        ])); 
	 
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'delegatedPositionId', 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	                /* array ( 
	                    'name' => 'InArray', 
	                    'options' => array( 
	                        'haystack' => array(0), 
	                        'messages' => array( 
	                            'notInArray' => 'undefined' 
	                        ),
	                    ), 
	                ),  */
	
	            ), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'daysEntitled', 
	            'required' => true, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	            ), 
	        ])); 
	 
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'outstandingBalance', 
	            'required' => true, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	            ), 
	        ])); 
	 
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'daysTaken', 
	            'required' => true, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	            ), 
	        ])); 
	 
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'thisLeaveDays', 
	            'required' => true, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	            ), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'revisedDays', 
	            'required' => true, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	            ), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'remainingDays', 
	            'required' => true, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	            ), 
	        ])); 
	        $this->inputFilter = $inputFilter;
        } 
        return $this->inputFilter;
    } 
} 