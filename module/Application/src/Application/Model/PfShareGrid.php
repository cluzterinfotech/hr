<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class PfShareGrid extends AbstractTable { 
	
	protected $config = array (
		'name' => 'Pf Share list',
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
			'employeeName' => array (
					'title' => 'Employee Name',
					'filters' => 'text',
					'width' => '120'
			),
			'employeeShare' => array (
					'title' => 'Employee Share',
					'width' => '100',
					'filters' => 'text' 
			),
			'companyShare' => array (
					'title' => 'Company Share',
					'width' => '100',
					'filters' => 'text' 
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) {
			$query->where ( "employeeName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeShare')) {
			$query->where ( "employeeShare like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('companyShare')) {
			$query->where ( "companyShare like '%" . $value . "%' " );
		} 
		$this->getHeader('edit')->getCell()->addDecorator('link', array(
				'url' => '/pfshare/edit/%s',
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
