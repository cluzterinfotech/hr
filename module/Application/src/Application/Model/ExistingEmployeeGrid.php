<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class ExistingEmployeeGrid extends AbstractTable {
	
	protected $config = array ( 
			'name' => '', 
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
			),*/'employeeName' => array (
					'title' => 'Employee Name',
					'filters' => 'text'  
			),/*'departmentName' => array (
					'title' => 'Department', 
					'filters' => 'text'  
			),*/'locationName' => array (
					'title' => 'Location', 
					'filters' => 'text' 
			),'salaryGrade' => array (
					'title' => 'Salary Grade',
					'filters' => 'text' 
			),/*'jobGrade' => array (
					'title' => 'Job Grade',
					'filters' => 'text'  
			),*/'edit' => array ( 
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
			$query->where ( "id like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) {
			$query->where ( "employeeName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('locationName')) {
			$query->where ( "locationName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('departmentName')) {
			$query->where ( "departmentName like '%" . $value . "%' " );
		} 
		if ($value = $this->getParamAdapter()->getValueOfFilter('salaryGrade')) {
			$query->where ( "salaryGrade like '%" . $value . "%' " );
		} 
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/newemployee/editexisting/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Edit Existing'
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
