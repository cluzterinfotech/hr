<?php 

namespace Payment\Form; 

use Zend\Form\Element;
use Zend\Form\Form;

class UploadPhotoForm extends Form
{
	public function __construct($name = null, $options = array())
	{
		parent::__construct('empPhotoForm',$options); 
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype','multipart/form-data');
		
		$this->add(array(
		    'name' => 'employeePhoto',
		    'type' => 'Zend\Form\Element\Select',
		    'attributes' => array(
		        'class' => 'employeePhoto',
		        'id' => 'employeePhoto',
		        'required' => 'required',
		    ),
		    'options' => array(
		        'label' => 'Employee Name*',
		    ),
		));
		
		
		$this->add(array(
		    'name' => 'photoFile',
		    'attributes' => array(
		        'type'  => 'file',
		        'class' => 'photoFile',
		        'id' => 'photoFile',
		        'required' => 'required',
		    ),
		    'options' => array(
		        'label' => 'Employee Photo*',
		    ),
		));
		
		
		$this->add(array(
		    'name' => 'submit',
		    'attributes' => array(
		        'type'  => 'submit',
		        'value' => 'Upload'
		    ),
		)); 
		
		
		//$this->addElements(); 
		
		
	} 
    
	/*public function addElements()
	{
		// File Input
	    //$emp = new Element\Select('employeePhoto');
		//$emp->setLabel('Select Employee :')
		    //->setAttribute('id','employeePhoto');
		$file = new Element\File('photoFile');
		$file->setLabel('Upload Photo :')
		     ->setAttribute('id','photoFile');
		     $this->add($file);
		     //$this->add($emp);  
	} */
}   