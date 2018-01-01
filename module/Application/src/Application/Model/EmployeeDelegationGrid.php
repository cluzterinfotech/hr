<?php

namespace Application\Model; 

use ZfTable\AbstractTable;

class EmployeeDelegationGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Employee Delegation List', 
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10, 
			'showColumnFilters' => true 
	); 
	
	// Definition of headers 
	protected $headers = array (
			'id' => array (
					'title' => 'Id',
					'width' => '50' 
			), 
			'employeeName' => array (
					'title' => 'Employee Name',
					'filters' => 'text' 
			),
			'delegatedEmp' => array (
					'title' => 'Delegated Employee',
					//'filters' => 'text'
			),'delegatedFrom' => array (
					'title' => 'Delegated From',
					//'filters' => 'text' 
			),
			'delegatedTo' => array (
					'title' => 'Delegated To',
					//'filters' => 'text'
			),  
			'remove' => array (
					'title' => 'REMOVE'
			)/* ,
			'delete' => array (
					'title' => 'DELETE',
					'width' => '50'
			) */
	)
	// 'active' => array('title' => 'Active' , 'width' => 100 , 'filters' => array( null => 'All' , 1 => 'Active' , 0 => 'Inactive')),
	; 
	public function init() { }
	
	protected function initFilters($query) {
		if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "id like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) {
			$query->where ( "employeeName like '%" . $value . "%' " );
		}
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('positionNam')) {
			$query->where ( "positionNam like '%" . $value . "%' " );
		}*/ 
		$this->getHeader('remove')->getCell()->addDecorator('link', array (
				'url' => '/delegation/remove/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Remove'
		)); 
		$this->getHeader('remove')->getCell()
		     ->addDecorator('class', array('class' => 'removeDelegation')); 
	}
} 