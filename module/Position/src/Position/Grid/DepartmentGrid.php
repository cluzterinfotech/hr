<?php

namespace Position\Grid;

use ZfTable\AbstractTable;

class DepartmentGrid extends AbstractTable {
	protected $config = array (
			'name' => 'Department List',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 15,
			'showColumnFilters' => true 
	);
	
	// Definition of headers
	protected $headers = array (
			'departmentId' => array (
					'title' => 'Department ID',
					'width' => '100',
					'filters' => 'text' 
			),
			'departmentName' => array (
					'title' => 'Department NAME',
					'filters' => 'text' 
			),
			'deptFunctionCode' => array (
					'title' => 'Department Function Code',
					'filters' => 'text' 
			) 
	)
	// 'positionLevelId' => array('title' => 'LEVEL' , 'filters' => 'text'),
	// 'active' => array('title' => 'Active' , 'width' => 100 , 'filters' => array( null => 'All' , 1 => 'Active' , 0 => 'Inactive')),
	// 'edit' => array('title' => 'EDIT'),
	// 'delete' => array('title' => 'DELETE', 'width' => '50') ,
	;
	public function init() {
	}
	protected function initFilters($query) {
		if ($value = $this->getParamAdapter ()->getValueOfFilter ( 'departmentId' )) {
			$query->where ( "departmentId like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter ()->getValueOfFilter ( 'departmentName' )) {
			$query->where ( "departmentName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter ()->getValueOfFilter ( 'deptFunctionCode' )) {
			$query->where ( "deptFunctionCode like '%" . $value . "%' " );
		}
		/*
		 * if ($value = $this->getParamAdapter()->getValueOfFilter('positionLevelId')) {
		 * $query->where("positionLevelId like '%".$value."%' ");
		 * }
		 */
		
		/*
		 * $this->getHeader('edit')->getCell()->addDecorator('link', array(
		 * 'url' => '/section/edit/sectionId/%s',
		 * 'vars' => array('sectionId'),
		 * 'txt' => 'Edit',
		 * ));
		 * $this->getHeader('delete')->getCell()->addDecorator('link', array(
		 * 'url' => '/section/delete/sectionId/%s',
		 * 'vars' => array('sectionId'),
		 * 'txt' => '<span class="delete">Delete</span>',
		 * ));
		 * /* $this->getHeader('name')->getCell()->addDecorator('delete', array(
		 * 'url' => '/table/edit/id/%s',
		 * 'vars' => array('idcustomer'),
		 *
		 * )
		 * );
		 */
	}
}