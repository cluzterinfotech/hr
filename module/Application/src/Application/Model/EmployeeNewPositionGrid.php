<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class EmployeeNewPositionGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Employee New Position List', 
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
    	    'positionNamCurr' => array (
    	        'title' => 'Current Position',
    	        //'filters' => 'text'
    	    ),
			'positionNam' => array (
					'title' => 'New Position',
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
		//if ($value = $this->getParamAdapter()->getValueOfFilter('p.positionName')) {
			//$query->where ( "p.positionName like '%" . $value . "%' " );
		//} 
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('positionNamCurr')) {
		    $query->where ( "positionNamCurr like '%" . $value . "%' " );
		}*/
		
		$this->getHeader('remove')->getCell()->addDecorator('link', array (
				'url' => '/positionmovement/remove/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Remove'
		)); 
		$this->getHeader('remove')->getCell()
		     ->addDecorator('class', array('class' => 'removeNewPosition')); 
	}
} 