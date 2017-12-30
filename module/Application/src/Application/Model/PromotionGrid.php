<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class PromotionGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Promotion list',
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
			
			'currentSalaryGrade' => array (
					'title' => 'Current Salary Grade',
					//'filters' => 'text'
			),
			'salaryGrade' => array (
					'title' => 'Promoted Salary Grade',
					//'filters' => 'text'
			),'Current_Initial_Salary' => array (
					'title' => 'Current Initial',
					//'filters' => 'text'
			),
			'promotedInitialSalary' => array (
					'title' => 'Promoted Initial',
					//'filters' => 'text'
			),'promotionDate' => array (
					'title' => 'Promotion Date',
					//'filters' => 'text' 
			),'remove' => array (
					'title' => 'Remove',
					//'width' => '50'
			)
			/*'edit' => array (
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) {
			$query->where ( "employeeName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('currentSalaryGrade')) {
			$query->where ( "currentSalaryGrade like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('salaryGrade')) {
			$query->where ( "salaryGrade like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('Current_Initial_Salary')) {
			$query->where ( "Current_Initial_Salary like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('promotedInitialSalary')) {
			$query->where ( "promotedInitialSalary like '%" . $value . "%' " );
		}
		$this->getHeader('remove')->getCell()->addDecorator('link', array (
			'url' => '/promotion/remove/%s',
			'vars' => array (
					'id' 
			),
			'txt' => 'Remove' 
		)); 
		
		$this->getHeader('remove')->getCell()
		     ->addDecorator('class', array('class' => 'removePromotion'));
		/*
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/location/edit/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Edit'
		)); */
		/* $this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/location/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); */
	}
}
