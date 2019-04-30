<?php 

namespace Employee\Form; 

use Zend\Form\Element;
use Zend\Form\Form;

class UploadPhoneForm extends Form
{
	public function __construct($name = null, $options = array())
	{
		parent::__construct('phoneForm',$options); 
		$this->addElements(); 
	} 
    
	public function addElements()
	{
		// File Input
		$file = new Element\File('phoneFile');
		$file->setLabel('Upload Phone Exceeding File :')
		     ->setAttribute('id','phoneFile'); 
		$this->add($file);  
	} 
}   