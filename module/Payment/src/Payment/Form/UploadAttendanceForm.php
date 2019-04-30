<?php 

namespace Payment\Form; 

use Zend\Form\Element;
use Zend\Form\Form;

class UploadAttendanceForm extends Form
{
	public function __construct($name = null, $options = array())
	{
		parent::__construct('AttendanceForm',$options); 
		$this->addElements(); 
	} 
    
	public function addElements()
	{
		// File Input
		$file = new Element\File('attendanceFile');
		$file->setLabel('Upload Attendance File :')
		     ->setAttribute('id','attendanceFile');
		$this->add($file); 
	} 
}   