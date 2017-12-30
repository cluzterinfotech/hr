<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class EmployeeAllowanceGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Employee Allowance list',
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
				'title' => 'Employee Number',
				'filters' => 'text' 
			),
			'amount' => array (
				'title' => 'Amount',
				'filters' => 'text' 
			),
			'tableName' => array (
					'title' => 'Allowance Name',
					//'filters' => 'text'
			),
			'edit' => array (
				'title' => 'EDIT'
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
			$query->where ( "e.id like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) {
			$query->where ( "employeeName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('amount')) {
			$query->where ( "amount like '%" . $value . "%' " );
		}
		$this->getHeader('edit')->getCell()->addDecorator('link', array(
				'url' => '/employeefixedallowance/edit/%s/%s',
				'vars' => array(
						'id','tableName'
				),
				'txt' => 'Edit'
		)); 
		/* $this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/location/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); */ 
	}
}
