<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class SpecialLoanGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Special Loan List',  
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10, 
			'showColumnFilters' => true 
	);  
	
	// Definition of headers 
	protected $headers = array (
			/*'id' => array (
					'title' => 'Remove',
					'width' => '50' 
			),*/ 
			'employeeName' => array (
				'title' => 'Employee Name',
				'filters' => 'text' 
			),
			
			'splLoanAmount' => array (
				'title' => 'Special Loan Amount',
				//'filters' => 'text'
			),
			'numberOfMonthsSplLoanDue' => array (
				'title' => 'Months ', 
				//'filters' => 'text'
			),
			'monthlyDue' => array (
				'title' => 'Monthly Due ', 
				//'filters' => 'text'
			),'loanDate' => array (
			    'title' => 'Loan Date',
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
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('loanDate')) {
			$query->where ( "loanDate like '%" . $value . "%' " );
		}    
		if ($value = $this->getParamAdapter()->getValueOfFilter('loanAmount')) {
			$query->where ( "loanAmount like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('numberOfMonthsLoanDue')) {
			$query->where ( "numberOfMonthsLoanDue like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('monthlyDue')) {
			$query->where ( "monthlyDue like '%" . $value . "%' " ); 
		} */
		
		$this->getHeader('remove')->getCell()->addDecorator('link', array (
				'url' => '/specialloan/remove/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Remove'
		)); 
		$this->getHeader('remove')->getCell()
		     ->addDecorator('class', array('class' => 'removeSpecialLoan'));  
		
		/* $this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/location/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); */ 
		
	}
} 