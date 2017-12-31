<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class AffiliationAmountGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Affiliation Amount list',
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
			'deductionName' => array (
				'title' => 'Deduction Name',
				'filters' => 'text' 
			),
			'amount' => array (
					'title' => 'Amount',
					'filters' => 'text'
			),
			'companyName' => array (
					'title' => 'Company',
					'filters' => 'text'
			), 
			/*'adjustedAmount' => array (
					'title' => 'New Salary',
					//'filters' => 'text'
			),*/ 
		    'edit' => array (
					'title' => 'Edit Existing'
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('deductionName')) {
			$query->where ( "deductionName like '%" . $value . "%' " );
		} 
		if ($value = $this->getParamAdapter()->getValueOfFilter('amount')) {
			$query->where ( "amount like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('companyName')) {
			$query->where ( "companyName like '%" . $value . "%' " );
		} 
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				//'url' => '/affiliationamount/updateexisting/%s',
				'url' => '#',
				'vars' => array (
						'id'
				),
				'txt' => 'Edit Existing'
		));   
		/*$this->getHeader('remove')->getCell()->addDecorator('link', array (
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