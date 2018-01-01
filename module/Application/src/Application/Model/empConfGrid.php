<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class EmpConfGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Employee Confirmation  List', 
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10, 
			'showColumnFilters' => true 
	);
	
	// Definition of headers 
	protected $headers = array (
			'id' => array (
					'title' => 'Remove',
					'width' => '50' 
			),
			'employeeNumberConfirmation' => array (
					'title' => 'Employee Number',
					'filters' => 'text' 
			),
			'effectiveDate' => array (
					'title' => 'Confirmation Date',
					//'filters' => 'text' 
			),
			'appliedDate' => array (
					'title' => 'applied Date  ',
					'filters' => 'text'
			),
			'oldSalary' => array (
					'title' => 'old Salary ',
					'filters' => 'text'
			),
			'oldCola' => array (
					'title' => 'old Cola ',
					//'filters' => 'text'
			),
			'adjustedAmount' => array (
					'title' => 'adjusted Amount ',
					//'filters' => 'text'
			), 
			'percentage' => array (
					'title' => 'percentage   ',
					//'filters' => 'text'
			), 
			'confirmationNotes' => array (
					'title' => 'confirmation Notes   ',
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeId')) {
			$query->where ( "employeeId like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('totalMonths')) {
			$query->where ( "totalMonths like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('advanceAmount')) {
			$query->where ( "advanceAmount like '%" . $value . "%' " );
		}
		
		$this->getHeader('remove')->getCell()->addDecorator('link', array (
				'url' => '/advancehousing/remove/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Remove'
		)); 
		$this->getHeader('remove')->getCell()
		     ->addDecorator('class', array('class' => 'removeAdvanceHousing')); 
		/* $this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/location/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); */
	}
} 