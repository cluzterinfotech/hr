<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class SalaryGradeAllowanceGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Salary Grade Allowance list',
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
			'allowanceName' => array (
				'title' => 'Allowance',
				'filters' => 'text' 
			),
			'salaryGrade' => array (
				'title' => 'Salary Grade',
				'filters' => 'text' 
			),
			'amount' => array (
					'title' => 'Amount',
					'filters' => 'text'
			),
			'companyName' => array (
					'title' => 'Company',
					//'filters' => 'text'
			), 
			/*'adjustedAmount' => array (
					'title' => 'New Salary',
					//'filters' => 'text'
			),*/ 
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
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "e.id like '%" . $value . "%' " );
		}*/
		if ($value = $this->getParamAdapter()->getValueOfFilter('allowanceName')) {
			$query->where ( "allowanceName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('salaryGrade')) {
			$query->where ( "salaryGrade like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('amount')) {
			$query->where ( "amount like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('companyName')) {
			$query->where ( "companyName like '%" . $value . "%' " );
		} 
		$this->getHeader('remove')->getCell()->addDecorator('link', array (
				'url' => '/salarygradeallowance/remove/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Remove' 
		));  
		$this->getHeader('remove')->getCell() 
		     ->addDecorator('class', array('class' => 'removeSgAllowanceRow')); 
		/* $this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/location/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); */ 
	}
} 