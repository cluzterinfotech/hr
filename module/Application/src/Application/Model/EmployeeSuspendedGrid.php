<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class EmployeeSuspendedGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Employee Suspended List ',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 15,
			'showColumnFilters' => true 
	);
	
	// Definition of headers 
	protected $headers = array (
			/* 'id' => array (
				'title' => 'Id',
				'width' => '50' 
			), */ 
			'employeeName' => array (
				'title' => 'Employee Name',
				'filters' => 'text' 
			),
			'suspendFrom' => array (
				'title' => 'Suspend From',
				'filters' => 'text' 
			),
			'suspendTo' => array (
					'title' => 'Suspend To',
					'filters' => 'text'
			), 
		    'removeSus' => array (
					'title' => 'DELETE'
			), 
			/*'delete' => array (
					'title' => 'DELETE',
					'width' => '50'
			)*/ 
	) 
	// 'active' => array('title' => 'Active' , 'width' => 100 , 'filters' => array( null => 'All' , 1 => 'Active' , 0 => 'Inactive')),
	;  
	public function init() { }
	
	protected function initFilters($query) {
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "e.id like '%" . $value . "%' " );
		}*/
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) {
			$query->where ( "employeeName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('suspendFrom')) {
			$query->where ( "suspendFrom like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('suspendTo')) {
			$query->where ( "suspendTo like '%" . $value . "%' " );
		}
		$this->getHeader('removeSus')->getCell()->addDecorator('link', array (
				'url' => '/employeesuspend/delete/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Delete'
		));  
		//$this->getHeader('remove')->getCell()
		     //->addDecorator('class', array('class' => 'removeRowSused'));
		
	}    
} 
