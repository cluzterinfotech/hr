<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class EmployeeAnniversaryIncrementGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Employee Anniversary Increment', 
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 15,
			'showColumnFilters' => true 
	);      
	
	// Definition of headers  
	protected $headers = array (
			'employeeName' => array (
				'title' => 'Employee Name',
				'filters' => 'text' 
			),
			'oldAmount' => array (
				'title' => 'Old Initial',
				'filters' => 'text' 
			),
			'newAmount' => array (
					'title' => 'New Initial',
					'filters' => 'text'
			),  
		    'Edit' => array (
					'title' => 'Edit/Update'
			) 
	) 
	; 
	public function init() { }
	
	protected function initFilters($query) { 
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) {
			$query->where ( "employeeName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('oldAmount')) {
			$query->where ( "oldAmount like '%" . $value . "%' " );
		}  
		if ($value = $this->getParamAdapter()->getValueOfFilter('newAmount')) {
			$query->where ( "newAmount like '%" . $value . "%' " ); 
		} 
		$this->getHeader('Edit')->getCell()->addDecorator('link', array (
				'url' => '/increment/edit/%s',
				'vars' => array (
						'id' 
				),
				'txt' => 'Edit/Update' 
		));  
		/*$this->getHeader('remove')->getCell() 
		     ->addDecorator('class', array('class' => 'removeEmployeeInitialRow'));*/    
	} 
} 