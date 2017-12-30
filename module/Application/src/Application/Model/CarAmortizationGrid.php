<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class CarAmortizationGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Car Amortization list',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10,
			'showColumnFilters' => true 
	); 
	
	// Definition of headers 
	protected $headers = array (
			/*'id' => array (
					'title' => 'Id',
					'width' => '50' 
			),*/
			'employeeName' => array (
					'title' => 'Employee Name',
					'filters' => 'text' 
			),
			'paidAmount' => array (
					'title' => 'Amount',
					//'filters' => 'text'
			),'paidDate' => array (
					'title' => 'Paid Date',
					//'filters' => 'text'
			),'numberOfMonths' => array (
					'title' => 'Number Of Months',
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
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "id like '%" . $value . "%' " );
		}*/ 
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) {
			$query->where ( "employeeName like '%" . $value . "%' " );
		}
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('paidAmount')) {
			$query->where ( "paidAmount like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('paidDate')) {
			$query->where ( "paidDate like '%" . $value . "%' " );
		}*/
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/amortization/edit/%s', 
				'vars' => array (
						'id'
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
