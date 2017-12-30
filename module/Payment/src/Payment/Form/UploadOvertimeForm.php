<?php 

namespace Payment\Form; 

use Zend\Form\Element;
use Zend\Form\Form;

class UploadOvertimeForm extends Form
{
	public function __construct($name = null, $options = array())
	{
		parent::__construct('Overtime Form', $options);
		$this->addElements();
	}

	public function addElements()
	{
		// File Input
		$file = new Element\File('otFile');
		$file->setLabel('Upload Overtime File :')
		     ->setAttribute('id','otFile');
		$this->add($file); 
	} 
} 