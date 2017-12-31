<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class EmployeeSpecialAmountGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Employee Special Amount ', 
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
			'effectiveDate' => array (
				'title' => 'effective Date',
				//'filters' => 'text' 
			),			
			'allowanceId' => array (
				'title' => 'allowance Name',
				'filters' => 'text' 
			),	      
	      'oldAmount' => array (
				'title' => 'Old Amount',
				//'filters' => 'text' 
			),
			'amount' => array (
					'title' => 'New Amount',
					//'filters' => 'text'
			),  'addedStatus' => array (
			    'title' => 'Status',
			    //'filters' => 'text'
			),
		    'remove' => array (
					'title' => 'REMOVE'
			) 
	) 
	; 
	public function init() { }
	
	protected function initFilters($query) { 
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) {
			$query->where ( "employeeName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('allowanceId')) {
			$query->where ( "allowanceId like '%" . $value . "%' " );
		}  
		//if ($value = $this->getParamAdapter()->getValueOfFilter('newAmount')) {
			//$query->where ( "newAmount like '%" . $value . "%' " ); 
		///} 
		$this->getHeader('remove')->getCell()->addDecorator('link', array (
				'url' => '/allowancespecialamount/remove/%s',
				'vars' => array (
						'id' 
				),
				'txt' => 'Remove' 
		));  
		$this->getHeader('remove')->getCell() 
		     ->addDecorator('class', array('class' => 'removeSpecialAmountRow'));  
	}
} 