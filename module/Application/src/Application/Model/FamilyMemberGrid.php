<?php

namespace Application\Model;

use ZfTable\AbstractTable;

class FamilyMemberGrid extends AbstractTable {
	
	protected $config = array (
			'name' => 'Family Member list',
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
			'memberTypeName' => array (
					'title' => 'Member Type',
					'filters' => 'text' 
			),
			'memberName' => array (
					'title' => 'Name',
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
		/*if ($value = $this->getParamAdapter()->getValueOfFilter('id')) {
			$query->where ( "id like '%" . $value . "%' " );
		}*/ 
		if ($value = $this->getParamAdapter()->getValueOfFilter('employeeName')) {
			$query->where ( "employeeName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('memberTypeName')) {
			$query->where ( "memberTypeName like '%" . $value . "%' " );
		}
		if ($value = $this->getParamAdapter()->getValueOfFilter('memberName')) {
			$query->where ( "memberName like '%" . $value . "%' " );
		}

		$this->getHeader('edit')->getCell()->addDecorator('link', array (
				'url' => '/familymember/edit/%s', 
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
