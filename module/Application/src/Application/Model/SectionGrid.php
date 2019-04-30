<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class SectionGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Section list',
			'showPagination' => true,
			'showQuickSearch' => false,
			'showItemPerPage' => true,
			'itemCountPerPage' => 10,
			'showColumnFilters' => true 
	);
	
	// Definition of headers 
	protected $headers = array (
			'id' => array (
					'title' => 'Id',
					'width' => '50' 
			),
			'sectionName' => array (
					'title' => 'Section Name',
					'filters' => 'text' 
			),
			'sectionCode' => array (
					'title' => 'Section Code',
					'filters' => 'text' 
			),'departmentName' => array (
					'title' => 'Dapartment Name',
					'filters' => 'text' 
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
		if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "id like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('sectionName')) {
			$query->where ( "sectionName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('sectionCode')) {
			$query->where ( "sectionCode like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('departmentName')) {
			$query->where ( "departmentName like '%" . $value . "%' " );
		}
		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/section/edit/%s',
				'vars' => array (
						'id'
				),
				'txt' => 'Edit'
		) );
		/* $this->getHeader('delete')->getCell()->addDecorator('link', array(
				'url' => '/location/delete/%s',
				'vars' => array(
						'id'
				),
				'txt' => '<span class="delete">Delete</span>'
		)); */
	}
}
