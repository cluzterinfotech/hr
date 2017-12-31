<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class SalaryStructureGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Salary Structure list',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 20,
			'showColumnFilters' => true 
	);  
	
	// Definition of headers 
	protected $headers = array ( 
			/*'id' => array (
					'title' => 'Id',
					'width' => '50' 
			),*/
			'salaryGrade' => array (
					'title' => 'Salary Grade',
					'filters' => 'text',
					'width' => '120'
			),
			'minValue' => array (
					'title' => 'Min',
					'width' => '100'
					//'filters' => 'text' 
			),
			'midValue' => array (
					'title' => 'Mid',
					'width' => '100'
					//'filters' => 'text' 
			),
			'maxValue' => array (
					'title' => 'Max',
					'width' => '100'
					//'filters' => 'text' 
			),
			'edit' => array (
					'title' => 'EDIT',
					'width' => '100'
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('salaryGrade')) {
			$query->where ( "salaryGrade like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('minValue')) {
			$query->where ( "minValue like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('midValue')) {
			$query->where ( "midValue like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('maxValue')) {
			$query->where ( "maxValue like '%" . $value . "%' " );
		} 
		$this->getHeader('edit')->getCell()->addDecorator('link', array(
				'url' => '/salarystructure/edit/%s',
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
