<?php 

namespace Employee\Form; 

use Zend\InputFilter\Factory as InputFactory; 
use Zend\InputFilter\InputFilter; 
use Zend\InputFilter\InputFilterAwareInterface; 
use Zend\InputFilter\InputFilterInterface; 

class NewEmployeeFormValidator implements InputFilterAwareInterface 
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
	            'name' => 'employeeNumber', 
	            'required' => true, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	            ), 
	        ])); 
           
	       /*$inputFilter->add($factory->createInput([ 
	            'name' => 'employeeName', 
	            'required' => true, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	            ), 
	        ])); 
	 
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'placeOfBirth', 
	            'required' => false,
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	            ), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'gender', 
	        	//'required' => false, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	               
	            ), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'maritalStatus', 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	               //  array('name' => 'InArray'),  
	            ),  
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'religion', 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	                
	            ), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'nationality', 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	                
	            ), 
	        ])); 
	 
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'numberOfDependents', 
	            'required' => true, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	            ), 
	        ])); 
	 
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'state', 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	                
	            ), 
	        ])); 
	 
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'empAddress', 
	            'required' => true, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array(), 
	        ])); 
	         
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'officeExtention', 
	            'required' => false, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array(), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'empMobile', 
	            'required' => true, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array(), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'empTelephone', 
	            'required' => false, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array(),  
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'empEmail', 
	            'required' => true, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array(
	            	array ('name' => 'EmailAddress'),
	            ), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'empPassport', 
	            'required' => false, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array(), 
	        ])); 
	         
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'license', 
	            'required' => false,
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array(), 
	        ])); 
	        
	        //$inputFilter->add($factory->createInput([ 
	            //'name' => 'empType', 
	            //'filters' => array( 
	                //array('name' => 'StripTags'), 
	                //array('name' => 'StringTrim'), 
	            //), 
	            //'validators' => array(),  
	        //]));
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'empSalaryGrade', 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array(), 
	        ])); 
	 
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'empJobGrade', 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array(), 
	        ])); 
	 
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'empBank', 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array(), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([
	        		'name' => 'accountNumber',
	        		'required' => false,
	        		'filters' => array(
	        				array('name' => 'StripTags'),
	        				array('name' => 'StringTrim'),
	        		),
	        		'validators' => array(),
	        ]));
	        
	        $inputFilter->add($factory->createInput([
	        		'name' => 'referenceNumber',
	        		'required' => false,
	        		'filters' => array(
	        				array('name' => 'StripTags'),
	        				array('name' => 'StringTrim'),
	        		),
	        		'validators' => array(),
	        ]));
	 
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'empPosition', 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array(), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'isPreviousContractor', 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array(), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'empLocation', 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array(), 
	        ])); 
	        
	        $inputFilter->add($factory->createInput([ 
	            'name' => 'skillGroup', 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array(), 
	        ])); 
	 
	        /*$inputFilter->add($factory->createInput([ 
	            'name' => 'empInitialSalary', 
	            'required' => true, 
	            'filters' => array( 
	                array('name' => 'StripTags'), 
	                array('name' => 'StringTrim'), 
	            ), 
	            'validators' => array( 
	                array ( 
	                    'name' => 'float', 
	                ), 
	            ), 
	        ]));*/ 
	        $this->inputFilter = $inputFilter;
        } 
        
        return $this->inputFilter; 
    } 
} 