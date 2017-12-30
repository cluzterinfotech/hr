<?php 

namespace Application\Model;

use ZfTable\AbstractTable;

class EmployeeRatingGrid extends AbstractTable {
	
	protected $config = array (
		'name' => 'Employee Rating list',
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
			'empRating' => array (
				'title' => 'Rating',
				'filters' => 'text' 
			),
			/*'edit' => array (
					'title' => 'Edit'
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) {
			$query->where ( "employeeName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('empRating')) {
			$query->where ( "empRating like '%" . $value . "%' " );
		} 
		/*$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/telephone/remove/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Edit'
		));*/ 
		$this->getHeader('remove')->getCell()->addDecorator('link', array (
				'url' => '/employeerating/remove/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Remove'
		)); 
		$this->getHeader('remove')->getCell()
		     ->addDecorator('class', array('class' => 'removeRow'));
		/* $this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/location/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); */
	}
}
